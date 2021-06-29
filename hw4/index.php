<?php
include_once (__DIR__ . '/constants.php');
include_once (BASE_DIR . '/models/article.php');
include_once (BASE_DIR . '/models/logs.php');
addLog();

$articles = getAllArticle(); //Берем статьи с базы

include (BASE_DIR.'/views/articles.php');