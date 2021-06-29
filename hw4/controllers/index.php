<?php
include_once (BASE_DIR . '/models/article.php');

$articles = getAllArticle(); //Берем статьи с базы

include (BASE_DIR.'/views/article-list.php');