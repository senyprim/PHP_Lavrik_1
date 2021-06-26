<?php
class Article{
    protected $id;
    protected $author;
    protected $title;
    protected $content;
    protected $dt_add;

    public function __construct($id, $author, $title, $content, $dt_add)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->dt_add = $dt_add;
    }
    public static function createArticle(array $fields) {
        if ( !$fields) return null;
        return new Article($fields['id']??0,$fields['author'],$fields['title'],$fields['content'],$fields['dt_add']??'');
    }
    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id=$id;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getDtAdd(){
        return $this->dt_add;
    }
}