<?php

return (function(){
    $normInt = '[1-9]+\d*';
	$normStr = '[0-9aA-zZ_-]+';
	$normLog = '20[12]\d-[01]\d-[012]\d';
    return [
        [
            'route'=>"/^articles\/?$/",
            'controller'=>'article/index',
            'roles'=>['guest','users','admins'],
            'params'=>['id_category'=>null]
        ],
        [
            'route'=>"/^article\/add\/?$/",
            'roles'=>['users','admins'],
            'controller'=>'article/add',
        ],
        [
            'route'=>"/^article\/delete\/?$/",
            'controller'=>'article/delete',
            'roles'=>['admins'],
            'params'=>['id'=>1]
        ],
        [//Можно было сделать два маршрута (второй нужен для формы передающей параметры в POST а не в GET)
            'route'=>"/^article\/edit(\/($normInt))?\/?$/",
            'controller'=>'article/edit',
            'roles'=>['users','admins'],
            'params'=>['id'=>2]
        ],
        [
            'route'=>"/^article\/($normInt)\/?$/",
            'controller'=>'article/article',
            'roles'=>['guest','users','admins'],
            'params'=>['id'=>1]
        ],
        [
            'route'=>"/^category\/?$/",
            'controller'=>'category/index',
            'roles'=>['guest','users','admins'],
            'params'=>['id'=>null]
        ],
        [
            'route'=>"/^category\/add\/?$/",
            'roles'=>['admins'],
            'controller'=>'category/add',
        ],
        [
            'route'=>"/^category\/delete\/?$/",
            'controller'=>'category/delete',
            'roles'=>['admins'],
            'params'=>['id'=>1]
        ],
        [//Можно было сделать два маршрута (второй нужен для формы передающей параметры в POST а не в GET)
            'route'=>"/^category\/edit(\/($normInt))?\/?$/",
            'controller'=>'category/edit',
            'roles'=>['admins'],
            'params'=>['id'=>2]
        ],
        [
            'route'=>"/^category\/($normInt)\/?$/",
            'controller'=>'category/index',
            'roles'=>['guest','users','admins'],
            'params'=>['id'=>1]
        ],
        
        [
            'route'=>"/^logs\/?$/",
            'roles'=>['admins'],
            'controller'=>'logs/log',
        ],
        [
            'route'=>"/^logs\/($normLog)\/?$/",
            'controller'=>'logs/log',
            'roles'=>['admins'],
            'params'=>['log_date'=>1]
        ],
        [
            'route'=>"/^$/",
            'roles'=>['guest','users','admins'],
            'controller'=>'article/index',
        ],
        
        [
            'route'=>"/^register\/?$/",
            'roles'=>['guest','users','admins'],
            'controller'=>'auth/register',
        ]
    ];
})();
