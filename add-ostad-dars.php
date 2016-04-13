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
if(isset($_POST["ostaddars"]))
{
	$ostaddars=$_POST["ostaddars"];
	if(validate($ostaddars))
	{
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT OstadDars FROM ostad_dars WHERE OstadDars='".$ostaddars."'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
	{
		echo "استاد-درس وارد شده در لیست وجود داشته است"."<br>";
	}
	else
	{
	$sql = "INSERT INTO ostad_dars(`OstadDars`) VALUES ('".$ostaddars."')";
	if ($conn->query($sql) == TRUE) {
		echo "استاد-درس : ".$ostaddars." به لیست افزوده شد <br>";
	}
	else{
		$echo="خطا در ارسال اطلاعات";
	}
	$conn->close();
	}
	}
	else
	{
		echo "داده ارسال شده معتبر نیست";
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