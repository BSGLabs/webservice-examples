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

header('Content-Type: application/json; charset=utf-8');

if(isset($_GET["delete"]))
{
	if(isset($_SESSION["kim"]) && count($_POST) == 0) 
	{
		$data = sql("Delete users  where id = ? ",
			[ $_SESSION["kim"] ]);
		echo "silindi";
	}
	else
	{
		echo "eksik parametre";
	}
	session_destroy();
	die();
}
else if(isset($_GET["update"]))
{
	if(isset($_SESSION["kim"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && $_POST["pass"] == $_POST["pass2"])
	{
		$data = sql("Update users set password = ? where id = ? ",
			[ $_POST["pass"],$_SESSION["kim"] ]);
		echo "şifre güncellendi";
	}
	else
	{
		echo "eksik parametre";
	}
}
else if(isset($_GET["register"]))
{
	if(isset($_POST["username"]) && isset($_POST["pass"]))
	{
		$data = sql("Insert into users(username,password) Values(?,?)",
			[ $_POST["username"],$_POST["pass"] ]);
		echo "kayıt başarılı";
	}
	else
	{
		echo "eksik parametre";
	}
}
else if(isset($_GET["cikis"]))
{
	session_destroy();
}
else if(isset($_SESSION["kim"]))
{
	$data = sqlone("Select * from users where id = ? " , [$_SESSION["kim"]]);
	echo "hosgeldin" . $data["username"];
}
else
{
	if(isset($_POST["username"]) && isset($_POST["pass"]))
	{
		$data = sql("Select * from users where username = ? and password = ?",
			[ $_POST["username"],$_POST["pass"] ]);
		if(count($data) > 0 )
		{
			$_SESSION["kim"] = $data[0]["id"];
			echo "giriş başarılı";	
		}
		else
		{
			echo "yanlış şifre";
		}
	}
	else
	echo "login ol";
}
#echo json_encode(sql("Select * from users",[]));
 ?>
