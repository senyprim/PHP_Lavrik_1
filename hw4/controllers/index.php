<?php

$title='Все категории';
$id_category=$_GET['id_category']??null;//Берем id_category
$validCategory = !!$id_category //Валидируем
    ? checkCategoryId($id_category) && existCategory($id_category)
    : false;

$category = $validCategory?getCategory(intval($id_category)):null;//Загружаем категорию

$articles = !!$category //Загружаем articles
 ?getAllArticleByCategory(intval($id_category))
 :getAllArticle(); //Берем статьи с базы

$title = !!$category
?'Категория '.$category['name']
:'Все категории';
    


$content=render('articles/article-list',[
    'articles'=>$articles,
    'title'=>$title
]);



