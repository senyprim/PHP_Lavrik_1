<?php

include_once __DIR__ . '/models/article.php';
include_once __DIR__ . '/models/logs.php';
addLog();

/*
your code here
check request method
read POST-data
validate data
call addArticle
 */
$result = false;
$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($name === '' || $content === '') {
        $error = 'Заполните все поля!';
    } else {
        addArticle($title, $content);
        header('Location: index.php');
        exit(200);
    }
} else {
    $title = '';
    $content = '';
}
?>

<div class="form">
	<?php if ($result): ?>
		<p>You article added!</p>
		<a href="add.php">Add other article</a>
	<?php else: ?>
		<form action="add.php" method="post">
			<p><?php echo $error ?></p>
			Title :<input type="text" name="title" value=<?php echo $title ?>>
			<br>
			<br>
			Content :<textarea type="text" name="content"
			><?php echo $content ?></textarea>
			<button>Добавить</button>
		</form>
	<?php endif?>
</div>

<hr>
<a href="index.php">Move to main page</a>