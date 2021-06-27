<?php
include $BASE_DIR.'/models/Category.php';
class Article
{
    const MIN_LENGTH_TITLE=2;
    const MIN_LENGTH_TEXT=2;

    protected $id;
    protected $idCategory;
    protected $title;
    protected $content;
    protected $dt_add;

    public function __construct(int $id,int $idCategory,string  $title,string  $content, $dt_add)
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

        return new Article($fields['id'] ?? 0, $fields['author'], $fields['title'], $fields['content'], $fields['dt_add'] ?? '');
    }
    
    public function validate():array{
        $errors=[];
        if (!$this->idCategory || !$this->title || !$this->content) {
            $errors[]='Категория заголовок и текст - обязательные для заполнения поля';
        };
        if ($this->title && mb_strlen($this->title)<self::MIN_LENGTH_TITLE){
            $errors[]='Длина заголовка должна быть не меньше '.self::MIN_LENGTH_TITLE.'символов';
        }
        if ($this->text && mb_strlen($this->text)<self::MIN_LENGTH_TEXT){
            $errors[]='Длина текста должна быть не меньше '.self::MIN_LENGTH_TEXT.'символов';
        }
        return  $errors;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
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
