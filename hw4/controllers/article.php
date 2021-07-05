<?php

$fieldNames=['title','content','category','id','dt_add','id_category'];
$fields = null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = ($_GET['id'] ?? '');
	$notice = ($_GET['notice'] ?? '');

	if (checkArticleId($id)) {
		$fields =extractFields(getArticle(intval($id)),$fieldNames);
	}
}

if (!empty($fields)){
	$content = render('two-col-content',[
		'notice'=>$notice,
		'aside'=>render('aside',['id'=>$fields['id']]),
		'article'=>render('articles/article',$fields)
	]
);
} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	$content=render('errors/404');
};