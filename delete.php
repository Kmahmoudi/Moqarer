﻿<?php
if(!isset($_COOKIE["uname"])){
	die("<h1>403 Forbidden</h1>");
}
else if(isset($_COOKIE["type"])&&$_COOKIE["type"]<>1){
	die("<h1>403 Forbidden</h1><br>You do not have admin permissions !");
}
include("db.php");
include("header.php");
?>

</head>
<body>
<div class="login">
<center><br>

<br><br>
<?php
if(isset($_POST["Username"]))
{
	$uname=$_POST["Username"];
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "DELETE FROM `user` WHERE `user`.`Username` = '".$_POST["Username"]."'";
	if ($conn->query($sql) == TRUE) {
		echo "نام کاربری ".$_POST["Username"]." از لیست کاربران حذف گردید";
	}
	else{
		$echo="خطا در حذف کاربر";
	}
	$conn->close();
}
?>
<br>
<br>
<a href="admin.php"><button>بازگشت</button></a>
</center>
</div>
</body>
</html>