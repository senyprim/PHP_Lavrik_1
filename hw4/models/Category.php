<?php
class Category{
    const MIN_LENGTH_NAME=2;
    protected $id;
    protected $name;

    public function __construct(int $id,string $name){
        $this->id = $id;
        $this->name = trim($name);
    }
    public static function create(array $fields): Category{
        if (!$fields) {
            return null;
        }

        return new Category($fields['id'] ?? 0, $fields['name']);
    }
    public function getId():int{
        return $this->id;
    }
    public function getName():string{
        return $this->name;
    }
    public function validate():array{
        $error=[];
        if (mb_strlen($this->name || '')<self::MIN_LENGTH_NAME){
            $error[]='Длина имени категории не может быть меньше '.self::MIN_LENGTH_NAME;
        }
        return $error;
    }
}