<?php
include BASE_DIR.'/models/Category.php';
include BASE_DIR.'/Repository.php';
class Article
{
    const MIN_LENGTH_TITLE=2;
    const MIN_LENGTH_TEXT=2;

    protected $id;
    protected $idCategory;
    protected $title;
    protected $content;
    protected $dt_add;

    public function __construct(int $id,?int $idCategory,string  $title,string  $content, $dt_add)
    {
        $this->id = $id;
        $this->idCategory = $idCategory;
        $this->title = trim($title);
        $this->content = trim($content);
        $this->dt_add = trim($dt_add);
    }
    public static function createArticle(array $fields)
    {
        if (!$fields) {
            return null;
        }
        $id=checkId($fields['id'])? intval($fields['id']):0;
        $idCategory=checkId($fields['id_category'])? intval($fields['id_category']):null;

        return new Article($id, $idCategory, $fields['title']??null, $fields['content']??null, $fields['dt_add'] ??null );
    }
    
    public function validate():array{
        $errors=[];
        if (!$this->idCategory || !$this->title || !$this->content) {
            $errors[]='Категория, заголовок и текст - обязательные для заполнения поля';
        };
        if ($this->title && mb_strlen($this->title)<self::MIN_LENGTH_TITLE){
            $errors[]='Длина заголовка должна быть не меньше '.self::MIN_LENGTH_TITLE.'символов';
        }
        if ($this->content && mb_strlen($this->content)<self::MIN_LENGTH_TEXT){
            $errors[]='Длина текста должна быть не меньше '.self::MIN_LENGTH_TEXT.'символов';
        }
        return  $errors;
    }

    public function getId():int
    {
        return $this->id;
    }
    public function getIdCategory():?int
    {
        return $this->idCategory;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setIdCategory(?int $id)
    {
        $this->idCategory = $id;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getDtAdd()
    {
        return $this->dt_add;
    }
   
}
