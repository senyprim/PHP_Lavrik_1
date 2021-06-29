<?php
//DB
define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');
define('BASE_DIR', __DIR__);
//CATEGORY
define('CATEGORY_QUERY_GET_ALL','select * from category');
define('CATEGORY_QUERY_GET', 'select * from category where id= :id');
define('CATEGORY_QUERY_ADD', 'insert  category (name) values (:name)');
define('CATEGORY_QUERY_REMOVE', 'delete from category where id=:id');
define('CATEGORY_QUERY_UPDATE', 'update category set name=:name where id=:id');
define('CATEGORY_QUERY_EXIST', 'select 1 from category where id=:id');

define('CATEGORY_MIN_SIZE_NAME',2);
define('CATEGORY_REGEX_CHECK_ID','/^[1-9]\d*$/');

define('CATEGORY_ERROR_NOT_EXIST','Выбранная категория не существует');
//Article
define('ARTICLE_QUERY_GET_ALL', 'select a.*,b.name as category from article a left join category b on a.id_category=b.id order by a.id');
define('ARTICLE_QUERY_GET', 'select a.*,b.name as category from article a left join category b on a.id_category=b.id where a.id=:id');
define('ARTICLE_QUERY_ADD', 'insert  article (title,content,id_category)
    values (:title,:content,:id_category)');
define('ARTICLE_QUERY_REMOVE', 'delete from article where id=:id');
define('ARTICLE_QUERY_UPDATE', 'update article set title=:title, content=:content, id_category=:id_category where id=:id');
define('ARTICLE_QUERY_EXIST', 'select 1 from article where id=:id');

define('ARTICLE_MIN_SIZE_TITLE',2);
define('ARTICLE_MIN_SIZE_CONTENT',2);
define('ARTICLE_REGEX_CHECK_ID','/^[1-9]\d*$/');
//Logs
define('LOG_DIRECTORY', __DIR__.'/logs');
define('LOG_REGEX_FILE', '/^\d{4}-\d{2}-\d{2}\.txt$/i');

include_once (BASE_DIR.'/core/db.php');
include_once (BASE_DIR.'/core/functions.php');
include_once (BASE_DIR.'/core/system.php');
include_once (BASE_DIR . '/models/logs.php');
include_once (BASE_DIR . '/models/article.php');
addLog(getLogInfo());


$cname = $_GET['c'] ?? 'index';
$path = "controllers/$cname.php";

if (checkControllerName($cname) && is_file($path)){
    include_once($path);
}
else{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	include(BASE_DIR.'/views/errors/error404.php');
}
