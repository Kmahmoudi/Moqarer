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
	
	$OD=base64_decode($_POST["OstadDars"]);
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "UPDATE `ostad_dars` SET `OstadDars` = '".$OD."'  WHERE `ostad_dars`.`ID` ='".$_POST["ID"]."'";
	if ($conn->query($sql) == TRUE) {
		echo "اطلاعات استاد درس ویرایش گردید";
	}
	else{
		echo "خطا در بروزرسانی اطلاعات"."<br>".mysqli_error($conn);
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
<a href="ostaddarsview.php"><button>بازگشت</button></a>
</center>
</div>
</body>
</html>