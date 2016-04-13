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
	 document.getElementById("delete").submit();
}
</script>
</head>
<body>
<div class="login">
<center><br>

<img src="./images/alert.png" width="90px" height="90px">
<br><br>
<?php
if(isset($_POST["OstadDars"]))
{
	echo "  آیا از حذف استاد درس ".$_POST["OstadDars"]." اطمینان دارید ؟  ";
}
?>
<br>

<br>
<form action="UODdelete.php" name="ODdelete" id="delete" method="POST">
<input type="hidden" name="OstadDars" value="<?php echo base64_encode($_POST["OstadDars"]); ?>">

</form>
<button onclick="submit();">بله</button>&nbsp;
<a href="userODview.php"><button>خیر</button></a>
</center>
</div>
</body>
</html>