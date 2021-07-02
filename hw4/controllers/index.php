<?php

$articles = getAllArticle(); //Берем статьи с базы

$content=render('articles/article-list',[
    'articles'=>$articles
]);



