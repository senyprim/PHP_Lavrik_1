<?php
include_once (__DIR__.'/constants.php');
include_once (BASE_DIR.'/models/article.php');
include_once (BASE_DIR.'/models/category.php');
include_once (BASE_DIR.'/functions.php');
include_once (BASE_DIR.'/models/logs.php');
addLog();

$categories =getAllCategory();
$validId=false;
$result=false;
$article=null;
$errors=[];
//Берем id из get или post запроса
$id=($_SERVER["REQUEST_METHOD"] === "GET")?$_GET['id']??'':$_POST['id']??'';
//Получаем запись по id
$validId = checkArticleId($id);
if ($validId) {
	$article = getArticle(intval($id));
}
//Если запрос пост и такая запись существует
if ($_SERVER["REQUEST_METHOD"] === "POST" && !!$article) {
    //Берем данные с запроса
	$article['title'] = trim($_POST['title']);
	$article['content'] = trim($_POST['content']);
	$article['id_category'] = trim($_POST['id_category']);
	$errors=validateArticle($article);
	if (
		!checkCategoryId($article['id_category']) ||
		!arrayContainsId($categories,intval($article['id_category'])))
	{
		$errors[]='Выбранная категория не существует';
	}
	if (!$errors)
	{
		$result = editArticle( $article );
		if ($result){
			header('Location: article.php?id='.$article['id']);
			exit();
		} 
		$errors[]='Something went wrong - record not updated. Try later';
	}
}
?>

<div class="form">
	<?php if (!$article): ?>
		<p>Article not found</p>
		<hr>
		<a href="index.php">На главную страницу</a>
	<?php else : ?>
		<h1>Edit article</h1>
		<form action="edit.php" method="post">
		<input type="hidden" name="id" value="<?=$article['id']?>">
		<?php if (!!$errors):?>
				<div class="errors">
				<?php foreach($errors as $error):?>
					<p><?php echo $error ?></p>
				<?php endforeach ?>
				</div>
			<? endif ?>
			Title :<input 
			type="text" 
			name="title" 
			value="<?= $article['title'];?>"
			placeholder="Введите заголовок статьи"
			>
			<br>
			<br>
			Category : 
			<select name="id_category">
			<option value="" disabled>Выберите категорию статьи</option>
			<?php foreach($categories as $category):?>
				<option 
					value="<?php echo $category['id']??''?>" 
					<?php echo $category['id']==$article['id_category']?'selected':''?>
				>
					<?php echo $category['name']??'';?>
				</option>
			<? endforeach; ?>
			</select>
			<br>
			<br>
			Content :<textarea name="content" placeholder="Введите текст статьи"
			><?php echo $article['content']?></textarea>
			<br>
			<br>
			<button>Изменить</button>
		</form>
	<?php endif ?>
</div>