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
	echo "<p align='right'> <b>ویرایش استاد درس</b> ".$_POST["OstadDars"]."<br>";
}
else
{
	echo "مشکل در اطلاعات ارسال شده";
}
?>
<br>

<br>
<form action="ODUpdate.php" name="Update" id="update" method="POST">
<input type="hidden" name="ID" value="<?php echo $_POST["ID"]; ?>">
<input type="hidden" name="OstadDars" value="<?php echo base64_encode($_POST["OstadDars"]); ?>">

</form>
<button onclick="submit();">تایید و ذخیره</button>&nbsp;
<a href="ostaddarsview.php"><button>انصراف</button></a>
</center>
</div>
</body>
</html>