<?php
// define(strict_types=1);
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Category.php';
class CategoryRepository
{
    const QUERY_GET_ALL = 'select * from category';
    const QUERY_GET_ARTICLE = 'select * from category where id= :id';
    const QUERY_ADD = 'insert  category (name) values (:name)';
    const QUERY_REMOVE = 'delete from category where id=:id';
    const QUERY_UPDATE = 'update category set name=:name where id=:id';
    const QUERY_EXIST = 'select 1 from category where id=:id';

    public $dbcontext;
    public function __construct(Db $dbcontext)
    {
        $this->dbcontext = $dbcontext;
    }
    public function getAll(): ?array
    {
        return $this->dbcontext::query(self::QUERY_GET_ALL)->fetchAll()??null;
    }
    public function getCategory(int $id): ?Category
    {
        return $this->dbcontext::query(self::QUERY_GET_ARTICLE, [':id' => $id])->fetch()??null;
    }

    public function addCategory(Category $category): bool
    {
        if (null == $category) {
            return false;
        }

        $result = $this->dbcontext::query(self::QUERY_ADD,
            [
                ':name' => $category->getName()
            ]);
        return !!$result;
    }

    public function removeCategory(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_REMOVE, [':id' => $id]);
    }

    public function existCategory(int $id):bool
    {
        return !!$this->dbcontext::query(self::QUERY_EXIST, [':id' => $id]);
    }

    public function editCategory(Category $category):bool
    {
        if (!$category) {
            return false;
        }
        $result = $this->dbcontext::query(self::QUERY_UPDATE,
            [
                ':id' => $category->getId(),
                ':name' => $category->getName(),
            ]);
        return !!$result;
    }

    public function checkId(string $id): bool{
        return !!preg_match('/^[1-9]\d*$/',$id);
    }


}