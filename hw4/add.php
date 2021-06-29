<?php
include_once (__DIR__.'/constants.php');
include_once (__DIR__.'/functions.php');
include_once (BASE_DIR.'/models/article.php');
include_once (BASE_DIR.'/models/category.php');
include_once (BASE_DIR.'/models/logs.php');
include_once (BASE_DIR.'/models/db.php');
addLog();

$result = false;
$errors = [];
//Запрашиваем все категории чтобы показать список
//(так как при ошибочных post запросах мы должны показывать все категории считываем всегда)
$categories =getAllCategory();
$fields=['title'=>'','content'=>'','id_category'=>''];

if ('POST'==$_SERVER["REQUEST_METHOD"]) {
	$fields['title'] = trim($_POST['title']);
	$fields['content'] = trim($_POST['content']);
	$fields['id_category'] = trim($_POST['id_category']);
	//Валидация
	$errors=validateArticle($fields);
	if (
		!checkCategoryId($fields['id_category']) ||
		!arrayContainsId($categories,intval($fields['id_category'])))
	{
		$errors[]='Выбранная категория не существует';
	}
	if (!$errors)
	{
		$result = addArticle( $fields );
		header('Location: article.php?id='.getLastId());
		exit();
	}
} 
?>

<div class="form">
		<form action="add.php" method="post">
			<h1>Add article</h1>
			<!-- Показать ошибки -->
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
			value="<?php echo $fields['title'];?>"
			placeholder="Введите заголовок статьи"
			>
			<br>
			<br>
			Category : 
			<select name="id_category" placeholder="Введите текст статьи">
			<option value="" disabled selected>Выберите категорию статьи</option>
			<?php foreach($categories as $category):?>
				<option 
					value="<?php echo $category['id']??''?>" 
					<?php echo $category['id']==$fields['id_category']?'selected':''?>
				>
					<?php echo $category['name']??'';?>
				</option>
			<? endforeach; ?>
			</select>
			<br>
			<br>
			Content :<textarea name="content" placeholder="Введите текст статьи"
			><?php echo $fields['content']?></textarea>
			<br>
			<br>
			<button>Добавить</button>
		</form>
</div>

<hr>
<a href="index.php">Move to main page</a>