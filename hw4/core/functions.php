<?php
function indexOfId(array $array,?int $id):int{
    if (!$array || $id==null) return -1;
    foreach($array as $key=>$item){
        if (isset($item['id']) && $item['id']==$id) return $key;
    }
    return -1;
}
function arrayContainsId(array $array, ?int $id):bool{
    return indexOfId($array,$id)>=0;
}
function extractFields(array $array,array $fieldNames):array{
    $result=[];
    foreach($fieldNames as $field){
        $result[$field] = trim($array[$field]);
    }
    return $result;
}
function encodeFields(array $fields):array{
    $result=[];
    foreach($fields as $key=>$value){
        $result[$key] = htmlspecialchars($value);
    }
    return $result;
}
