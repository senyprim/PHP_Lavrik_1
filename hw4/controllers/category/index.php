<?php
$fieldNames = ['id', 'name', 'dt_add'];
$fields = null;
$validCategory = false;
$notice=urldecode($_GET['notice']);

$id_category = URL_PARAMS['id'];
//Если id_category null (не указана) показываем все категории
if ($id_category === null) {
    $content = renderTwig('list-item', [
        'itemTemplate' => 'category/category-small',
        'list' => getAllCategory(),
        'title' => 'Все категории:'
    ]);
}
//Если категория есть показать только ее
else if (!empty($category = getCategory(intval($id_category)))) {
    $fields = extractFields($category, $fieldNames);
    $content = renderTwig('two-col-content', [
        'aside' => renderTwig('aside', [
            'id' => $fields['id'],
            'editPath' => 'category/edit',
            'deletePath' => 'category/delete'
        ]),
        'article' => renderTwig('category/category', $fields),
        'notice'=>$notice
    ]);
}
//Если такой категории  нет
else {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    $content = renderTwig('errors/404');
};
