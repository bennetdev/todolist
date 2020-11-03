<?php
session_start();
if(!isset($_SESSION['user_id'])){
	$dirname =  __DIR__;
	if(strpos($dirname, "php")){
		header("Location: ../index.php");
	}
	else{
		header("Location: index.php");
	}
}