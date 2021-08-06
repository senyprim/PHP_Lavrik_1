<?php

include_once (BASE_DIR . '/core/db.php');

function getAllCategory():?array
{
    return query(CATEGORY_QUERY_GET_ALL)->fetchAll()??null;
}

function getCategory(int $id): ?array
{
        $result=query(CATEGORY_QUERY_GET, [':id' => $id])->fetch();
        return $result ? $result : null;
}
function getCategoryByName(string $name){
    $result=query(CATEGORY_QUERY_GET_BY_NAME, [':name' => $name])->fetch();
        return $result ? $result : null;
}


function addCategory(?array $category): bool
{
    if (!$category) {
        return false;
    }
    $result = query(
        CATEGORY_QUERY_ADD,
        [
            ':name' => $category['name'],
        ]
    );
    return !!$result->rowCount();
}
function removeCategory(int $id):bool
{
    return !!query(CATEGORY_QUERY_REMOVE, [':id' => $id])->rowCount();
}
function existCategory(int $id):bool
{
    return !!query(CATEGORY_QUERY_EXIST, [':id' => $id])->fetch();
}
function editCategory(array $category):bool
{
        if (!$category) {
            return false;
        }
        $result = query(
            CATEGORY_QUERY_UPDATE,
            [
                ':id' => $category['id'] ?? 0,
                ':name' => $category['name'],
            ]);
        return !!$result->rowCount();
}
function validateCategory(array $category):array
{
    $error=[];
    if (gettype($category['name'])!=='string' || mb_strlen($category['name'])<CATEGORY_MIN_SIZE_NAME){
            $error['name']='Длина имени категории не может быть меньше '.CATEGORY_MIN_SIZE_NAME.'символов';
    }
    return $error;
}

function checkCategoryId(?string $id){
    return preg_match(CATEGORY_REGEX_CHECK_ID,$id??'');
}
