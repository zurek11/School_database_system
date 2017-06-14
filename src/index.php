<?php

require 'vendor/autoload.php';


$myApp = new App(new Dotenv\Dotenv(__DIR__));
$myApp->autoload();

$app = new \Slim\Slim(array(
	'public.path'    => __DIR__ . '/public',
	'templates.path' => __DIR__ . '/app/view',
	'files.path'     => __DIR__ . '/public/files',
	'view'           => new \Slim\Views\Twig(),
	'user'           => null
));

chdir("public");

// routes
require 'routes/core.php';

$app->run();
