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
<center>
<div class="main">

	<img src="./images/admin_header.png" width=700px>
	<div name="Info" style="text-align:right;">
	<?php echo $_COOKIE["Name"]." ، به بخش مدیریت خوش آمدید "."<a href='logout.php'><button>خروج</button></a>&nbsp;&nbsp;<a href='admin.php'><button>بازگشت به پنل مدیریت</button></a>"."<br><br>"; ?>
	</div>
	
	<center><table dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
	<tr><td  style='background-color: rgb(2, 125, 245);'>
	جدول استاد - درس
	</td>
	</tr>
	<tr>
	<br>
	<?php
	$listUserCommand="SELECT * FROM ostad_dars";
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if (isset($tp))
	echo "<p align=left>Results Filter : ".$tp."</p>";
	$result = $conn->query($listUserCommand);
	if ($result->num_rows > 0) 
	{
		
		echo "<center><table dir='ltr' border=1 style='text-align: left; width:700px;'><tr><th align='center'>حذف</th><th align='center'>ذخیره</th><th align='center'>استاد درس</th></tr>";
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td align='center'><form action='ODdeleteAck.php' method='post'><input type='hidden' name='OstadDars' value='".$row["OstadDars"]."'> <input type='image' src='./images/delete.png' width=40px height=40px border='0' alt='Submit' /></form></td>";
			echo "<form action='ODUpdateAck.php' method='post'><input type=hidden name='ID' value='".$row["ID"]."'><td align='center'> <input type='image' src='./images/save.png' width=40px height=40px border='0' alt='Submit' /></td>";
			echo "<td align='center'><input type=text name='OstadDars' value='".$row["OstadDars"]."'></td>";
			echo "</tr></form>";
		}
		echo "</table></center>";
	}
	else
	{
		echo "<h3>اطلاعاتی برای نمایش وجود ندارد</h3>";
	}
	$conn->close();
	?>
	</tr></table></center><br>
	<br>
	</div>
	<br>
	<br>
</div>
</center>
</body>
</html>