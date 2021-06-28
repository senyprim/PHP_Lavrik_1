<?php

include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/classes/ArticleRepository.php';
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';
include_once BASE_DIR . '/Repository.php';
include_once (BASE_DIR.'/models/logs.php');
addLog();

$repository = new ArticleRepository(new Db());
$result=false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = ($_POST['id'] ?? '');
    $result = checkId($id);
    //Проверяем наличие удаляемой статьи
    $result = $repository->existArticle($id);
    if ($result) {
        $result = $repository->removeArticle($id);
        if (!!$result) {
            header('Location: index.php?notice=Article with id=' . $id . ' removed');
            exit();
        }
    }
}
?>

<p>Article with id=<?=$id?> not found</p>
<hr>
<a href="index.php">Move to main page</a>
