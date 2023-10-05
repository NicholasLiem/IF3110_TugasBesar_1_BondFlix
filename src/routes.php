<?php
global $routes;
global $container;

use Handler\Auth\LoginHandler;
use Handler\Auth\LogoutHandler;
use Handler\Auth\RegisterHandler;
use Handler\Genre\GenreHandler;
use Handler\User\UserHandler;
use Middleware\API\APIAdminCheck;
use Middleware\Page\AdminCheck;
use Middleware\Page\LoggedInCheck;
use Router\Router;
use Handler\Content\ContentHandler;
use Handler\Content\ContentActorHandler;
use Handler\Content\ContentCategoryHandler;
use Handler\Content\ContentDirectorHandler;
use Handler\Content\ContentGenreHandler;
use Handler\Upload\UploadHandler;

/**
 * Registering the singleton handlers
 */
$loginHandler = LoginHandler::getInstance($container);
$registerHandler = RegisterHandler::getInstance($container);
$logoutHandler = LogoutHandler::getInstance($container);
$uploadHandler = UploadHandler::getInstance($container);
$userHandler = UserHandler::getInstance($container);
$contentHandler = ContentHandler::getInstance($container);
$contentActorHandler = ContentActorHandler::getInstance($container);
$contentCategoryHandler = ContentCategoryHandler::getInstance($container);
$contentDirectorHandler = ContentDirectorHandler::getInstance($container);
$contentGenreHandler = ContentGenreHandler::getInstance($container);
$genreHandler = GenreHandler::getInstance($container);

/**
 * Making new router instance
 */
$router = new Router();


/**
 * Registering the page routes
 */
$router->addPage('/', function () {
    redirect('index');
});

$router->addPage('/login', function () {
    redirect('login');
}, []);

$router->addPage('/dashboard', function () {
    redirect('dashboard');
}, [LoggedInCheck::getInstance()]);

$router->addPage('/register', function ($urlParams) {
    redirect('register', ['urlParams' => $urlParams]);
});

$router->addPage('/account', function () {
    redirect('account');
}, [LoggedInCheck::getInstance()]);

$router->addPage('/admin', function () {
    redirect('admin');
}, [LoggedInCheck::getInstance(), AdminCheck::getInstance()]);

$router->addPage('/admin/movies', function () {
    redirect('admin-movies');
}, [LoggedInCheck::getInstance(), AdminCheck::getInstance()]);

$router->addPage('/admin/users', function () {
    redirect('admin-users');
}, [LoggedInCheck::getInstance(), AdminCheck::getInstance()]);

$router->addPage('/admin/media/management', function () {
    redirect('admin-media-management');
}, [LoggedInCheck::getInstance(), AdminCheck::getInstance()]);

$router->addPage('/admin/movies/upload', function() {
    redirect('admin-movie-upload');
}, [LoggedInCheck::getInstance(), AdminCheck::getInstance()]);

/**
 * Registering the api routes
 */

$router->addAPI('/api/auth/login', 'POST', $loginHandler, []);;
$router->addAPI('/api/auth/register', 'POST', $registerHandler, []);;
$router->addAPI('/api/auth/logout', 'POST', $logoutHandler, [LoggedInCheck::getInstance()]);;

$router->addAPI('/api/users', 'GET', $userHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/users', 'DELETE', $userHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/users', 'PUT', $userHandler, [APIAdminCheck::getInstance()]);

//TODO: add middleware if needed
$router->addAPI('/api/content', 'GET', $contentHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content', 'POST', $contentHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content', 'PUT', $contentHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content', 'DELETE', $contentHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/content/actor', 'GET', $contentActorHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/actor', 'POST', $contentActorHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/actor', 'DELETE', $contentActorHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/content/category', 'GET', $contentCategoryHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/category', 'POST', $contentCategoryHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/category', 'DELETE', $contentCategoryHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/content/director', 'GET', $contentDirectorHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/director', 'POST', $contentDirectorHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/director', 'DELETE', $contentDirectorHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/content/genre', 'GET', $contentGenreHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/genre', 'POST', $contentGenreHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/content/genre', 'DELETE', $contentGenreHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/genre', 'GET', $genreHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/genre', 'POST', $genreHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/genre', 'PUT', $genreHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/genre', 'DELETE', $genreHandler, [APIAdminCheck::getInstance()]);

$router->addAPI('/api/upload', 'GET', $uploadHandler, [APIAdminCheck::getInstance()]);
$router->addAPI('/api/upload', 'POST', $uploadHandler, [APIAdminCheck::getInstance()]);

/**
 * Setting api or page fallback handler
 */

$router->setPageNotFoundHandler(function () {
    require_once BASE_PATH . '/public/view/404.php';
});

$router->setApiNotFoundHandler(function () {
    require_once BASE_PATH . '/public/view/404.php';
});

$router->run();