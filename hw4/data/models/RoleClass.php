<?php
class RoleClass{
    protected $id;
    protected $name;
    protected $description;
    protected $dt_add;
    protected $status;

    public function __construct(int $id, string $name,$description,$dt_add, StatusClass $status){
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->dt_add=$dt_add;
        $this->status=$status;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDt_add()
    {
        return $this->dt_add;
    }

    public function setDt_add($dt_add)
    {
        $this->dt_add = $dt_add;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}