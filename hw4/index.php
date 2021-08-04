<?php
session_start();
include(__DIR__ . '/init.php');
//Пытается залогинить пользователя(создает токен и/или куки) по данным формы loginFrm и возвращает его при успехе
function login(): ?array
{
	$loginFrm = $_POST['loginFrm'];
	$user = loginUser($loginFrm['login'] ?? null, $loginFrm['password'] ?? null);
	if (!empty($user)) {
		do {
			$token = generateToken();
		} while (!empty($id_session = addSessionToken($token, $user['id'])));
		//Сохраняем в сессии
		$_SESSION['token'] = $token;
		if ($loginFrm['remember']) {
			setcookie('token', $token, time() + 60 * 60, BASE_URL);
		}
	}
	return $user;
};
//Отвечат за авторизацию (login logout и поиск уже залогиненного пользователя)
//Возвращает авторизованного пользователя или null
function getAuthorizedUser(): ?array
{
	$user = null;
	if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['logout'])) {
		clearToken();
	}
	//Проверяем попытки залогинится 
	elseif ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['loginFrm'])) {
		$user = login();
	}
	//Проверяем что пользователь уже авторизован(есть токен)
	else {
		$user = getLoginUser();
	}
	return $user;
}
//Глобальные переменные:
$controller = null; //Контролер для роутинга
$user = null; //Залогиненный пользователь

//Фильтры:
//1)Логирование
addLog(getLogInfo());
//2)Аутентификация
$user = getAuthorizedUser();
//3 Роутинг
$url = $_GET['querysystemurl'] ?? '';
$routes = include('routes.php');
$routerRes = parseUrl(
	$url,
	$routes
);
//Регистрируем параметры запроса
$controller = $routerRes['controller'];
define('URL_PARAMS', $routerRes['params']);
//Ищем такой контроллер и если его нет то  переводим на контролер 404
$pathController = DIRECTORY_CONTROLLER . '/' . $controller . '.php';
if (!file_exists($pathController)) {
	$controller = 'errors/404';
	$pathController = DIRECTORY_CONTROLLER . '/' . $controller . '.php';
}
//Если userLogin null - значит авторизация не пройденна и должны показать форму логин
//иначе должны показать форму logOut
$loginBlock =
	$header = renderTwig(
		'header',
		[
			'loginBlock' => $user === null
				? renderTwig('auth/login', [
					'loginFrm' => $loginFrm ?? null,
					'action' => $url
				])
				: renderTwig('auth/logout', [
					'userLogin' => $user['login'] ?? '',
					'action' => $url
				])
		]
	);
$footer = renderTwig('footer');

//Запускаем контроллер
include_once($pathController);
//Выводим страницу:
$page = renderTwig('layout', [
	'title' => 'Страница статей',
	'header' => $header,
	'content' => $content,
	'footer' => $footer,
]);
echo $page;
