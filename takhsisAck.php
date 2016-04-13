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
	 document.getElementById("addtouser").submit();
}
</script>
</head>
<body>
<div class="login">
<center><br>

<?php
if(isset($_POST["username"]))
{
	echo "آیا استاد-درس ".base64_decode($_POST["ostaddarsid"])." به کاربر ".$_POST["username"]." افزوده شود ؟ ";
}
?>
<br>

<br>
<form action="takhsis.php" name="addtouser" id="addtouser" method="POST">
<input type="hidden" name="username" value=<?php echo $_POST["username"]; ?>>
<input type="hidden" name="ostaddarsid" value=<?php echo $_POST["ostaddarsid"]; ?>>

</form>
<button onclick="submit();">بله</button>&nbsp;
<a href="admin.php"><button>خیر</button></a>
</center>
</div>
</body>
</html>