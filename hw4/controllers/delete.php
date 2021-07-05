<?php

$validArticle = false;
$result = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = ($_POST['id'] ?? '');
    //Валидация id
    $validArticle = checkArticleId($id) && !!($article=getArticle(intval($id)));
    
    if ($validArticle) {
        $result = removeArticle($id);
        if ($result){
            $article['id']=null;
        }
    }
}
if ($result){
    $notice = 'Article was deleted successfull.';
} elseif($validArticle){
    $notice='Something went wrong.Article not deleted. Try later';
} else {
    $notice='Article not found';
};
$content = render('two-col-content',[
    'notice'=>$notice,
    'aside'=>render('aside',['id'=>$article['id']??'']),
    'article'=>render('articles/article',$article??[]),
]);