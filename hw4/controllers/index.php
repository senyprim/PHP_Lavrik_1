<?php
$title = 'Все категории';
$validCategory = false;

$id_category = $_GET['id_category'] ?? null; //Берем id_category
$validCategory = !!$id_category //Валидируем
    ? checkCategoryId($id_category) && existCategory($id_category)
    : false;

$category = $validCategory ? getCategory(intval($id_category)) : null; //Загружаем категорию
//Если id_category нет
if ($id_category === null) {
    $articles = getAllArticle();
}
//Если id_category существующая
if (!empty($category)) {
    $articles = getAllArticleByCategory(intval($id_category));
    $title = 'Категория ' . $category['name'];
}

$content = $validCategory || $id_category === null
    ? render('articles/article-list', [
        'articles' => $articles,
        'title' => $title
    ])
    : render('errors/404');
