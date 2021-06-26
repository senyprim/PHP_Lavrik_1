<?php
include_once (__DIR__.'/constants.php');
include_once (BASE_DIR.'/classes/ArticleRepository.php');
include_once (BASE_DIR.'/classes/Db.php');
include_once (BASE_DIR.'/models/Article.php');

$fields=['title'=>'','content'=>'','author'=>''];

$result = false;
$error = '';
$repository=new ArticleRepository(new Db());

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$fields['title'] = trim($_POST['title']);
	$fields['content'] = trim($_POST['content']);
	$fields['author'] = trim($_POST['author']);

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

<hr>
<a href="index.php">Move to main page</a>