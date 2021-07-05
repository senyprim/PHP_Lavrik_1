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
function getAllArticleByCategory(int $id_category):?array{
    return query(ARTICLE_QUERY_GET_THIS_CATEGORY,[':id_category'=>$id_category])->fetchAll()??null;
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

    return $result===false?false:true;
}
function removeArticle(int $id):bool
{
    return query(ARTICLE_QUERY_REMOVE, [':id' => $id])==false?false:true;
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
        
        return $result==false?false:true;
}
function validateArticle(array $article):array
{
    $errors=[];
    if (!$article['title'] || mb_strlen($article['title'])<ARTICLE_MIN_SIZE_TITLE) {
        $errors['title']='Заголовок должeн быть не меньше '.ARTICLE_MIN_SIZE_TITLE.'символов';
    };
    
    if (!$article['content'] || mb_strlen($article['content'])<ARTICLE_MIN_SIZE_CONTENT){
        $errors['content']='Текст должн быть не меньше '.ARTICLE_MIN_SIZE_CONTENT.' символов';
    }
    
    return  $errors;
}
function checkArticleId(string $id){
    return preg_match(ARTICLE_REGEX_CHECK_ID,$id??'');
}
