<?php
$title = 'Все категории';
$validCategory = false;

$id_category = URL_PARAMS['id_category'];

//Если id_category null (не указана)
if ($id_category === null) {
    $articles = getAllArticle();
    $title = 'Все категории:';
    $validCategory=true;
} 
//Если категория есть показать все записи с ней
else if(!empty($category = getCategory(intval($id_category)))) {
    $articles = getAllArticleByCategory(intval($id_category));
    $title = 'Категория ' . $category['name'].':';
    $validCategory=true;
} 
//Если такой категории  нет
else {
}

$content = $validCategory || $id_category === null
    ? renderTwig('list-item', [
        'itemTemplate'=>'articles/article-small',
        'list' => $articles,
        'title' => $title
    ])
    : renderTwig('errors/404');
