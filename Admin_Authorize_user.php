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
if(isset($_GET['login_permit']))
{
		//update user has login so he cant login in other computers again
		$stmt = $conn->prepare("UPDATE online_cbt_user SET Login_Status=? where Reg_No=? Limit 1");
		$stmt->execute(array('0',$_SESSION['u_name']));
		$affected_rows = $stmt->rowCount();
		if($affected_rows ==1)
		{
			$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated User is free to Login</p>";
		}else{
			$error = "<p style='color:blue'>Error! Unable to Updated Record Retry</p>";
		}
}		
 
 
//re write exam
if(isset($_GET['write_exam']))
{
		//update user has login so he cant login in other computers again
		$stmt = $conn->prepare("UPDATE online_cbt_user SET Exam_Status=? where Reg_No=? Limit 1");
		$stmt->execute(array('0',$_SESSION['u_name']));
		$affected_rows = $stmt->rowCount();
		if($affected_rows ==1)
		{
			$error = "<p style='color:white'>Succesfull! ..Record was successfully Updated User is free to REWrite Exam</p>";
		}else{
			$error = "<p style='color:blue'>Error! Unable to Updated Record Retry</p>";
		}
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	$txtusername = checkempty($_POST['txtusername']);
	
	if(($txtusername != FALSE))
	 {
	
		$txtusername =strip_tags($_POST['txtusername']);
		
		$stmt = $conn->prepare("SELECT * FROM online_cbt_user where Reg_No=? Limit 1");
		$stmt->execute(array($txtusername));
		$affected_rows2 = $stmt->rowCount();
		if($affected_rows2 == 1) 
		{
			$error ="";
			$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
			
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['u_name'] = $txtusername;
			if($row['Pic_Ext'] <> ""){
			
				$user_name =str_replace("/","",$txtusername);
				$user_name = $user_name.$row['Pic_Ext'];
				$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/'.$user_name.'" style="height:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
			}
			$user_login= '<a style="color:yellow;border:2px solid;background-color:red;padding:5px;" href="Admin_Authorize_user.php?login_permit=loginpermit">Allow User To Login</a>';
			
			$user_exam= '<a style="color:yellow;border:2px solid;background-color:red;padding:5px;" href="Admin_Authorize_user.php?write_exam=rewrite">Allow User to Re Write-Exam</a>';
			
			$_SESSION['outcome'] = '<tr>
								<td rowspan="4" >'.$profile_Pics.'</td>
								<td width="15px"></td>
								<td>Student Name :</td>
								<td width="15px"></td>
								<td>'.$row['Full_Name'].'</td>
							</tr>
							<tr>
								<td width="15px"></td>
								<td>Registration No :</td>
								<td width="15px"></td>
								<td>'.$row['Reg_No'].'</td>
							</tr>
							</tr>
								<td width="15px"></td>
								<td>Password No :</td>
								<td width="15px"></td>
								<td>'.$row['User_Password'].'</td>
							</tr>
							<tr>
								<td width="15px"></td>
								<td>'.$user_login.'</td> 
								<td width="15px"></td>
								<td>'.$user_exam.'</td>
							</tr>';	
		}else{
			$error = "<p style='color:blue'>Error! The User_Name / Reg_No Not Valid</p>";
			$_SESSION['outcome']="";
		}
		
		
	}
	else
	{
		$error = "<p style='color:blue'>Error! Enter User_Name / Reg_No</p>";
		$_SESSION['outcome']="";
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
			<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
			
								<div  class="col-lg-9" style="align:left;">
									<div class="form-group">
														<label for="txtusername" class="control-label col-xs-5">User_Name/Reg_No :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control" style="box-shadow: 0 0 10px green inset;font-weight:bold;
font-family: tahoma" id="txtusername" name="txtusername" value="<?php echo $_SESSION['u_name']; ?>" placeholder="Enter Student User_Name / Reg_No">
															</div>
														</div>
									</div>
								</div>
								
								
								
								<div  class="col-lg-3" >
											<button  type="submit"  name="submit" class="btn btn-success">Search Record</button>
								</div>
							</form>
				</div>
				
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
							<table border="0%" style="padding:15%;">
							<?php echo $_SESSION['outcome'];?>
							
							</table>	
	
				
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
</body>
</html>  
