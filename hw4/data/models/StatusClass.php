<?php
class StatusClass{
    protected $id;
    protected $name;
    protected $description;
    protected $dt_add;
    public function __construct(int $id,string $name,$description,$dt_add=null)
    {
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->dt_add=$dt_add;
    }
    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function setName(string $name)
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
}