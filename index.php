<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

spl_autoload_register(function ($class_name) {
    include __DIR__.'/'.$class_name.'.php';
});

/**
 * Create DB table if not exist.
 *
 */
try {
	$db = DB::connect();
	$sm = $db->getSchemaManager();
} catch (Exception $e) {
    echo Response::send(false, $e->getMessage(), $e->getCode(), null);
}

$tables = array_map(function($table) { return $table->getName(); }, $sm->listTables());

if (!in_array('phonebook', $tables)) {
	CreateTableMigration::up();
}

/**
 * Proceed request
 *
 */
$request = new Request();

if ($request->urls()[0] != "record") {
	echo Response::send(FALSE,'Invalid URL param');
	die();
}

/**
 * REST Routing
 *
 */
switch ($request->method) {

	case ('GET') :
		echo RestController::index($request);
		break;

	case ('POST') :
		echo RestController::store($request);
		break;

	case ('PUT') :
		echo RestController::fullupdate($request);
		break;

	case ('PATCH') :
		echo RestController::update($request);
		break;

	case ('DELETE') :
		echo RestController::destroy($request);
		break;

	default :
		echo Response::send(FALSE,'Invalid request method');
		break;
}
