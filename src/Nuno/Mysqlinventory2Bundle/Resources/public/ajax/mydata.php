<?php

header('content-type: application/json; charset=utf-8');
include('../class/mysql_crud.php');

if (isset($_GET["action"]) && $_GET["action"] == "getDBs") {
	$db = new Database();
	$db->connect();
	$db->sql("SET NAMES utf8");

	$db->sql("SHOW DATABASES");
	$res = $db->getResult();

	echo json_encode($res);
// Get list of tables for the selected database
} else if (isset($_GET["action"]) && $_GET["action"] == "getTables") {
	$dbname = $_GET["db"];

	$db = new Database();
	$db->connect();
	$db->sql("SET NAMES utf8");

	// $db->sql('SHOW TABLES IN ' . $dbname);
	$db->sql("SHOW TABLES IN " . $dbname);
	$res = $db->getResult();

	echo json_encode($res);
// Get table details
} else if (isset($_GET["action"]) && $_GET["action"] == "getTableDefinition") {
	$dbname = $_GET["db"];
	$tblname = $_GET["table"];

	$db = new Database();
	$db->connect();
	// Magic stuff alert: deal with characters that cannot be represented in pure ASCII, like "©" ;)
	$db->sql("SET NAMES utf8");

	$db->sql("SELECT COUNT(*) AS total_recs FROM " . $dbname . "." . $tblname);
	$res1 = $db->getResult();

	$db->sql("SHOW TABLE STATUS FROM " . $dbname . " LIKE '" . $tblname . "'");
	$res2 = $db->getResult();

	$db->sql("SELECT COUNT(COLUMN_NAME) AS column_count FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '" . $dbname . "' AND table_name = '" . $tblname . "'");
	$res3 = $db->getResult();

	$db->sql("SHOW COLUMNS FROM " . $dbname . "." . $tblname);
	$res4 = $db->getResult();

	$db->sql("SELECT * FROM " . $dbname . "." . $tblname);
	$res5 = $db->getResult();

	$res = array_merge($res1, $res2, $res3, $res4, $res5);

	echo json_encode($res);
}