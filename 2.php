<?php
session_start();
function sql($sql , $args)
{
	
    $dbh = new PDO('mysql:host=localhost;dbname=bsg;charset=utf8', "root","");
	$sth = $dbh->prepare($sql);
	$sth->execute($args);
	return $sth->fetchAll(PDO::FETCH_ASSOC);
}
function sqlone($sql , $args)
{
	
    $dbh = new PDO('mysql:host=localhost;dbname=bsg;charset=utf8', "root","");
	$sth = $dbh->prepare($sql);
	$sth->execute($args);
	return $sth->fetch(PDO::FETCH_ASSOC);
}
function uri($i = null)
{

	$url = $_SERVER["REQUEST_URI"];
	$url = explode("/", $url);
	if(!$i)
	{
		return $url;
	}
	return $url[$i];
}
function doit()
{
	$ref  = new ReflectionFunction(uri(1)); 
	$data = uri();
    $arguments = array_splice($data, 2); 
    return  $ref->invokeArgs($arguments); 
}
function total($a , $b)
{
	echo $a + $b;
}
function delete($id)
{
	echo $id . "will be deleted";
}
header('Content-Type: application/json; charset=utf-8');
doit();

 ?>
