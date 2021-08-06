<?php
function checkControllerName($name)
{
    return !!preg_match('/^[a-z0-9\-]+/', $name ?? '');
}
function render(string $template, array $variableForTemplate = []): ?string
{
    extract($variableForTemplate);
    ob_start();
    include(BASE_DIR_VIEW . '/' . $template . '.php');
    $result = ob_get_clean();
    return $result;
}

function renderTwig(string $path, array $vars=[]): string
{
    static $twig;
    if ($twig === null) {
        $loader = new Twig_Loader_Filesystem('templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => 'cache/twig',
            'auto_reload' => true,
            'autoescape' => false,
            'strict_variables' => true
        ));
    }
    return $twig->render("$path.twig",$vars);
}
function parseUrl(string $url, array $routs): array
{
    $result = [
        'controller' => 'errors/404',
        'params' => [],
    ];

    foreach ($routs as $route) {
        $matches = [];
        if (preg_match($route['route'], $url, $matches)) {
            $result['controller'] = $route['controller'];
            $result['roles'] = $route['roles'];
            
            if (isset($route['params'])) {
                foreach ($route['params'] as $key => $value) {
                    $result['params'][$key] = $matches[$value];
                }
            }
            break;
        }
    }

    return $result;
}
function generateToken(?string $alpha=null):?string{
    $result='';
    $alpha=$alpha??'abcdefghijklmnopqrstuvwxyz';
    for($index=0;$index<strlen($alpha)-1;$index++)
        $result.=$alpha[random_int(0,strlen($alpha)-1)];
    return $result;
}