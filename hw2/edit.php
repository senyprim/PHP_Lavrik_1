<?php

include_once __DIR__ . '/models/article.php';
include_once __DIR__ . '/models/logs.php';
addLog();

/*
your code here
get id from url
check id
call removeArticle
 */
function isValidId($id)
{
    if ($id == null || ctype_digit($id)) {
        return false;
    }

    return true;
}

$result = false;
$article = null;
$error = '';
$id = null;
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = trim($_GET['id']);
    if (isValidId($id)) {
        $error = "wrong id";
    }
    $article = getArticle($id);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST['id'] ?? '');
    if (isValidId($id)) {
        $error = "wrong id";
    }
    $article = getArticle($id);
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ('' == $title || '' == $content) {
        $error = 'Поля должны быть заполлненны';
    } else {
        $result = editArticle($id, $title, $content);
        if ($result) {
            header('Location: index.php');
            exit(200);
        }
    }
}

?>

<div class="form">
	<?php if ($result): ?>
		<p>Article changed!</p>
		<a href="edit.php?id=<?php echo $id ?>">Edit again</a>
	<?php elseif ($article == null): ?>
		<p>Article not found</p>
	<?php else: ?>
		<p><?php echo $error ?></p>
		<form action="edit.php" method="post">
			<input type="hidden" name="id" value="<?php echo $article['id']; ?>">
			Title :<input type="text" name="title" value="<?php echo ($article['title']); ?>">
			<br>
			<br>
			Content :<textarea type="text" name="content"><?php echo $article['content'] ?></textarea>
			<button>Сохранить изменение</button>
		</form>
	<?php endif?>
</div>

<hr>
<a href="index.php">Move to main page</a>