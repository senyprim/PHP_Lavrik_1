<?php

return (function(){
    $normInt = '[1-9]+\d*';
	$normStr = '[0-9aA-zZ_-]+';
	$normLog = '20[12]\d-[01]\d-[012]\d';
    return [
        [
            'route'=>"/^articles\/?$/",
            'controller'=>'article/index',
            'params'=>['id_category'=>null]
        ],
        [
            'route'=>"/^article\/add\/?$/",
            'controller'=>'article/add',
        ],
        [
            'route'=>"/^article\/delete\/?$/",
            'controller'=>'article/delete',
            'params'=>['id'=>1]
        ],
        [//Можно было сделать два маршрута (второй нужен для формы передающей параметры в POST а не в GET)
            'route'=>"/^article\/edit(\/($normInt))?\/?$/",
            'controller'=>'article/edit',
            'params'=>['id'=>2]
        ],
        [
            'route'=>"/^article\/($normInt)\/?$/",
            'controller'=>'article/article',
            'params'=>['id'=>1]
        ],

        [
            'route'=>"/^category\/?$/",
            'controller'=>'category/index',
            'params'=>['id'=>null]
        ],
        [
            'route'=>"/^category\/add\/?$/",
            'controller'=>'category/add',
        ],
        [
            'route'=>"/^category\/delete\/?$/",
            'controller'=>'category/delete',
            'params'=>['id'=>1]
        ],
        [//Можно было сделать два маршрута (второй нужен для формы передающей параметры в POST а не в GET)
            'route'=>"/^category\/edit(\/($normInt))?\/?$/",
            'controller'=>'category/edit',
            'params'=>['id'=>2]
        ],
        [
            'route'=>"/^category\/($normInt)\/?$/",
            'controller'=>'category/index',
            'params'=>['id'=>1]
        ],
        
        [
            'route'=>"/^logs\/?$/",
            'controller'=>'logs/log',
        ],
        [
            'route'=>"/^logs\/($normLog)\/?$/",
            'controller'=>'logs/log',
            'params'=>['log_date'=>1]
        ],
        [
            'route'=>"/^$/",
            'controller'=>'article/index',
        ],
    ];
})();
