<?php
include_once (__DIR__.'/constants.php');
include_once (BASE_DIR.'/classes/ArticleRepository.php');
include_once (BASE_DIR.'/classes/CategoryRepository.php');
include_once (BASE_DIR.'/classes/Db.php');
include_once (BASE_DIR.'/models/Article.php');
include_once (BASE_DIR.'/models/logs.php');
addLog();

$repository=new ArticleRepository(new Db());
$categories =(new CategoryRepository(new Db()))->getAll();

$article=null;
$errors=[];
$id=($_SERVER["REQUEST_METHOD"] === "GET")?$_GET['id']??'':$_POST['id']??'';
$err404=true;

//Получаем запись по id
if (checkId($id)) {
	$article = $repository->getArticle($id);
	$err404=!$article;
}
//Если запрос пост и такая запись существует
if ($_SERVER["REQUEST_METHOD"] === "POST" && !$err404) {
    //Берем данные с запроса
	$article['title'] = trim($_POST['title']);
	$article['content'] = trim($_POST['content']);
	$article['id_category'] = checkId($str=trim($_POST['id_category']))?intval($str):null;
	//Зануляем категорию если она не существует
	if (!containsId($categories,$article['id_category'])){
		$article['id-category']=null;
	}
	//Валидируем article

	$cloneArticle=Article::createArticle($article);
	$errors=$cloneArticle->validate();
	if (!$errors){
		$result=$repository->editArticle($cloneArticle);
		//Если ошибок нет и запись изменилась успешно
		if ($result){
			header('Location: article.php?id='.$article['id']);
			exit();
		}
	}
}
?>

<div class="form">
	<?php if ($err404): ?>
		<p>Article not found</p>
		<hr>
		<a href="index.php">На главную страницу</a>
	<?php else : ?>
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
			<button>Добавить</button>
		</form>
	<?php endif ?>
</div>