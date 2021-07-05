<?php
$files=array_slice(user_sort(getLogFiles()),-5);
$active=$_GET['file']??'';

$content = render('two-col-content',[
    'notice'=>null,
    'aside'=>render('logs/aside-log-files',[
        'files'=>$files,
        'active'=>$active,
    ]),
    'article'=>render('logs/view-table-log',[
        'logs'=>getLogFile($active),
        'title'=>$active.':',
        ])
]
);

