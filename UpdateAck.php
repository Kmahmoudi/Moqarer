<?php
if(!isset($_COOKIE["uname"])){
	die("<h1>403 Forbidden</h1>");
}
else if(isset($_COOKIE["type"])&&$_COOKIE["type"]<>1){
	die("<h1>403 Forbidden</h1><br>You do not have admin permissions !");
}

include("header.php");
?>
<script type="text/JavaScript">
function submit()
{
	 document.getElementById("update").submit();
}
</script>
</head>
<body>
<div class="login">
<center><br>

<img src="./images/alert.png" width="90px" height="90px">
<br><br>
<?php
if(isset($_POST["ID"]))
{
	echo "<p align='right'> <b>ویرایش اطلاعات کاربر</b><br>
	نام و نام خانوادگی : ".$_POST["Name"]."<br>نام کاربری : ".$_POST["Username"]."<br> 
	رمز عبور : ".$_POST["Password"]."<br>";
}
else
{
	echo "مشکل در اطلاعات ارسال شده";
}
?>
<br>

<br>
<form action="Update.php" name="Update" id="update" method="POST">
<input type="hidden" name="ID" value="<?php echo $_POST["ID"]; ?>">
<input type="hidden" name="Username" value="<?php echo $_POST["Username"]; ?>">
<input type="hidden" name="Name" value="<?php echo base64_encode($_POST["Name"]); ?>">
<input type="hidden" name="Password" value="<?php echo $_POST["Password"]; ?>">

</form>
<button onclick="submit();">تایید و ذخیره</button>&nbsp;
<a href="admin.php"><button>انصراف</button></a>
</center>
</div>
</body>
</html>