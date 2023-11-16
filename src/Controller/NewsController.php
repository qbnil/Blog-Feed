<?php
// src/Controller/NewsController.php
// наше пространство имен по конвенции
namespace App\Controller;

// импорты
use App\Entity\Comments;
use App\Entity\News;
use App\Entity\Tags;
use App\Forms\AddNewsForm;
use App\Forms\CommentsForm;
use App\Repository\CommentsRepository;
use App\Repository\NewsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
/*
 * 1) I need to create a new form field for submitting tags for the new with ; separator
 * 2) I need to get all the submitted tags and create an array without ;
 * 3) persist and flush changes
 * 4) Iterate over an array in twig and display tags
 * -------------------------------------------
 * 5) Make tags clickable
 * 6) When the tag is clicked the page should reload and display only the news that relate to that tag
 * 7) To all the news button (get back buttton)
 */


   // аттрибут для указания пути
    #[Route('/', name: 'all_the_news')]
    public function createNews(EntityManagerInterface $entityManager, Request $request): Response
    {
        // создаем инстанс класса News
        $createNew = new News();

        // инициализация
        $createNew->setCreatedAtDateAndTime(new \DateTime());

        // достаем класс репозитория Тэгов
        $tagsRepo = $entityManager->getRepository(Tags::class);
        $newsForm = $this->createForm(AddNewsForm::class, $createNew);
        $newsForm->handleRequest($request);


        if ($newsForm->isSubmitted() && $newsForm->isValid()) {

            $response = $request->request->get('add_news_form')['YourTags'];
            if($response[-1] == ';') {

                $responseTags = preg_split("/;/", $response, flags: PREG_SPLIT_NO_EMPTY);
            }
            else {

                $responseTags = explode(';', $response);
            }


// If the tag doesn't exist, a new Tag entity is created, associated with the News entity, and both are persisted.
// If the tag already exists, it's retrieved from the database, associated with the News entity, and no new Tag entity is created.

            foreach ($responseTags as $singleTag) {
                $foundTag = $tagsRepo->findOneBy(['tagName' => $singleTag]);

                if (empty($foundTag)) {
                    $tag = new Tags();
                    $tag->setTagName($singleTag);

                    $createNew->addTag($tag);
                    $tag->addNews($createNew);
                    $entityManager->persist($tag);
                    $entityManager->persist($createNew);

                } else {
                    $createNew->addTag($foundTag);
                }
            }

            $entityManager->flush();

            return $this->redirect($request->getUri());

        }

        $repository = $entityManager->getRepository(News::class);
        $allNews = $repository->findAll();
        $allTags = $tagsRepo->findAll();
        return $this->render('news/news.html.twig', [
            'create_new_form' => $newsForm->createView(),
            'list_of_news' => $allNews,
            'tags' => $allTags,

        ]);
    }

    #[Route('/filter', name: 'filtered_news')]
    public function filteredNews(Request $request, EntityManagerInterface $entityManager): JsonResponse {
        $selectedTag = $request->query->get('tag_name');
        $tagRepo = $entityManager->getRepository(Tags::class);
        $selectedTagObject = $tagRepo->findOneBy(['tagName' => $selectedTag]);
        $neededNews = $selectedTagObject->getNews();
        return new JsonResponse($this->renderView('news/filter.html.twig', ['news' => $neededNews]));
    }
    #[Route('/{newsId<\d+>}', name: 'display_each_new')]
    public function showNew(Request $request, $newsId, EntityManagerInterface $entityManager): Response
    {

        $newsRepository = $entityManager->getRepository(News::class);
        $oneNew = $newsRepository->find($newsId);

        $comment = new Comments();

        $commentsForm2 = $this->createForm(CommentsForm::class, $comment);

        $commentsForm2->handleRequest($request);

        if ($commentsForm2->isSubmitted() && $commentsForm2->isValid()) {
            $comment->setCommentDate(new \DateTime()); // Set date

            // Связь новости с комментариями
            $oneNew->addNewsComment($comment);
            $comment->setNews($oneNew);


            $entityManager->persist($comment);
            $entityManager->flush(); // Save changes

            return $this->redirect($request->getUri());
}

        return $this->renderForm('news/show.html.twig', [
            'one_new' => $oneNew,
            'comments_form' => $commentsForm2
        ]);
    }

/*
 * 1) Одинаковые даты посчитать вместе, а не по отдельности (итоговая сумма)
 * 2) После этого передать данные в твиг
 * 3) Обработать данные в твиге, по каждому месяцу или дню вывести количество, по месяцу, где ничего нет, поставить ноль
 */
    #[Route('/comments-statistics', name: 'display_comments_statistics')]
    public function showNewCommentsStatistics(Request $request, CommentsRepository $commentsRepository): Response
    {

        $statistics = [];
        $time = new DateTime();

        $period = $request->query->get('period');

        $parameters = [];
        if ($period == 'month') {

           $parameters['time_from'] = $time->format($time->format('Y') . '-01-1 00:00:00');
           $parameters['time_to'] = $time->format($time->format('Y') . '-12-31 23:59:59');
           $formatType = 'n';

    }

        else {
            $parameters['time_from'] = $time->format('Y-m-01 00:00:00');
            $parameters['time_to'] = $time->format('Y-m' . '-' .  cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')));
            $formatType = 'j';
        }

           $results = $commentsRepository->getNumberOfComments($parameters);
           foreach($results as $singleResult)  {
                $day = $singleResult->getCommentDate()->format($formatType);
                if(isset($statistics[$day])){
                   $statistics[$day]++;
                }
                else {
                    $statistics[$day]=1;
                }

          }


        return $this->render('news/statistics.html.twig', [
            'period' => $period,
            'statistics' => $statistics,
        ]);

    }

    /*
     * 1) Fetch all the news from the db using qb
     * 2) Find out what's the longest new
     * 3) Fetch all the comments for this new
     * 4) Find out what's the shortest comment for this new
     * 5) Display the longest new and it's shortest comment
     * 6) Count all letter 'р' in this comment
     * 7) Display the number of p occurences
     * -------------------------------------------------------
     * 1) Count all the words for all the news which were posted for the last month
     * 2) Display the words count
     */
    #[Route('/count-occurences', name: 'display_counts')]
    public function countSubstr(NewsRepository $newsRepository): Response  {
        // Display longest new + it's shortest comment + count the number of 'p' letter occurrences

        $longestNewInfo = $newsRepository->getLongestNewAndShortestComm();
        if(isset($longestNewInfo)) {
            $pcount = substr_count($longestNewInfo['news_comment'], 'p');
        }
        else {
            $pcount = 'There are no comments for this new yet or there are no news at all';
        }

        // Count the number of words of all the news for the last month
        $numberOfWords = 0;
        $neededNews = $newsRepository->getNewsForGivenPeriod(new DateTime(date('Y-m-01')));
        foreach($neededNews as $singleNew) {
            $numberOfWords+=str_word_count($singleNew);
        }

        return $this->render('news/count.html.twig', [
                'new_info'  => $longestNewInfo,
                'number_of_letter_p' => $pcount,
                'words_number' => $numberOfWords
            ]
        );
    }

    #[Route('/{newsId<\d+>}/delete-comment', name: 'delete_comment')]
    public function commentDeletion(Request $request, EntityManagerInterface $entityManager): JsonResponse {
        $commentId = $request->request->get('comment_id');
        try {
            $commentToDelete = $entityManager->getRepository(Comments::class)->find($commentId);
            $entityManager->remove($commentToDelete);
            $entityManager->flush();
            $response = $this->json('The message was deleted successfully', 200);
        }
        catch(\Exception $e) {

            $response = $this->json($e->getMessage(), 500);
        }
        return $response;
    }
}