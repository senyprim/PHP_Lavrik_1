<?php
//SYSTEM
const BASE_DIR= __DIR__;
const BASE_URL = 'lavrik.local/hw4/';

//DB
        const DB_HOST= 'localhost';
        const DB_NAME= 'test';
        const DB_USER= 'root';
        const DB_PASS= '';
        const DB_CHAR= 'utf8';
        //CATEGORY
        const CATEGORY_QUERY_GET_ALL='select * from category';
        const CATEGORY_QUERY_GET= 'select * from category where id= :id';
        const CATEGORY_QUERY_ADD= 'insert  category (name) values (:name)';
        const CATEGORY_QUERY_REMOVE= 'delete from category where id=:id';
        const CATEGORY_QUERY_UPDATE= 'update category set name=:name where id=:id';
        const CATEGORY_QUERY_EXIST= 'select 1 from category where id=:id';

        const CATEGORY_MIN_SIZE_NAME=2;
        const CATEGORY_REGEX_CHECK_ID='/^[1-9]\d*$/';

        const CATEGORY_ERROR_NOT_EXIST='Выбранная категория не существует';
        //Article
        const ARTICLE_QUERY_GET_ALL= 'select a.*,b.name as category from article a left join category b on a.id_category=b.id order by a.id';
        const ARTICLE_QUERY_GET= 'select a.*,b.name as category from article a left join category b on a.id_category=b.id where a.id=:id';
        const ARTICLE_QUERY_ADD= 'insert  article (title,content,id_category)
            values (:title,:content,:id_category)';
        const ARTICLE_QUERY_REMOVE= 'delete from article where id=:id';
        const ARTICLE_QUERY_UPDATE= 'update article set title=:title, content=:content, id_category=:id_category where id=:id';
        const ARTICLE_QUERY_EXIST= 'select 1 from article where id=:id';

        const ARTICLE_MIN_SIZE_TITLE=2;
        const ARTICLE_MIN_SIZE_CONTENT=2;
        const ARTICLE_REGEX_CHECK_ID='/^[1-9]\d*$/';
//Logs
const LOG_DIRECTORY= __DIR__.'/logs';
const LOG_REGEX_FILE= '/^\d{4}-\d{2}-\d{2}\.txt$/i';
//Views
const BASE_DIR_VIEW=BASE_DIR.'/templates';

include_once (BASE_DIR.'/core/db.php');
include_once (BASE_DIR.'/core/functions.php');
include_once (BASE_DIR.'/core/system.php');
include_once (BASE_DIR . '/models/logs.php');
include_once (BASE_DIR . '/models/article.php');