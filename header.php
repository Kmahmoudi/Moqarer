<?php
function month_name($m)
{
	switch ($m)
	{
		case 1:
		 return "فروردین";
		case 2:
		 return "اردیبهشت";
		case 3:
		 return "خرداد";
		case 4:
		 return "تیر";
		case 5:
		 return "مرداد";
		case 6:
		 return "شهریور";
		case 7:
		 return "مهر";
		case 8:
		 return "آبان";
		case 9:
		 return "آذر";
		case 10:
		 return "دی";
		case 11:
		 return "بهمن";
		case 12:
		 return "اسفند";
	}
	return " ";
}
?>
<html dir="rtl" charset="utf-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>سامانه مقرر</title>
<style type="text/css">

html { 
  background: url("./images/background.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
a:link { color: yellow;}

a:visited { color: yellow; }

a:hover { color: white;}

a:active { color: white;}

.main {
    top: 50px;
	width: 850px;
    background-color: rgba(21, 204, 243, 0.85);
}

.login {
    position: fixed;
    left: 33%;
    top: 25%;
	width: 33%;
    height: 425px;
    background-color: rgba(21, 204, 243, 0.85);
}



.login input[type="text"], .login input[type="password"]
{
	width:120px;
	height:40px;
	text-align: center;
	
}

</style>
