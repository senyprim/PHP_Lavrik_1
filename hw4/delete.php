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
    $titleView='Article deleted';
    include(BASE_DIR.'/views/succes.php');
} elseif($validArticle){
    $titleView='Something went wrong.Article not deleted. Try later';
    include(BASE_DIR.'/views/fail.php');
} else {
    $titleView='Article not found';
    include(BASE_DIR.'/views/fail.php');
};