<?php
if(!isset($_COOKIE["uname"])){
	die("<h1>403 Forbidden</h1>");
}
else if(isset($_COOKIE["type"])&&$_COOKIE["type"]<>2){
	die("<h1>403 Forbidden</h1><br>Invalid identity provided !");
}
include("db.php");
include("header.php");
include("shamsi.php");
//---------------------------------------------------------------------------------------
if(isset($_POST["Areport"]))
{
		$p1=$_POST["perfix1"];
		$y=$_POST["year"];
		$m=$_POST["month"];
		$err=false;
		
		for($i=1;$i<=$p1;$i++)
		{
			$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$ostad=$i."ostaddars";
			$tedad=$i."Tedad";
			$paye=$i."Paye";
			$mablagh=$i."Mablagh";
			$pa=$_POST[$paye];
			$pa = str_replace(',', '', $pa);
			$ma=$_POST[$mablagh];
			$ma = str_replace(',', '', $ma);
			
				$sql = "SELECT * FROM `areport` WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ostad]."' AND Month='".$_POST["month"]."' AND Year='".$_POST["year"]."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) 
				{
					// record exists update it
					$sql = "UPDATE areport SET Tedad='".$_POST[$tedad]."', Paye='".$pa."', Mablagh='".$ma."'  WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ostad]."' AND Month='".$_POST["month"]."' AND Year='".$_POST["year"]."'";
				//	echo "UPDATE UPDATE ";
					if ($conn->query($sql) == TRUE) {
						// ok :)
						
					}
					else{
						$err=true;
						$msg1="خطایی پیش آمده است ذخیره جدول انجام نشد";
					}
				}
				else
				{
					// record doesnt exist insert it
					$sql = "INSERT INTO areport(`Username`,`OstadDars`,`Year`,`Month`,`Paye`,`Tedad`,`Mablagh`) VALUES ('".$_COOKIE["uname"]."','".$_POST[$ostad]."','".$_POST["year"]."','".$_POST["month"]."','".$_POST[$tedad]."','".$pa."','".$ma."')";
					//echo "insert insert ";
					if ($conn->query($sql) == TRUE) {
						// ok :)
						
					}
					else{
						$err=true;
						$msg1= "خطایی پیش آمده است ذخیره جدول انجام نشد";
					}
				}
			}
			$conn->close();
		
}
//---------------------------------------------------------------------------------------
if(isset($_POST["tafsili"]))
{
	$p=$_POST["perfix"];
	$y=$_POST["year"];
	$m=$_POST["month"];
	$err=false;
	for($i=1;$i<=$p;$i++)
	{
		$ost=$i."ostaddars";
		for($j=1;$j<=31;$j++)
		{
			$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$varName=$i."ch".$j;
			if(isset($_POST[$varName]))
			{
				
				$sql = "SELECT * FROM `dreport` WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ost]."' AND Month='".$_POST["month"]."' AND Year='".$y."' AND Day='".$_POST[$varName]."'";
				$result = $conn->query($sql);
	
				if ($result->num_rows > 0) 
				{
					// record exists update set checked=1
					$sql = "UPDATE dreport SET Checked=1  WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ost]."' AND Month='".$_POST["month"]."' AND Year='".$y."' AND Day='".$_POST[$varName]."'";
					if ($conn->query($sql) == TRUE) {
						// ok :)
					}
					else{
						$err=true;
						$msg2="خطایی پیش آمده است ذخیره جدول انجام نشد";
					}
				}
				else
				{
					// record doesnt exist insert with checked=1
					$sql = "INSERT INTO dreport(`Username`,`OstadDars`,`Year`,`Month`,`Day`,`Checked`) VALUES ('".$_COOKIE["uname"]."','".$_POST[$ost]."','".$y."','".$m."','".$_POST[$varName]."','1')";
					if ($conn->query($sql) == TRUE) {
						// ok :)
					}
					else{
						$err=true;
						$msg2="خطایی پیش آمده است ذخیره جدول انجام نشد";
					}
				}
			}
			else
			{
				// uncheck chx if exist record j set checked=0
				$sql = "SELECT * FROM `dreport` WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ost]."' AND Month='".$_POST["month"]."' AND Year='".$y."' AND Day='".$j."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) 
				{
					$sql = "UPDATE dreport SET Checked=0  WHERE Username='".$_COOKIE["uname"]."' AND OstadDars='".$_POST[$ost]."'  AND Month='".$_POST["month"]."' AND Year='".$y."' AND Day='".$j."'";
					if ($conn->query($sql) == TRUE) {
						// ok :)
					}
					else{
						$err=true;
						$msg2="خطایی پیش آمده است ذخیره جدول انجام نشد";
					}
				}
			}
			$conn->close();
		}
	}
	if($err==false)
	{
		$msg2="جدول ذخیره شد";
	}
}
//------------------------------------------------------------------------------------
$msg1="";
$msg2="";
	$year=1394;
	$month=1;
	if(isset($_POST["month"])&&isset($_POST["year"])){
			$year=$_POST["year"];
			$month=$_POST["month"];
			setcookie("month",$_POST["month"]);
		setcookie("year",$_POST["year"]);
	}
	else if(isset($_COOKIE["month"])&&isset($_COOKIE["year"]))
	{
		$year=$_COOKIE["year"];
		$month=$_COOKIE["month"];
	}
?>

<!--------------------------------------------------------------------------------------------------->

<style type="text/css">
.calendar {
	direction: rtl;
}
#flat_calendar_1, #flat_calendar_2{
	width: 200px;
}
</style>
</head>

<!--------------------------------------------------------------------------------------------------->

<script type="text/javascript">
timer=setInterval(clearmsg,1000);
var cnt=0;
function clearmsg()
{
	if(cnt<10){
		cnt++;
	}
	else{
	document.getElementById("msg1").innerHTML="";
	document.getElementById("msg2").innerHTML="";
	cnt=0;
	}
}
function YearMonthSubmit()
{
 document.getElementById("YearMonthForm").submit();
}
function format(input)
{
    var num=input.value.replace(/[^\d]/g,'');
    if(num.length>3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    input.value=num;
}
function mark(obj)
{
	obj.parentNode.style.background='yellow';
}
function majmooe()
{
	var n=Number(document.getElementById("perfix1").value);
	var r=0;
	var i=0;
	while(i<=n)
	{
		i++;
		var name=i+"mablagh";
		var n1=document.getElementById(i+"mablagh").value.replace(/,/g,'');
		r=r+Number(n1);
		document.getElementById("majmookol").value=r;
		format(document.getElementById("majmookol"));
	}
	
}
function compute(tedad,paye,mablagh)
{
document.getElementById(tedad).value=document.getElementById(tedad).value.replace(/[^\d.]/g, '');
document.getElementById(paye).value=document.getElementById(paye).value.replace(/[^\d.]/g, '');
format(document.getElementById(paye));
var n1=document.getElementById(paye).value.replace(/,/g,'');
var n2=document.getElementById(tedad).value;
if(n1<0) document.getElementById(paye).value=0;
if(n2<0)var n2=document.getElementById(tedad).value=0;
var r=Number(n1)*Number(n2);
document.getElementById(mablagh).value=r;
format(document.getElementById(mablagh));
majmooe();
//document.getElementById(paye).value=document.getElementById(paye).value.replace(/,/g,'');
//document.getElementById(mablagh).value=document.getElementById(mablagh).value.replace(/,/g,'');
}
</script>

<!--------------------------------------------------------------------------------------------------->

<body onload="clearmsg();">
<center>
<div class="main">
	<img src="./images/user_header.png" width=700px>
	<div name="Info" style="text-align:right;">
		<?php echo "<b>".$_COOKIE["Name"]."</b> ، به بخش کاربران خوش آمدید"."<a href='logout.php'><button>خروج</button></a>"." <br><br>"; ?>
	</div>
	<hr>
	<div name="Global" style="text-align:right;">
	
	<form action="#" method="post" id="YearMonthForm" name="YearMonthForm">
	<label>ماه : </label>&nbsp;
	<select name="month" onchange="YearMonthSubmit();">
		<option value="1" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==1) echo "selected";} else{ if($month==1) echo "selected";} ?>>فروردین</option>
		<option value="2" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==2) echo "selected";} else{ if($month==2) echo "selected";} ?>>اردیبهشت</option>
		<option value="3" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==3) echo "selected";} else{ if($month==3) echo "selected";} ?>>خرداد</option>
		<option value="4" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==4) echo "selected";} else{ if($month==4) echo "selected";} ?>>تیر</option>
		<option value="5" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==5) echo "selected";} else{ if($month==5) echo "selected";} ?>>مرداد</option>
		<option value="6" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==6) echo "selected";} else{ if($month==6) echo "selected";} ?>>شهریور</option>
		<option value="7" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==7) echo "selected";} else{ if($month==7) echo "selected";} ?>>مهر</option>
		<option value="8" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==8) echo "selected";} else{ if($month==8) echo "selected";} ?>>آبان</option>
		<option value="9" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==9) echo "selected";} else{ if($month==9) echo "selected";} ?>>آذر</option>
		<option value="10" <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==10) echo "selected";} else{ if($month==10) echo "selected";} ?>>دی</option>
		<option value="11"> <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==11) echo "selected";} else{ if($month==11) echo "selected";} ?>بهمن</option>
		<option value="12 <?php if (isset($_COOKIE["month"])&&!isset($_POST["month"])){if($_COOKIE["month"]==12) echo "selected";} else{ if($month==12) echo "selected";} ?>">اسفند</option>
	</select>&nbsp;
	<label>سال : </label>&nbsp;
	<select name="year" onchange="YearMonthSubmit();">
		 
		<option value="1396"<?php if (isset($_COOKIE["year"])&&!isset($_POST["year"])){if($_COOKIE["year"]==1396) echo "selected";} else { if($year==1396) echo "selected";}?>>1396</option>
		<option value="1395"<?php if (isset($_COOKIE["year"])&&!isset($_POST["year"])){if($_COOKIE["year"]==1395) echo "selected";} else { if($year==1395) echo "selected";}?>>1395</option>
		<option value="1394"<?php if (isset($_COOKIE["year"])&&!isset($_POST["year"])){if($_COOKIE["year"]==1394) echo "selected";} else { if($year==1394) echo "selected";}?>>1394</option>
		 
	</select>
	
	</form>
	<!--------------------------------------------------------------------------------------------------->
	
	<h3>گزارش چکیده</h3>
	<?php //print_r ($_POST); ?>
	<center>
	<form action="#" method="post">
	<input type="hidden" name="Areport" value="ack">
	<table  dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:600px;'>
	<tr>
	<img src="./images/Report1.png" style="float:right;">
	<td colspan=4 style='background-color: rgb(2, 125, 245);'>
		<?php echo "<font color=yellow>"."گزارش چکیده - ".month_name($month)." ".$year."</font>"; ?>
	</td>
	</tr>
	<tr>
	<th>استاد - درس</th><th>تعداد</th><th>پایه</th><th>مبلغ</th></tr>
	<?php 
	//if(isset($_POST["Report"])||true)
	//{
		echo "<input name='month' type='hidden' value='".$month."'>
		<input name='year' type='hidden' value='".$year."'>";
		$majmoo=0;
		$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT ostaddars FROM `user_ostaddars` WHERE username='".$_COOKIE["uname"]."'";
		$result = $conn->query($sql);
		$perfix1=0;
		if ($result->num_rows > 0) 
		{
			
			while($row = $result->fetch_assoc()){
				$perfix1++;
				echo "<input type='hidden' name='".$perfix1."ostaddars' value='".$row["ostaddars"]."'>";
				echo "<tr><td>".$row["ostaddars"]."</td>";
				$sql = "SELECT * FROM areport WHERE Username='".$_COOKIE["uname"]."' AND Year='".$year."' AND Month='".$month."' AND OstadDars='".$row["ostaddars"]."'";
				if($result2 = $conn->query($sql)){
					if ($result2->num_rows > 0) 
					{	
						while($data = $result2->fetch_assoc()){
							$majmoo+=$data["Mablagh"];
							echo "<td><input type='text' "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"." id='".$perfix1."tedad'".$perfix1."tedad' name='".$perfix1."Tedad' value='".$data["Tedad"]."'></td><td>".
								"<input type='text'  "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"."  id='".$perfix1."paye' name='".$perfix1."Paye' value='".number_format($data["Paye"])."'></td><td>";
								echo "<input type='text' "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"." id='".$perfix1."mablagh' name='".$perfix1."Mablagh' value='".number_format($data["Mablagh"])."' >"."</td>";
						}
					}
				else
				{
					echo "<td><input type='text' "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"." id='".$perfix1."tedad' name='".$perfix1."Tedad' value='0'></td><td>".
								"<input type='text'  "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"."  id='".$perfix1."paye' name='".$perfix1."Paye' value='0'></td><td>";
								echo "<input type='text' "."oninput='compute(\"".$perfix1."tedad\",\"".$perfix1."paye\",\"".$perfix1."mablagh\");'"." id='".$perfix1."mablagh' name='".$perfix1."Mablagh' value='0' >"."</td>";
							
				}
				echo "</tr>";
			}
		}
		
		}
		echo "<input type='hidden' name='perfix1' id='perfix1' value='".$perfix1."'>";
		echo "<tr><td colspan=3><p align='left'>مجموع=</p></td><td><input type=text id='majmookol' disabled=true value='".$majmoo."'></td></tr></table><br>
		<input type='submit' value='ذخیره گزارش چکیده'></form>
		</center>";
		$conn->close();
		
	//}
	?>
	<br><label id="msg1"><?php echo $msg1; ?></label><br>
	<!--------------------------------------------------------------------------------------------------->

	<h3>گزارش تفصیلی</h3>
	
	
		<?php
		
		$conn1 = new mysqli($db_host, $db_user, $db_pass,$db_name);
		if ($conn1->connect_error) {
			die("Connection failed: " . $conn1->connect_error);
		}
		$sql1 = "SELECT * FROM `user_ostaddars` WHERE username='".$_COOKIE["uname"]."'";
		$result1 = $conn1->query($sql1);
		$perfix=0;
		if ($result1->num_rows > 0) 
		{
			
			echo "<form action='#' method='post'>";
			echo "<input type='hidden' name='year' value='".$year."'>";
			echo "<input type='hidden' name='month' value='".$month."'>";
			echo "<input type='hidden' name='tafsili' value='submited'>";
			while($row1 = $result1->fetch_assoc()){
			{
			$perfix++;
			$ostaddars=$row1["ostaddars"];
			$date = new DateTime();
			$gdate=jalali_to_gregorian($year,$month,1,$mod='');
			$date->setDate($gdate[0],$gdate[1],$gdate[2]);
		
		
			$checked=array_fill(0,32,"NOT");
			$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT Day FROM `dreport` WHERE Username='".$_COOKIE["uname"]."' AND Year='".$year."' AND Month='".$month."' AND OstadDars='".$ostaddars."' AND Checked='1'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) 
			{
				while($row = $result->fetch_assoc()){
					$checked[$row["Day"]]="CHKD";
				}
			}
			//debug :: ! print_r ($checked);
			echo "<img src='./images/Report2.png' width=100 height=100 style='float:right;'>
			";
			echo "<input type='hidden' name='".$perfix."ostaddars' value='".$ostaddars."'>";
			
			echo "<center>";
			
			echo "<table  dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:600px;'>
			<tr><td colspan=7 style='background-color: rgb(2, 125, 245);'> ";
			echo "<font color=yellow>".$ostaddars." ".month_name($month)." ماه ".$year."</font>
			</td>
			<tr>
			<th>شنبه</th><th>بکشنبه</th><th>دوشنبه</th><th>سه شنبه</th><th>چهارشنبه</th><th>پنجشنبه</th><th>جمعه</th>
			</tr>";
		
			$dayofweek=$date->getTimestamp();
			$day=1;
			$w=date("w",$dayofweek);
			switch($w)
			{
				case 0:
				$dayofweek=2;
				break;
				case 1:
				$dayofweek=3;
				break;
				case 2:
				$dayofweek=4;
				break;
				case 3:
				$dayofweek=5;
				break;
				case 4:
				$dayofweek=6;
				break;
				case 5:
				$dayofweek=7;
				break;
				case 6:
				$dayofweek=1;
				break;
			}
			
			if($dayofweek>1)
			{
				echo "<tr>";
				for($i=1;$i<$dayofweek;$i++)
				{
					echo "<td>&nbsp;</td>";
				}
				for($i=$dayofweek;$i<=7;$i++)
				{
					if($checked[$day]=="CHKD"){
						echo "<td style='background: rgb(139, 224, 80) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
					}
					else
					{
						echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
					}
					$day++;
				}
				echo "</tr>";
				for($i=1;$i<=5;$i++)
				{
					echo "<tr>";
					for($j=1;$j<=7;$j++)
					{
						if($month<7)
						{
							if($day<=31)
							{
								if($checked[$day]=="CHKD"){
									echo "<td style='background: rgb(139, 224, 80) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
						else
						{
							if($day<=30)
							{
								if($checked[$day]=="CHKD"){
									echo "<td style='background: rgb(139, 224, 80) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
					}
					echo "</tr>";
				}
				
			}
			else
			{
				for($i=1;$i<=5;$i++)
				{
					echo "<tr>";
					for($j=1;$j<=7;$j++)
					{
						if($month<7)
						{
							if($day<=31)
							{
								if($checked[$j]=="CHKD"){
									echo "<td style='background: rgb(139, 224, 80) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
						else
						{
							if($day<=30)
							{
								
								if($checked[$j]=="CHKD"){
									echo "<td style='background: rgb(139, 224, 80) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;'><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
					}
					echo "</tr>";
				}
			}
			echo "</table><br>
			";	
			}
			}
			echo "
			<input type='hidden' name='perfix' value='".$perfix."'>
			
			<input type='submit' value='ذخیره گزارش تفصیلی'>
			
			</form>";
		}
		else
		{
			echo "استاد درس برای این کاربر تخصیص داده نشده است با مدریت تماس بگیرید";
		}
		
		?>
	</center>
	<br><label id="msg2"><?php echo $msg2; ?></label><br>
	</div>
</div>
</center>
</body>
</html>