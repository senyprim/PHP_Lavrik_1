<?php

	// your functions may be here

	/* start --- black box */
	function getArticles() : array{
		return json_decode(file_get_contents('db/articles.json'), true);
	}

	function getArticle(int $id): array {
		return getArticles()[$id]??null;
	}

	function addArticle(string $title, string $content) : bool{
		$articles = getArticles();

		$lastId = end($articles)['id'];
		$id = $lastId + 1;

		$articles[$id] = [
			'id' => $id,
			'title' => $title,
			'content' => $content
		];
		saveArticles($articles);
		return true;
	}
	
	function editArticle(int $id, string $title, string $content) : array{
		$articles = getArticles();
		$article= $articles[$id]??null;
		if ($article==null){
			return null;
		};
		$articles[$id]=[
			'id'=>$id,
			'title'=>$title,
			'content'=>$content
		];
		saveArticles($articles);

		return $article;
	}

	function removeArticle(int $id) : bool{
		$articles = getArticles();

		if(isset($articles[$id])){
			unset($articles[$id]);
			saveArticles($articles);
			return true;
		}
		
		return false;
	}

	function saveArticles(array $articles) : bool{
		file_put_contents('db/articles.json', json_encode($articles));
		return true;
	}
	/* end --- black box */