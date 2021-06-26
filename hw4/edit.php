<?php
include_once (__DIR__.'/constants.php');
include_once (BASE_DIR.'/classes/ArticleRepository.php');
include_once (BASE_DIR.'/classes/Db.php');
include_once (BASE_DIR.'/models/Article.php');

$fields=['title'=>'','content'=>'','author'=>'','id'=>''];

$result = false;
$error = '';
$repository=new ArticleRepository(new Db());

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = ($_GET['id'] ?? '');
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Берем данные с запроса
	$fields['title'] = trim($_POST['title']);
	$fields['content'] = trim($_POST['content']);
	$fields['author'] = trim($_POST['author']);
	$fields['id'] = trim($_POST['id']);
	if ($fields['title'] === '' || $fields['content'] === '' || $fields['author']=='') {
		$error = 'Заполните все поля!';
	}
    $article = $repository->getArticle($fields['id']);
    if (!!$article){
		$newArticle=Article::createArticle($fields);
        $result=$repository->editArticle(newArticle);
    }
	
}
if (ctype_digit($id)) {
    $article = $repository->getArticle($id);
}
if ($article){


}
    

    

	if ($fields['title'] === '' || $fields['content'] === '' || $fields['author']=='') {
		$error = 'Заполните все поля!';
	} else {
		$repository->addArticle( Article::createArticle($fields));
		header('Location: index.php?notice=Article added');
		exit(200);
	}
} 
?>

<div class="form">
	<?php if ($result) : ?>
		<p>You article added!</p>
		<a href="add.php">Add other article</a>
	<?php else : ?>
		<form action="add.php" method="post">
			<p><?php echo $error ?></p>
			Title :<input type="text" name="title" value=<?php echo $fields['title'] ?>>
			<br>
			<br>
			Author :<input type="text" name="author" value=<?php echo $fields['author'] ?>>
			<br>
			<br>
			Content :<textarea type="text" name="content">
			<?php echo $fields['content'] ?>
			</textarea>
			<button>Добавить</button>
		</form>
	<?php endif ?>
</div>