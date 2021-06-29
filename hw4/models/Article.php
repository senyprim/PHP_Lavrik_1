<?php

include_once (BASE_DIR . '/core/db.php');

function getAllArticle():?array
{
    return query(ARTICLE_QUERY_GET_ALL)->fetchAll()??null;
}

function getArticle(int $id): ?array
{
        $result=query(ARTICLE_QUERY_GET, [':id' => $id])->fetch();
        return $result ? $result : null;
}

function addArticle(?array $article): bool
{
    if (!$article) {
        return false;
    }
    $result = query(
        ARTICLE_QUERY_ADD,
        [
            ':title' => $article['title'],
            ':content' => $article['content'],
            ':id_category'=>$article['id_category'],
        ]
    );

    return !!$result->rowCount();
}
function removeArticle(int $id):bool
{
    return !!query(ARTICLE_QUERY_REMOVE, [':id' => $id])->rowCount();
}
function existArticle(int $id):bool
{
    return !!query(ARTICLE_QUERY_EXIST, [':id' => $id])->fetch();
}
function editArticle(array $article):bool
{
        if (!$article) {
            return false;
        }
        $result = query(
            ARTICLE_QUERY_UPDATE,
            [
                ':id' => $article['id'] ?? 0,
                ':title' => $article['title'],
                ':content' => $article['content'],
                ':id_category' => $article['id_category'],
            ]);
        return !!$result->rowCount();
}
function validateArticle(array $article):array
{
    $errors=[];
    if (!$article['title'] || !$article['content']) {
        $errors[]='Заголовок и текст - должны быть заполненны';
    };
    if ($article['title'] && mb_strlen($article['title'])<ARTICLE_MIN_SIZE_TITLE){
        $errors[]='Длина заголовка должна быть не меньше '.ARTICLE_MIN_SIZE_TITLE.'символов';
    };
    if ($article['content'] && mb_strlen($article['content'])<ARTICLE_MIN_SIZE_CONTENT){
        $errors[]='Длина текста должна быть не меньше '.ARTICLE_MIN_SIZE_CONTENT.' символов';
    }
    
    return  $errors;
}
function checkArticleId(string $id){
    return preg_match(ARTICLE_REGEX_CHECK_ID,$id??'');
}
