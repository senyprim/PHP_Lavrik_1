<?php
function checkControllerName($name){
    return !!preg_match('/^[a-z0-9\-]+/',$name??'');
}
function render(string $template, array $variableForTemplate=[]):?string {
    extract($variableForTemplate);
    ob_start();
    include(BASE_DIR_VIEW.'/'.$template.'.php');
    $result= ob_get_clean();
    return $result;
}