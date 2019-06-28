<?php
	session_start();
	error_reporting(E_ALL);
	include("XTemplate.class.php");
	include("Model.class.php");
	include("app.class.php");
	$baseUrl = "http://".$_SERVER['HTTP_HOST']."/";
	$dsn="mysql:host=localhost;port=33060;dbname=petbottle";
	$usr = 'kurokeita';
	$pwd = 'harunonaru';
	$db = new Model($dsn,$usr,$pwd);
	$f = new app;