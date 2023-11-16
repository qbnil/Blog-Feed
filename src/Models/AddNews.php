<?php
namespace App\Models;


use App\Entity\News;

class AddNews{

    public function saveToDb(Request $request): void {
        // создаем инстанс класса News
        $createNew = new News();

        // инициализация
        $createNew->setCreatedAtDateAndTime(new \DateTime());

    }
}
