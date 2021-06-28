<?php
// define(strict_types=1);
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';
include_once BASE_DIR . '/Repository.php';

class ArticleRepository
{
    const QUERY_GET_ALL = 'select a.*,b.name as category from article a left join category b on a.id_category=b.id order by a.id';
    const QUERY_GET_ARTICLE = 'select a.*,b.name as category from article a left join category b on a.id_category=b.id where a.id=:id';
    const QUERY_ADD = 'insert  article (title,content,id_category)
    values (:title,:content,:id_category)';
    const QUERY_REMOVE = 'delete from article where id=:id';
    const QUERY_UPDATE = 'update article set title=:title, content=:content, id_category=:id_category where id=:id';
    const QUERY_EXIST = 'select 1 from article where id=:id';

    public $dbcontext;
    public function __construct(Db $dbcontext)
    {
        $this->dbcontext = $dbcontext;
    }
    public function getAll(): ?array
    {
        return $this->dbcontext::query(self::QUERY_GET_ALL)->fetchAll()??null;
    }

    public function getArticle(int $id): ?array
    {
        $result=$this->dbcontext::query(self::QUERY_GET_ARTICLE, [':id' => $id])->fetch();
        return $result ?$result:null;
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
                ':id_category'=>$article->getIdCategory(),
            ]);
        return !!$result;
    }

    public function removeArticle(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_REMOVE, [':id' => $id]);
    }

    public function existArticle(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_EXIST, [':id' => $id])->fetch();
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
                ':id_category' => $article->getIdCategory(),
            ]);
        return !!$result;
    }

   
}
