<?php

require 'vendor/autoload.php';
require_once('tools/fonctions.php');


if(preg_match('/wamp/', $_SERVER['DOCUMENT_ROOT'])) {
	define('DEBUG', true);
	define('BASE_URL', '/museo/admin/');
	define('DB_NAME', 'museotouch');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB', '127.0.0.1');
}

define('DIR_PHOTO', '/assets/img/objets/');
define('DIR_PHOTO_OBJETS', DIR_PHOTO.'objets/');

$db = connect(); // http://www.notorm.com/ beaucoup d'example sur : http://sql-cross-queries.freexit.eu/

\Slim\Route::setDefaultConditions(array(
	'id' => '[0-9]{1,}'
));

$app = new \Slim\Slim(array(
    'debug' => true
));

$app->contentType('text/html; charset=utf-8');