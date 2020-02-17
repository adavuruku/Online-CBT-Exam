<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$error=$txthours =$txtminutes =$txtseconds =$cmbexamtype="";
	if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
	{
		header("location: exam_logout.php");
	}
			$stmt = $conn->prepare("SELECT * FROM Online_exam_type where id=? Limit 1");
			$stmt->execute(array('1'));
			$affected_rows2 = $stmt->rowCount();
			if($affected_rows2 == 1) 
			{
				$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
				
				$txthours =$row2['Exam_Hours'];
				$txtminutes =$row2['Exam_Minutes'];
				$txtseconds =$row2['Exam_Seconds'];
				$cmbexamtype=$row2['Choise_Of_Exam'];
			}
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	$txthours_2 = checkempty($_POST['txthours']);
	$txtminutes_2 = checkempty($_POST['txtminutes']);
	$txtseconds_2 =checkempty($_POST['txtseconds']);
	$cmbexamtype=$_POST['cmbexamtype'];
	
	$txthours =strip_tags($_POST['txthours']);
	$txtminutes = strip_tags($_POST['txtminutes']);
	$txtseconds =strip_tags($_POST['txtseconds']);
	$cmbexamtype = strip_tags($cmbexamtype);
	
	
	if(empty($_POST['txthours']))
	 {
		$txthours =0;
	 }
	if(empty($_POST['txtminutes']))
	 {
		$txtminutes =0;
	 }
	 if(empty($_POST['txtseconds']))
	 {
		$txtseconds =0;
	 }
		
		
		
		//update user has login so he cant login in other computers again
		$stmt = $conn->prepare("UPDATE Online_exam_type SET Exam_Hours=?,Exam_minutes=?,Exam_seconds=?,Choise_Of_Exam=? Where id=? Limit 1");
		$stmt->execute(array($txthours,$txtminutes,$txtseconds,$cmbexamtype,'1'));
		$affected_rows = $stmt->rowCount();
		if($affected_rows == 1){
		$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated</p>";
		}else{
			$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated</p>";
		}
	$txthours = $_POST['txthours'];
	$txtminutes = $_POST['txtminutes'];
	$txtseconds =$_POST['txtseconds'];
	$cmbexamtype=$_POST['cmbexamtype'];
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
<script src="INDEX_FILES/Admin_New_Reg.js"></script>

</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="Admin_Control_Pannel_Home.php">Go to Home Page</a></li>
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
						<h3 style="text-align:center;padding-top:5px; padding-bottom:25px;color:yellow" >Admin Set - Exam Parameters</h3>	
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
								<div class="form-group">
														<label for="cmbexamtype1" class="control-label col-xs-5">Exam Type :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
																<select style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" class="form-control" value="<?php echo $cmbexamtype; ?>" id="cmbexamtype" name="cmbexamtype">
																		
																		<option value="All Question Display"> All Question Display </option>
																		<option value="One Question At A Time">One Question At A Time </option>
																		
																</select>
															</div>
														</div>
													</div>
				<div class="form-group">
														<label for="txthours" class="control-label col-xs-5">Hours :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txthours" onkeydown="return noNumbers(event,this)" name="txthours" value="<?php echo $txthours; ?>" placeholder="Enter The Exam Hours">
															</div>
														</div>
								</div>
								
								<div class="form-group">
														<label for="txtminutes" class="control-label col-xs-5">Minutes :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txtminutes" onkeydown="return noNumbers(event,this)" name="txtminutes" value="<?php echo $txtminutes; ?>" placeholder="Enter The Exam Minutes">
															</div>
														</div>
								</div>
								
								<div class="form-group">
														<label for="txtseconds" class="control-label col-xs-5">Seconds :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txtseconds" onkeydown="return noNumbers(event,this)" name="txtseconds" value="<?php echo $txtseconds; ?>" placeholder="Enter The Exam Seconds">
															</div>
														</div>
								</div>
				
				
				
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-5" style="align:left;">
									<?php echo $error; ?>
								</div>
								<div  class="col-lg-7" >
											<button  type="submit"  name="submit" class="btn btn-success">Save And Update Record</button>
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
