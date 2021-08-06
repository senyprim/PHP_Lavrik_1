<?php
$files=array_slice(user_sort(getLogFiles()),-5);
$active= URL_PARAMS['log_date'];
$aside=renderTwig('logs/aside-log-files',[
    'files'=>$files,
    'active'=>$active,
]);

$content = renderTwig('two-col-content',[
    'notice'=>null,
    'aside'=>renderTwig('logs/aside-log-files',[
        'files'=>$files,
        'active'=>$active,
    ]),
    'article'=>renderTwig('logs/view-table-log',[
        'logs'=>getLogFile(($active??'').'.txt'),
        'title'=>$active.':',
        ])
]
);

