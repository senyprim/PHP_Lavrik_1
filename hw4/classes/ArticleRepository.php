<?php
// define(strict_types=1);
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';

class ArticleRepository
{
    const QUERY_GET_ALL = 'select a.*,b.name as category from article a left join category b on a.id_category=b.id_category order by a.id';
    const QUERY_GET_ARTICLE = 'select a.*,b.name as category from article a left join category b on a.id_category=b.id_category where a.id=:id';
    const QUERY_ADD = 'insert  article (title,content,author,id_category)
    values (:title,:content,:author,:id_category)';
    const QUERY_REMOVE = 'delete from article where id=:id';
    const QUERY_UPDATE = 'update article set title=:title, content=:content, author=:author, id_category=:id_category where id=:id';
    const QUERY_EXIST = 'select 1 from article where id=:id';

    public $dbcontext;
    public function __construct(Db $dbcontext)
    {
        $this->dbcontext = $dbcontext;
    }
    public function getAll(): ?array
    {
        $rows = $this->dbcontext::query(self::QUERY_GET_ALL)->fetchAll();
        if (!$rows) {
            return null;
        }
        foreach($rows as $row){
            $article=Article::createArticle($row)
        }
        return array_map(function ($fields) {
            return Article::createArticle($fields);
        }, $rows);
    }
    public function getArticle(int $id): ?Article
    {
        $row = $this->dbcontext::query(self::QUERY_GET_ARTICLE, [':id' => $id])->fetch();
        if (!$row) {
            return null;
        }
        return Article::createArticle($row);
    }

    public function addArticle(Article $article): bool
    {
        if (null == $article) {
            return false;
        }

        $result = $this->dbcontext::query(self::QUERY_ADD,
            [
                ':title' => $article->getTitle(),
                ':content' => $article->getContent(),
                ':author' => $article->getAuthor(),
            ]);
        return !!$result;
    }

    public function removeArticle(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_REMOVE, [':id' => $id]);
    }

    public function existArticle(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_EXIST, [':id' => $id]);
    }

    public function editArticle(Article $article):bool
    {
        if (!$article) {
            return false;
        }
        $result = $this->dbcontext::query(self::QUERY_UPDATE,
            [
                ':id' => $article->getId(),
                ':title' => $article->getTitle(),
                ':content' => $article->getContent(),
                ':author' => $article->getAuthor(),
            ]);
        return !!$result;
    }

    public function checkId(string $id): bool{
        return !!preg_match('/^[1-9]\d*$/',$id);
    }
}
