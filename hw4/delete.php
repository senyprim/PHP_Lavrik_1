<?php
include_once (__DIR__ . '/constants.php');
include_once (BASE_DIR . '/models/article.php');
include_once(BASE_DIR . '/models/logs.php');
addLog();

$validArticle = false;
$result = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = ($_POST['id'] ?? '');
    //Валидация id
    $validArticle = checkArticleId($id) && existArticle(intval($id));
    if ($validArticle) {
        $result = removeArticle($id);
    }
}
if ($result){
    include(BASE_DIR.'/views/succes.php')
} elseif($validArticle){
    include(BASE_DIR.'/views/succes.php')
}

<p>
    <? if ($result) : ?>
        Article was deleted
    <? elseif ($validArticle) : ?>
        Somthing wrong. Article not deleted.
    <? else : ?>
        Article with id=<?= $id ?> not found
    <? endif ?>
</p>
<hr>
<a href="index.php">Move to main page</a>