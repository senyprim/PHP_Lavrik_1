<?php

include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/classes/ArticleRepository.php';
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';

$repository = new ArticleRepository(new Db());
$result=false;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = ($_GET['id'] ?? '');
    $result = $repository->checkId($id);
    if ($result) {
        $result = $repository->removeArticle($id);
        if (!!$result) {
            header('Location: index.php?notice=Article with id=' . $id . ' removed');
            exit(200);
        }
    }
}
?>

<p>Article not found</p>
<hr>
<a href="index.php">Move to main page</a>
