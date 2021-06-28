<?php
include_once (__DIR__.'/constants.php');
include_once (BASE_DIR.'/models/Article.php');
include_once (BASE_DIR.'/classes/Db.php');
include_once (BASE_DIR.'/classes/ArticleRepository.php');
include_once (BASE_DIR.'/classes/CategoryRepository.php');

$fields=['title'=>'','content'=>'','id_category'=>''];

$result = false;
$errors = [];
$repositoryArticle=new ArticleRepository(new Db());
$categories =(new CategoryRepository(new Db()))->getAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$fields['title'] = trim($_POST['title']);
	$fields['content'] = trim($_POST['content']);
	$fields['id_category'] = trim($_POST['id_category']);

	$article=Article::createArticle($fields);
	//Если такой категории нет сбросить ее на null
	if (!containsId($categories,$article->getIdCategory())){
		$article->setIdCategory(null);
	}
	;
	if (!$errors=$article->validate())
	{
		$result = $repositoryArticle->addArticle( $article );
		
		header('Location: article.php?id='.$repositoryArticle->dbcontext::getLastId());
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