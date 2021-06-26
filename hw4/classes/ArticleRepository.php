<?php
define(strict_types=1); 
include_once BASE_DIR.'/classes/Db.php';
include_once BASE_DIR.'/models/Article.php';

class ArticleRepository{
    const  QUERY_GET_ALL='select * from article';
    const  QUERY_GET_ARTICLE='select * from article where id= :id limit 1';
    const  QUERY_ADD='insert  article (title,content,author)  
    values (:title,:content,:author)';
    const  QUERY_REMOVE='delete from article where id=:id';
    const  QUERY_UPDATE='update article set title=:title, content=:content, author=:author where id=:id';

    public $dbcontext;
    public function __construct(Db $dbcontext){
        $this->dbcontext=$dbcontext;
    }
    public function getAll():null{
        $rows=$this->dbcontext::query(self::QUERY_GET_ALL)->fetchAll();
        if (!$rows){
            return null;
        }
        return array_map(function($fields){
            return Article::createArticle($fields);
        },$rows);
    }
    public function getArticle(int $id):?Article{
        $row=$this->dbcontext::query(self::QUERY_GET_ARTICLE,[':id'=>$id])->fetch();
        if (!$row){
            return null;
        }
        return Article::createArticle($row);
    }
   
    public function addArticle(?Article $article):?Article{
        if (null==$article || !existArticle($article->getId())) return null;
        $result = $this->dbcontext::query(self::QUERY_ADD,
        [
            ':title'=>$article->getTitle(),
            ':content'=>$article->getContent(),
            ':author'=>$article->getAuthor(),
        ]);

        return $this->getArticle($this->dbcontext::getLastId())
        ;
    }
    public function removeArticle(int $id){
        $article=$this->getArticle($id);
        if (!!$article){
            $result=$this->dbcontext::query(self::QUERY_REMOVE,[':id'=>$id]);
        }
        return $result?$article:null;
    }
    public function existArticle(int $id){
        return !!$this->getArticle($id);
    }
    public function editArticle(Article $article){
        if (!$article) return null; //Если пустой вернуть null
        $id = $article->getArticle($id);
        $existArticle=$this->getArticle($id);
        if (!existArticle) return null;//Или если с таким null нет записи вернуть null
        $result=$this->dbcontext::query(self::QUERY_UPDATE,
        [
            ':id'=>$existArticle->getId(),
            ':title'=>$existArticle->getTitle(),
            ':content'=>$existArticle->getContent(),
            ':author'=>$existArticle->getAuthor(),
        ]);
        return $result?article:null;
    }
    public function checkId(string $id):bool{
        return ctype_digit($id);
    }
}