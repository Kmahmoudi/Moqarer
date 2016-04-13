<?php
if(!isset($_COOKIE["uname"])){
	die("<h1>403 Forbidden</h1>");
}
else if(isset($_COOKIE["type"])&&$_COOKIE["type"]<>1){
	die("<h1>403 Forbidden</h1><br>You do not have admin permissions !");
}
function validate($str)
{
	if($str="")return false;
	if(strpos($str,'.'))return false;
	if(strpos($str,';'))return false;
	if(strpos($str,'='))return false;
	if(strpos($str,'\''))return false;
	if(strpos($str,'--'))return false;
	return true;
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
$exists=false;
if(isset($_POST["ostaddarsid"]))
{
	
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM `user_ostaddars` WHERE username='".$_POST["username"]."' AND ostaddars='".base64_decode($_POST["ostaddarsid"])."'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
	{
				echo "استاد-درس وارد شده در لیست وجود داشته است"."<br>";

	}
	else
	{
	$sql = "INSERT INTO user_ostaddars(`username`,`ostaddars`) VALUES ('".$_POST["username"]."','".base64_decode($_POST["ostaddarsid"])."')";
	if ($conn->query($sql) == TRUE) {
		echo "استاد-درس : ".base64_decode($_POST["ostaddarsid"])." به کاربر ".$_POST["username"]." افزوده شد";
	}
	else{
		$echo="خطا در ارسال اطلاعات";
	}
	$conn->close();
	}
}
?>
<br>
<br>
<a href="admin.php"><button>بازگشت</button></a>
</center>
</div>
</body>
</html>