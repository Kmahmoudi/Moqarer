<?php
if(!isset($_COOKIE["uname"])){
	die("<h1>403 Forbidden</h1>");
}
else if(isset($_COOKIE["type"])&&$_COOKIE["type"]<>1){
	die("<h1>403 Forbidden</h1><br>You do not have admin permissions !");
}
include("db.php");
$AddUserMSG="";
//------------------------------------------------------------------------------------
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
//------------------------------------------------------------------------------------

if(isset($_POST["AddUser"]))
{
	$uname=$_POST["Username"];
	$pass=md5($_POST["Password1"]);
	$type=$_POST["Type"];
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT Username FROM user WHERE Username='".$uname."'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
	{
		$AddUserMSG="نام کاربری تکراری می باشد"."<br>";
	}
	else
	{
		$sql = "INSERT INTO user(`UserName`, `Password`, `Type`,`Name`) VALUES ('".$uname."','".$pass."','".$type."','".$_POST["Name"]."')";
		if ($conn->query($sql) == TRUE) {
			$AddUserMSG="کاربر اضافه شد";
		}
		else{
			$AddUserMSG="خطا در ارسال اطلاعات";
		}
	}
	$conn->close();
	
}
//------------------------------------------------------------------------------------
include("header.php");
?>
<script type="text/JavaScript">

timer2=setInterval(checkdata,100);
timer=setInterval(clearmsg,1000);
var cnt=0;
function clearmsg()
{
	if(cnt<10){
		cnt++;
	}
	else{
	document.getElementById("AddusermsgLabel").innerHTML="";
	cnt=0;
	}
}
var set_un=false;
function checkdata()
{
if(!set_un)
{
	if(document.getElementById("usr").value!='')
	{
	document.getElementById("usr_nm").value=document.getElementById("usr").value;
	set_un=true;

	}
}
var user=document.forms["AddUser"]["Username"].value;

var pass1=document.forms["AddUser"]["Password1"].value;
var pass2=document.forms["AddUser"]["Password2"].value;
var name=document.forms["AddUser"]["Name"].value;
var ostaddars=document.forms["addlesson"]["ostaddars"].value;
  if(pass1==pass2 && pass1!="" && pass2!="" && user!=""){document.getElementById("addusermsg").innerHTML="";document.getElementById("Sub").disabled=false; }
   else{
	   document.getElementById("Sub").disabled=true;
	   if(pass1=="" || pass2=="" || user=="" || name==""){
	   document.getElementById("addusermsg").innerHTML="پر کردن تمام موارد الزامی است"; 
		}
		if(pass1!=pass2)
		{
			 document.getElementById("addusermsg").innerHTML="رمز عبور با تکرار آن یکسان نیست"; 
		}
	}

	//------------------------------------
	
	if (ostaddars==""){document.getElementById("Sub4").disabled = true;}
	else
	{
		document.getElementById("Sub4").disabled = false;
	}
   
}
function disableAdduser()
{
document.getElementById("Sub").disabled = true;
//document.getElementById("Sub2").disabled = true;
//document.getElementById("Sub3").disabled = true;
document.getElementById("Sub4").disabled = true;
}

</script>
</head>
<body onload="disableAdduser(); checkdata();">
<center>
<div class="main">

	<img src="./images/admin_header.png" width=700px>
	<div name="Info" style="text-align:right;">
	<?php echo $_COOKIE["Name"]." ، به بخش مدیریت خوش آمدید "."<a href='logout.php'><button>خروج</button></a>"."<br><br>"; ?>
	</div>
	<div name="Courses" style="text-align:right;">
	<br><h3>مشاهده گزارش چکیده و تفصیلی</h3>
	<hr><br>
	<form action="#" method="post" id="YearMonthForm" name="ReportForm">
	<label>ماه : </label>&nbsp;
	<input name="report" type="hidden" value="ack">
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
	&nbsp;
	کاربر :
	<select id='usr_nm' name="user_name">
	<?php
		$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT Username,Name FROM user WHERE Type=2";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()){
			echo "<option value=".$row["Username"].">".$row["Name"]." - ".$row["Username"]."</option>\n";
		}
	}
	$conn->close();
	?>
	</select>&nbsp;
	<input type="submit" value="مشاهده">
	</form>
	<br><br>
	<!--------------------------------------------------------------------------------------------------->
	
	<input type='hidden' id='usr' value='<?php if(isset($_POST["user_name"])){echo $_POST["user_name"];} ?>'>
	<?php
	if(isset($_POST["report"]))
	{
	echo "
	<center><table  dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
	<tr>
	<img src='./images/Report1.png' style='float:right;'>
	<td colspan=4 style='background-color: rgb(2, 125, 245);'>
		<font color=yellow>گزارش چکیده - ".month_name($month)." ".$year." [ ".$_POST["user_name"]." ] </font>"."
	</td>
	</tr>
	<tr>
	<th>استاد - درس</th><th>تعداد</th><th>پایه</th><th>مبلغ</th></tr>
	";
	//if(isset($_POST["Report"])||true)
	//{
		$majmoo=0;
		$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT ostaddars FROM `user_ostaddars` WHERE username='".$_POST["user_name"]."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			$perfix1=0;
			while($row = $result->fetch_assoc()){
				$perfix1++;
				echo "<tr><td>".$row["ostaddars"]."</td>";
				$sql = "SELECT * FROM areport WHERE Username='".$_POST["user_name"]."' AND Year='".$year."' AND Month='".$month."' AND OstadDars='".$row["ostaddars"]."'";
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
		
		echo "<tr><td colspan=3><p align='left'>مجموع=</p></td><td><input type=text id='majmookol' disabled=true value='".$majmoo."'></td></tr></table></center><br>
		";
		$conn->close();
		
	//}
	
	//-------------------------------------------------------------------------------
	include("shamsi.php");
		
		$conn1 = new mysqli($db_host, $db_user, $db_pass,$db_name);
		if ($conn1->connect_error) {
			die("Connection failed: " . $conn1->connect_error);
		}
		$sql1 = "SELECT * FROM `user_ostaddars` WHERE username='".$_POST["user_name"]."'";
		$result1 = $conn1->query($sql1);
		if ($result1->num_rows > 0) 
		{
			$perfix=0;
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
			$sql = "SELECT Day FROM `dreport` WHERE Username='".$_POST["user_name"]."' AND Year='".$year."' AND Month='".$month."' AND OstadDars='".$ostaddars."' AND Checked='1'";
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
			
			echo "";
			
			echo "<center><table  dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
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
						echo "<td style='background: rgb(255, 199, 199) none repeat scroll 0% 0%;' > <input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
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
									echo "<td><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
						else
						{
							if($day<=30)
							{
								
								if($checked[$j]=="CHKD"){
									echo "<td><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' checked='checked' onchange='mark(this);'>".$day."</td>";
								}
								else
								{
									echo "<td><input type='checkbox' name='".$perfix."ch".$day."' value='".$day."' onchange='mark(this);'>".$day."</td>";
								}
								$day++;
							}
						}
					}
					echo "</tr>";
				}
			}
			echo "</table></center><br>
			";	
			}
			}
		}
		
		

	
	//-------------------------------------------------------------------------------
	}
	?>
	
	
	<br>
	<br>
	<h3>پنل مدیریت</h3>
	<hr>
	
	<center><table dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
	<tr><td colspan=2 style='background-color: rgb(2, 125, 245);'>
	<h3><font color="yellow"> مدیریت دروس </font></h3>
	</td></tr>
	<tr>
	<th>ایجاد استاد درس جدید</th>
	<th>تخصیص استاد درس به کاربر</th>
	</tr>
	<tr>
	<td>
	<form name="addlesson" method="post" action="add-ostad-dars.php">
	<input name="ostaddars" type="text" placeholder="استاد-درس">&nbsp;
	<input type="submit" id="Sub4" value="افزودن استاد درس جدید">
	</form>
	<a href="ostaddarsview.php"><button>مشاهده و ویرایش استاد درس ها</button></a>
	</td>
	<td>
	<br>
	<form name="ostaduser" action="takhsisAck.php" method="post">
	<label>استاد-درس : </label>
	<select name="ostaddarsid">
	<?php
		$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT OstadDars FROM ostad_dars";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()){
			echo "<option value=".base64_encode($row["OstadDars"]).">".$row["OstadDars"]."</option>\n";
		}
	}
	$conn->close();
	?>
	</select><br><br>
	
	<label>کاربر :</label>
	<select name="username">
	<?php
		$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT Username,Name FROM user WHERE Type=2";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()){
			echo "<option value=".$row["Username"].">".$row["Name"]." - ".$row["Username"]."</option>\n";
		}
	}
	$conn->close();
	?>
	</select>
	<br><br>
	<input type="submit" value="تخصیص درس به کاربر">
	</form>
	
	</div>
	<a href="userODview.php"><button>مشاهده / حذف استاد درس های کاربر</button></a>
	</td>
	</tr>
	</table></center>
	
	<div name="AddUser" style="text-align:right;">
	<br><br>
	<a name="users">
	<center><table dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
	<tr><td colspan=3 style='background-color: rgb(2, 125, 245);'>
	<h3><font color="yellow"> مدیریت کاربران </font></h3>
	</td></tr>
	<tr>
	<th>افزودن کاربر جدید</th>
	</tr>
	<tr><td valign="top">
	<br>
	
	<form name="AddUser" method="POST" action="#users">
		<input name="Username" id="Username" type="text" placeholder="نام کاربری">&nbsp;&nbsp;
		<input name="Name" id="Name" type="text" placeholder="نام و نام خانوادگی">&nbsp;&nbsp;
		<input name="Password1" id="Password1" type="password" placeholder="رمز عبور">&nbsp;&nbsp;
		<input name="Password2" id="Password2" type="password" placeholder="تکرار رمز عبور">&nbsp;&nbsp;
		<br><br>
		<select name="Type">
			<option value="1" >مدیر</option>
			<option value="2" >مقرر</option>
			<option value="3" >ناظر</option>
		</select><br><br>
		<input name="submit" type="submit" id="Sub" value="افزودن"><br>
		<input type="hidden" name="AddUser" value="True"><br>
		<font color="red">(<label id="addusermsg"></label>)</font>
	</form>
	
	<br>
	<label id="AddusermsgLabel"><?php echo $AddUserMSG; ?></label>
	<br><br>
	</td></tr>
	</table></center>
	
	<br><br>
	
	<center><table dir='rtl' border=1 style='background: rgba(216, 252, 237, 0.64) none repeat scroll 0% 0%;border-style: solid; border-color: black; border-collapse: collapse; text-align: right; width:700px;'>
	<tr><td  style='background-color: rgb(2, 125, 245);'>
	<form name="UserList" method="post" action="#">
	<font color=yellow>نمایش لیست کاربران : </font> 
	<select name="type">
	<option value="all" >همه</option>
	<option value="admin" >مدیر</option>
	<option value="user" >مقرر</option>
	<option value="observer" >ناظر</option>
	</select>
	&nbsp; <input type="submit" value="اعمال فیلتر">
	</form>
	</td>
	</tr>
	<tr>
	<br>
	<?php
		$listUserCommand="SELECT * FROM user";
		if(isset($_POST["type"]))
		{
			$tp=$_POST["type"];
			switch($tp)
			{
				case "all":
				$listUserCommand="SELECT * FROM user";
				break;
				case "admin":
				$listUserCommand="SELECT * FROM user WHERE Type='1'";
				break;
				case "user":
				$listUserCommand="SELECT * FROM user WHERE Type='2'";
				break;
				case "observer":
				$listUserCommand="SELECT * FROM user WHERE Type='3'";
				break;
			}
		}
	$conn = new mysqli($db_host, $db_user, $db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if (isset($tp))
	echo "<p align=left>Results Filter : ".$tp."</p>";
	$result = $conn->query($listUserCommand);
	if ($result->num_rows > 0) 
	{
		
		echo "<center><table dir='ltr' border=1 style='text-align: left; width:700px;'><tr><th align='center'>حذف</th><th align='center'>ذخیره</th><th align='center'>نام و نام خانوادگی</th><th align='center'>نام کاربری</th><th align='center'>رمز عبور [Hash]</th><th align='center'>نوع کاربر</th></tr>";
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td align='center'><form action='deleteAck.php' method='post'><input type='hidden' name='Username' value='".$row["Username"]."'> <input type='image' src='./images/delete.png' width=40px height=40px border='0' alt='Submit' /></form></td>";
			echo "<form action='UpdateAck.php' method='post'><input type=hidden name='ID' value='".$row["ID"]."'><td align='center'> <input type='image' src='./images/save.png' width=40px height=40px border='0' alt='Submit' /></td>";
			echo "<td align='center'><input type=text name='Name' value='".$row["Name"]."'></td>";
			echo "<td align='center'><input type=text name='Username' value='".$row["Username"]."'></td>";
			echo "<td align='center'><input type=text name='Password' value='".$row["Password"]."'></td>";
			switch($row["Type"])
			{
				case 1:
				echo "<td align='center'>مدیر</td>";
				break;
				case 2:
				echo "<td align='center'>مقرر</td>";
				break;
				case 3:
				echo "<td align='center'>ناظر</td>";
				break;
			}
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