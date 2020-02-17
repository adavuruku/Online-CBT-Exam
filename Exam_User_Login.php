<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$error=$P=$R =$txtPassword=$txtUsername="";
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	
	$txtPassword =strip_tags($_POST['txtPassword']);
	$txtUsername = strip_tags($_POST['txtUsername']);
	
	$stmt = $conn->prepare("SELECT * FROM online_cbt_user where User_Password=? AND Reg_No=? Limit 1");
	$stmt->execute(array($txtPassword,$txtUsername));
	$affected_rows = $stmt->rowCount();
	if($affected_rows == 1) 
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['Login_Status'] <> "0")
		{
			$error = "<p style='color:white'>Sorry! You have Login in Another Computer</p>";
		}
		else if($row['Exam_Status'] <>"0"){
			//rediret user to his result printing since the user has write exam before
			$error = "<p style='color:white'>Sorry! You are not allowed to re write this Exam </p>";
		}
		else
		{
			$_SESSION['user_name'] = $_POST['txtUsername'];
			$_SESSION['user_login'] = "yes";
			
			$stmt = $conn->prepare("SELECT * FROM Online_exam_type where id=? Limit 1");
			$stmt->execute(array('1'));
			$affected_rows2 = $stmt->rowCount();
			if($affected_rows2 == 1) 
			{
				$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
				
				$_SESSION['Exam_hours']=$row2['Exam_Hours'];
				$_SESSION['Exam_minutes']=$row2['Exam_Minutes'];
				$_SESSION['Exam_seconds']=$row2['Exam_Seconds'];
				//this will unset in the Question so if you Refresh the Page it Log Out 
				$_SESSION['All_Log_In']="All_Log_In";
				
				if($row2['Choise_Of_Exam'] == "All Question Display")
				{
					header("location: Exam_Question_Two.php");
				}
				if($row2['Choise_Of_Exam'] == "One Question At A Time")
				{
					header("location: Exam_Question_First.php");
				}
				
				
			}
		}
		
		
		
	}else
	{
		$error = "<p style='color:white'>Unable To Login, Password or User_Name Incorrect</p>";
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Pesoka Computers Nigeria Limited - Ajaokuta Nigeria</title>
<link rel="shortcut icon" href="Server_Pictures_Print/images/image_demo.jpg">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap-theme.css" >
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.min.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.min.js"></script>
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="index.php">Go to Home Page</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>



<div class="container">
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
				<form role="form" name="Login_form"  id="frm0" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
			
			<div  class="col-sm-3 col-md-3 col-lg-3" style="padding-left:20px;" >
			</div>
					
			<div  class="col-sm-7 col-md-7 col-lg-7">
			<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
							<h3 style="text-align:center;padding-top:5px; padding-bottom:25px;color:yellow" >CBT User's Exam Login Platform</h3>	
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
								<div class="form-group">
														<label for="txtUsername" class="control-label col-xs-5">User Name / Reg_No :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txtUsername" name="txtUsername" value="<?php echo $txtUsername; ?>" placeholder="Enter Your User_Name / Reg_No">
															</div>
														</div>
								</div>
				<div class="form-group">
														<label for="txtPassword" class="control-label col-xs-5">Password :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
																<input type="password" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txtPassword" name="txtPassword" value="" placeholder="Enter Your Password">
															</div>
														</div>
								</div>
				
				
				
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-5" style="align:left;">
									<?php echo $error; ?>
								</div>
								<div  class="col-lg-7" >
											<button  type="submit"  name="submit" class="btn btn-success">Login &gt&gt&gt</button>
											<button  type="reset" name="previous"  class="btn btn-success">Clear / Reset</button>
								</div>
							</form>
				</div>
					
			</div>			
			<div  class="col-sm-2 col-md-2 col-lg-2"></div>
						
						<div class="clearfix visible-sm-block"></div>
						<div class="clearfix visible-md-block"></div>
						<div class="clearfix visible-lg-block"></div>
					
		
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		
		<div class="row">
			<div class="col-xs-3 col-sm-3"></div>	
				<div class="col-xs-7 col-sm-7" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
