<?php
include("db.php");
include("shamsi.php");
$gdate=getdate();
$jdate=gregorian_to_jalali($gdate["year"],$gdate["mon"],$gdate["mday"],'');
setcookie("month",$jdate["1"]-1);
setcookie("year",$jdate["0"]);
$msg="";
function validate($str)
{
	if(strpos($str,'.'))return false;
	if(strpos($str,';'))return false;
	if(strpos($str,'='))return false;
	if(strpos($str,'\''))return false;
	return true;
}
if (isset($_POST["User"]))
{	
	if(validate($_POST["User"]))
	{
	$uname=$_POST["User"];
	$pass=md5($_POST["Pass"]);
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT ID, Password, Type, Name FROM user WHERE Username='".$uname."'";
	if(!$result = $conn->query($sql))
		echo "sql error";
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()){
			if($pass==$row["Password"]){
				setcookie("uname",$_POST["User"]);
				setcookie("type",$row["Type"]);
				setcookie("id",$row["ID"]);
				setcookie("Name",$row["Name"]);
				$loggedin=true;
				switch($row["Type"])
				{
					case 1:
					header("Location: admin.php");
					break;
					case 2:
					header("Location: user.php");
					break;
					case 3:
					header("Location: observer.php");
					break;
				}
				$msg="<a href=panel.php>برای هدایت به پنل کاربری کلیک نمایید</a>";
			}
			else
			{
				$loggedin=false;
				$msg="نام کاربری یا رمز عبور اشتباه است";
			}
		}
	}
	else
	{
		$msg="نام کاربری یا رمز عبور اشتباه است";
	}
	$conn->close();
	}
	else
	{
		$msg="خطا در ورود اطلاعات";
	}
}
include("header.php");
?>
</head>
<body>
<div class="login">
<center>
<img src="./images/login.png" width=120px; height=120px;><Br>
<form name="login" method="Post" action="#">
<input type="text" name="User" placeholder="نام کاربری"><br><br>
<input type="password" name="Pass" placeholder="رمز عبور"><br><br>
<input type="submit" value="ورود">&nbsp; 
<input type="reset" value="از نو">
</form>
<?php
if($msg<>""){echo $msg;}
?>
<hr>
<p>
<img src="http://www.eshia.ir/Images/BaharSound.png" alt="BaharSound">
</p>
<p>
<a href="http://www.baharsound.com/">www.baharsound.com,</a>
<a href="http://www.wikifeqh.ir">www.wikifeqh.ir,</a>
<a href="http://lib.eshia.ir">lib.eshia.ir</a>
</p>
</center>
</div>
</body>
</html>