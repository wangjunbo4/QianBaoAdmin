<?php
	include_once('mysql.class.php');
	include_once('logincheck.php');
	$db=new Mysql();
	$where="id='".$_GET['id']."'";
	if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
	   {
	      die;
	   }
	if($_GET['obj']=="student"){
		$db->delete("t_student",$where);
		header('location:stutable.php');
	}
	else if($_GET['obj']=="project"){
		$db->delete("t_project",$where);
		header('location:protable.php');
	}
	else if($_GET['obj']=="teacher"){
		$db->delete("t_teacher",$where);
		header('location:teachertable.php');
	}
	else if($_GET['obj']=="laboratory"){
		$db->delete("t_laboratory",$where);
		header('location:laboratorytable.php');
	}
?>