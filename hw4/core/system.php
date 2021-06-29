<?php
function checkControllerName($name){
    return !!preg_match('/^[a-z0-9\-]+/',$name??'');
}
