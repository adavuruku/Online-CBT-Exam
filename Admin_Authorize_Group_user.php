<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$error=$txtusername =$profile_Pics=$result_table=$user_exam=$user_login="";
 if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: exam_logout.php");
}

if(!isset($_SESSION['u_name']) AND !isset($_SESSION['outcome']))
{
	$_SESSION['u_name']="";
	$_SESSION['outcome']="";
}


//re - login
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_permit']))
{
		//update user has login so he cant login in other computers again
		
		$cmbyear =strip_tags($_POST['cmbyear']);
		$cmbexamschedule = strip_tags($_POST['cmbexamschedule']);
		//update user has login so he cant login in other computers again
		$stmt = $conn->prepare("UPDATE online_cbt_user SET Login_Status=? where Year_Reg=? AND Class_Schedule=? ");
		$stmt->execute(array('0',$cmbyear,$cmbexamschedule));
		$affected_rows = $stmt->rowCount();
		if($affected_rows >=1)
		{
			$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated User is free to Login</p>";
		}else{
			$error = "<p style='color:yellow'>Error! Unable to Updated Record Retry  - Or no Record Match</p>";
		}
}		
 
 
//re write exam
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['write_exam']))
{
		
		$cmbyear =strip_tags($_POST['cmbyear']);
		$cmbexamschedule = strip_tags($_POST['cmbexamschedule']);
		//update user has login so he cant login in other computers again
		$stmt = $conn->prepare("UPDATE online_cbt_user SET Exam_Status=? where Year_Reg=? AND Class_Schedule=? ");
		$stmt->execute(array('0',$cmbyear,$cmbexamschedule));
		$affected_rows = $stmt->rowCount();
		if($affected_rows >=1)
		{
			$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated User is free to REWrite Exam</p>";
		}else{
			$error = "<p style='color:yellow'>Error! Unable to Updated Record Retry - Or no Record Match</p>";
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
							<h3 style="text-align:center;padding-top:0px; padding-bottom:5px;color:yellow" >Admin Authorize CBT User</h3>
				</div>
			<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
			
							<h4 style="text-align:center;padding-top:0px; padding-bottom:5px;color:yellow" >Select Group Of User's Parameters</h4>
									<div class="form-group">
														<label for="cmbyear" class="control-label col-xs-5">Exam Year :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
																<select style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" class="form-control" value="" id="cmbyear" name="cmbyear">
																		
																		
																</select>
															</div>
														</div>
													</div>
				<div class="form-group">
														<label for="cmbexamschedule" class="control-label col-xs-5">Class Schedule (Group) :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
																<select style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" class="form-control" value="" id="cmbexamschedule" name="cmbexamschedule">
																		<option value="First Morning"> First Morning </option>
																		<option value="Second Morning"> Second Morning </option>
																		<option value="First Morning"> Third Morning </option>
																		<option value="First Morning"> First Afternoon </option>
																		<option value="Second Morning"> Second Afternoon </option>
																		<option value="First Morning"> Third Afternoon </option>
																		<option value="First Morning"> First Evening </option>
																		<option value="Second Morning"> Second Evening </option>
																		<option value="First Morning"> Third Evening </option>
																		<option value="First Morning"> Private Class </option>
																		
																</select>
															</div>
														</div>
													</div>
								
							</form>
				</div>
				
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-6" >
											<button  type="submit"  name="login_permit" class="btn btn-success">Allow All User in Group To Login</button>
								</div>
								<div  class="col-lg-6" >
											<button  type="submit"  name="write_exam" class="btn btn-success">Allow All User in Group to Re Write-Exam</button>
								</div>								
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								
									<?php echo $error; ?>
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
<script type="text/javascript">

function byId(e)
    {
        return document.getElementById(e);
    }
function addOption(combo, val, txt)
    {
        var option = document.createElement('option');
        option.value = val;
        option.title = txt;
        option.appendChild(document.createTextNode(txt));
        combo.appendChild(option);
    }
		var combo2 = byId('cmbyear');
		
		for (var i=0; i <= 25; i++)
		{ 
			var year_reduce = new Number(2025) - new Number(i);
			var year_add = new String(year_reduce)
			 
			var option = document.createElement('option');
			option.value = year_add;
			option.title = year_add;
			option.appendChild(document.createTextNode(year_add));
			combo2.appendChild(option);
			//alert("gg");
			
		}
</script>
</body>
</html>  
