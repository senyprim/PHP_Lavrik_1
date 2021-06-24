<?php

include_once('functions.php');

/*
		your code here
		get id from url
		check id
		call removeArticle
*/
$result = false;
if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = trim($_GET['id']);
	if (ctype_digit($id)){
		$result = removeArticle($id);
		if ($result) {
			header("Location: index.php?notice=Article removed");
			exit(200);
		}
	}
} 
?>

<?php if($result): ?>
<p>Article remove successfully</p>
<?php else:?>
<p>Article not found</p>
<?php endif ?>
<hr>
<a href="index.php">Move to main page</a>