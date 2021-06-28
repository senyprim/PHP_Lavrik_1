<?php
 function checkId(?string $id): bool{
    return !!preg_match('/^[1-9]\d*$/',$id);
}
function indexOfId(array $array,?int $id):int{
    if (!$array || $id==null) return -1;
    foreach($array as $key=>$item){
        if (isset($item['id']) && $item['id']==$id) return $key;
    }
    return -1;
}
function containsId(array $array, ?int $id):bool{
    return indexOfId($array,$id)>=0;
}