<?php
require_once 'vendor/autoload.php';
use Ds\Vector;
//class treenode {
//    public $val;      // the value of the node
//    public $left;    // reference to the left child node
//    public $right;   // reference to the right child node
//
//    public function __construct($val) {
//    $this->val = $val;
//        $this->left = null;
//        $this->right = null;
//    }
//}
//
//$treenode = new treenode(2);
//$treenode->right = new treenode(1);
//$treenode->right->left = new treenode(4);
//
//var_dump($treenode->right->left);
$start = microtime(true);
//$sequence = new Ds\Vector([1, 2, 3]);
//$summa = $sequence->sum();
//echo $summa;
$arr = [1,2,3];
echo array_sum($arr);
$end = microtime(true);
echo $end-$start;

