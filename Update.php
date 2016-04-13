<?php
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
if(isset($_POST["ID"]))
{
	$uname=$_POST["Username"];
	$pass=md5($_POST["Password"]);
	$dec_name=base64_decode($_POST["Name"]);
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "UPDATE `user` SET `Password` = '".$pass."',`Username` = '".$uname."',`Name` = '".$dec_name."'  WHERE `user`.`ID` ='".$_POST["ID"]."'";
	if ($conn->query($sql) == TRUE) {
		echo "اطلاعات کاربر بروزرسانی شد";
	}
	else{
		echo "خطا در بروزرسانی اطلاعات";
	}
	$conn->close();
}
else
{
	echo "خطا در اطلاعات ارسال شده";
}
?>
<br>
<br>
<a href="admin.php"><button>بازگشت</button></a>
</center>
</div>
</body>
</html>