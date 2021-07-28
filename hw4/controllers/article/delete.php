<?php

$validArticle = false;
$result = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = ($_POST['id'] ?? '');
    //Валидация id и загрузка article (так как решили показать что именно мы удалили)
    $validArticle = checkArticleId($id) && !empty($article = getArticle(intval($id)));

    if ($validArticle) {

        $result = removeArticle($id);
        if ($result) {
            //Нам нужно показать что мы удалили - поэтому зануляем id (что бы скрипты поняли что такой статьи в базе нет)
            $article['id'] = null;
        }
    }
}
if ($validArticle) {
    $articleContent = renderTwig('articles/article', $article);
    $notice = $result
        ? 'Article was deleted successfull.'
        : 'Something went wrong.Article not deleted. Try later';
} else {
    $articleContent = renderTwig('errors/404');
    $notice = 'Article not found';
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
}
$content = renderTwig('two-col-content', [
    'notice' => $notice,
    'aside' => renderTwig('aside', [
        'id' => $article['id'] ?? null,
        'editPath' => 'article/edit',
        'deletePath' => 'article/delete'
    ]),
    'article' => $articleContent
]);
