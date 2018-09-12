<?php
	if(isset($_SESSION['id'])&&!empty($_SESSION['id']))
	  {
	    require_once('mysql.class.php');
	    $db=new Mysql();
	    
	    $sql="select static from t_teacher where id='".$_SESSION['id']."'";

	    if($db->connect($dbhost,$dbuser,$dbpassword,$dbname))
	    {
	      echo "数据库连接错误";
	      die;
	    }
	    $row=$db->findAll($sql);
	    if($row[0]['static']!="1")
	    {
	      header('location:index.php');
	    }
	  }
	  else
	  {
	  	header('location:index.php');
	  }
?>