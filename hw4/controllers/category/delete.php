<?php

$validCategory = false;
$result = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = ($_POST['id'] ?? '');
    //Валидация id и загрузка article (так как решили показать что именно мы удалили)
    $validCategory = checkCategoryId($id) && !empty($category = getCategory(intval($id)));

    if ($validCategory) {
        
        try {
            $result = removeCategory($id);
            if ($result) {
                //Нам нужно показать что мы удалили - поэтому зануляем id (что бы скрипты поняли что такой статьи в базе нет)
                $category['id'] = null;
                $notice = 'Category was deleted successfull.';
            } else {
                $notice = 'Something went wrong.Category not deleted. Try later';
            }
        } catch (PDOException $e) {
            $notice = 'Ошибка удаления';
        }
    }
}


if ($validCategory) {
    $categoryContent = renderTwig('category/category', $category);
} else {
    $categoryContent = renderTwig('errors/404');
    $notice = 'Category not found';
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
}
$content = renderTwig(
    'two-col-content',
    [
        'notice' => $notice,
        'article' => $categoryContent,
        'aside' => renderTwig(
            'aside',
            [
                'id' => $category['id'] ?? null,
                'editPath' => 'category/edit',
                'deletePath' => 'category/delete'
            ]
        ),
    ]
);
