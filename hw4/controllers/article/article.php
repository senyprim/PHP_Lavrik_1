<?php

$fieldNames=['title','content','category','id','dt_add','id_category'];
$fields = null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = URL_PARAMS['id'];
	$notice = urldecode($_GET['notice'] ?? '');

	if (checkArticleId($id)) {
		$fields =extractFields(getArticle(intval($id)),$fieldNames);
	}
}

if (!empty($fields)){
	$content = renderTwig('two-col-content',[
		'notice'=>$notice,
		'aside'=>renderTwig('aside',[
			'id'=>$fields['id'],
			'editPath'=>'article/edit',
			'deletePath'=>'article/delete'
	]),
		'article'=>renderTwig('articles/article',$fields)
	]
);
} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	$content=renderTwig('errors/404');
};