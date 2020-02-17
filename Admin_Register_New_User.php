
<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$err = "";
$_SESSION['passport']=$passport_part = $profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
$_SESSION['passport_ext'] =$_SESSION['temp_passport_name']=$_SESSION['imgData']=$id_reg_no=$all_selected="";
if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: exam_logout.php");
}
//header("location: Admin_Control_Pannel_Home.php");
if(isset($_SESSION['u_name']) AND isset($_SESSION['outcome']))
{
	unset($_SESSION['u_name']);
	unset($_SESSION['outcome']);
}

$stmt = $conn->prepare("SELECT Reg_No_Gen, id FROM online_exam_type where id=?");
	$stmt-> execute(array('1'));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id_reg_no = $row['Reg_No_Gen'];
	}
	
		
//process form submition
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Submit_odas']) )
	{
				try{
							if (!empty($_POST['courses']))
							{
								$check_3=0;
								foreach ($_POST['courses'] as $check){
									if($check_3 == 0){
										$all_selected = $all_selected.$check;
									}else{
										$all_selected = $all_selected.",".$check;
									}
									$check_3 = $check_3 + 1;
								}
								
								
								//select new reg_no
							$id_reg_no =0;
							$stmt = $conn->prepare("SELECT Reg_No_Gen, id FROM online_exam_type where id=?");
							$stmt-> execute(array('1'));
							if ($stmt->rowCount () == 1)
							{
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
								$id_reg_no = $row['Reg_No_Gen'];
							}
							
							//increase the regno field
							$stmt = $conn->prepare("UPDATE online_exam_type SET Reg_No_Gen = Reg_No_Gen + 1 WHERE id=?");
							$stmt->execute(array('1'));
							$affected_rows = $stmt->rowCount();	
							
							$id_reg_no = $id_reg_no + 1;
							$Reg_No = "PCNL/".$_POST['cmbyear']."/".$id_reg_no;
							if (strlen($id_reg_no)==1){
								$Reg_No = "PCNL/".$_POST['cmbyear']."/00".$id_reg_no;
							}
							if (strlen($id_reg_no)==2){
								$Reg_No = "PCNL/".$_POST['cmbyear']."/0".$id_reg_no;
							}
							
							$_SESSION['Reg_No_Print'] = $Reg_No;
							$Pic_Ext ="";
							$imgdata ="";
							
							$full_name = $_POST['f_name']." ".$_POST['o_name'];
							$gender = $_POST['gender'];
							$p_number = $_POST['p_number'];
							$p_addres = $_POST['h_addrees'];
							$G_Name = $_POST['g_name'];
							$G_Number = $_POST['gp_number'];
							$G_Addres = $_POST['gh_addrees'];
							$DOT = $_POST['cmbexamtype'];
							$class_schedule = $_POST['cmbschedule'];
							$DOR = $_POST['cmbday']." ".$_POST['cmbmonth'].", ".$_POST['cmbyear'];
							
							$year_reg = $_POST['cmbyear'];
							$user_password = "pesoka";
							$Login_Status = "0";
							$Exam_Status = "0";
							
							
							//Insert a new record since is not existing
							$sth = $conn->prepare ("INSERT INTO online_cbt_user (Full_Name,Gender, P_Phone, P_Addres,G_Name,G_Phone, G_Addres, Reg_No,Duration_Training,Class_Schedule,U_Date_Of_Reg,Year_Reg,User_Password, Login_Status, Exam_Status,Course_Register, A_Date_Of_Reg)
																		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())");
								$sth->bindValue (1, $full_name); $sth->bindValue (2, $gender); $sth->bindValue (3, $p_number); $sth->bindValue (4, $p_addres); $sth->bindValue (5, $G_Name); $sth->bindValue (6, $G_Number); $sth->bindValue (7, $G_Addres); $sth->bindValue (8, $Reg_No); $sth->bindValue (9, $DOT); $sth->bindValue (10, $class_schedule); $sth->bindValue (11, $DOR);$sth->bindValue (12, $year_reg); $sth->bindValue (13, $user_password); $sth->bindValue (14, $Login_Status); $sth->bindValue (15, $Exam_Status);$sth->bindValue (16, $all_selected);
								$sth->execute();
								$affected_rows = $sth->rowCount();
								if($affected_rows >= 1) 
								{
									//header("location: Server_Pictures_Print/User_Registration_Print_Slip.php");
									header("location: Admin_Register_New_User_Passport.php");
								}
								else
								{
									$err="Unable to Save Record please Retry !!";
								}
								
								
								
							}
							else
							{
								$err="Error! You must Select one or more courses to Register in Step 4 !!";
								//exit;
							}
							
						}
						catch (PDOException $pe)
						{
							die($pe->getMessage());
						}
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta content="noindex, nofollow" name="robots">
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
<link href="INDEX_FILES/style.css" rel="stylesheet" type="text/css">
<script src="INDEX_FILES/multi_step_form.js"></script>
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;" onload="load_year();" >

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

<div class="container" style="padding-top:20px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-2" style="padding-left:20px;" >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">Admin - Register New Student / User</h3>
					</div>
					<form role="form" name="Login_form"  id="frm0" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
					
					<div   class="col-sm-12 col-md-12 col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:CadetBlue;color:yellow;margin-bottom:1%">
						

						<form role="form"  name="reg_form"  id="form" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
					
							<!-- Progress Bar -->
							<ul id="progressbar">
								<li class="active">Personal Details</li>
								<li>Guardian Details</li>
								<li>Educational Profiles</li>
								<li>Course Register</li>
							</ul>
							<!-- Fieldsets -->
							<fieldset id="first">
								<h2 class="title" style="color:yellow" >Personal Details</h2>
								<p class="subtitle" style="color:white" >Step 1</p>
								
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">First Name :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="f_name" name="f_name" value="" placeholder="Enter First Name">
											</div>
										</div>
								</div>
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Other Names :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="o_name" name="o_name" value="" placeholder="Enter Middle Name Last Name">
											</div>
										</div>
								</div>
							
								<div class="form-group">
									<label for="txtlname" class="control-label col-xs-3">Gender :<span style="color:red"class"require">*</span></label>
									<div class="col-xs-9">
										<div class="col-xs-6">
											<label class="radio-inline" style="font-weight:bold;font-size:15px;">
												<input type="radio" class="rad" checked="checked" name="gender" value="Male"> Male
											</label>
										</div>
										
										<div class="col-xs-6">
											<label  class="radio-inline" style="font-weight:bold;font-size:15px;">
												<input type="radio"  class="rad" name="gender" value="Female"> Female
											</label>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Phone Number :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
												<input type="text"  class="text_field form-control"  onkeydown="return noNumbers(event,this)" id="p_number" name="p_number" value="" placeholder="Enter Phone Number">
											</div>
										</div>
								</div>
								
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Home_Addres :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<textarea   class="form-control"  id="h_addrees" name="h_addrees" value="" placeholder="Enter Permanent Home_Address"></textarea>
											</div>
										</div>
								</div>
								
								<div  class="col-lg-9" style="">
									<?php echo $err; ?>
								</div>
								<div  class="col-lg-3" style="">
								
											<input  type="button" style="width:100%;" class="next_btn btn btn-success"  value="Next" name="next"  ></input>
								</div>
								
								
							</fieldset >
							<fieldset class="second">
								<h2 class="title" style="color:yellow" >Guardian Details</h2>
								<p class="subtitle" style="color:white" >Step 2</p>
								
								<div class="form-group">
									<label for="txtlname" class="control-label col-xs-3"></label>
									<div class="col-xs-9">
										<div class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox" id="samedetails"  name="" value="" onclick="samedetails1();"> Click here if is Same as your Personal Details
											</label>
										</div>
										
										<div class="col-xs-2">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Guardian Name :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="g_name" name="g_name" value="" placeholder="Enter Guardian Full_Name">
											</div>
										</div>
								</div>

								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Phone Number :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input type="text"  class="text_field form-control"  onkeydown="return noNumbers(event,this)" id="gp_number" name="gp_number" value="" placeholder="Enter Phone Number">
											</div>
										</div>
								</div>
								
								
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-3">Home_Addres :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<textarea   class="form-control"  id="gh_addrees" name="gh_addrees" value="" placeholder="Enter Permanent Home_Address"></textarea>
											</div>
										</div>
								</div>
								
								<div  class="col-lg-5" style="align:left;">
								</div>
								<div  class="col-lg-7" style="align:right;">
											<input  type="button" style="width:30%;" class="pre_btn btn btn-success"  value="Previous" name="Previous"  ></input>
											<input  type="button" style="width:30%;" class="next_btn btn btn-success"  value="Next" name="next"  ></input>
								</div>
						
							</fieldset>
							<fieldset class="second">
							<p id="reg_inc" style="display:none" ><?php echo $id_reg_no;?></p>
								<h2 class="title">Educational Profiles</h2>
								<p class="subtitle">Step 3</p>
								
								
								
								<div class="form-group">
									<label for="cmbday" class="control-label col-xs-5">Date of Registration :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-2">
										
											<select class="form-control" style="box-shadow: 0 0 10px green inset;padding:0px" id="cmbday" name="cmbday">
													
											</select>
									
									</div>
									<div class="col-xs-3">
									
											
											<select class="form-control" style="box-shadow: 0 0 10px green inset;padding:0px" id="cmbmonth" name="cmbmonth">
													<option Value="January" >January</option>
													<option Value="February" >February</option>
													<option Value="March" >March</option>
													<option Value="April" >April</option>
													<option Value="May" >May</option>
													<option Value="June" >June</option>
													<option Value="Jully" >Jully</option>
													<option Value="August" >August</option>
													<option Value="September" >September</option>
													<option Value="October" >October</option>
													<option Value="November" >November</option>
													<option Value="December" >December</option>
											</select>
										
									</div>
									<div class="col-xs-2">
										<div class="input-group">
											
											<select class="form-control" id="cmbyear" onchange="show_new_id();" style="box-shadow: 0 0 10px green inset;padding:0px" name="cmbyear">
														
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="txthours" class="control-label col-xs-5">Registration Number :</label>
										<div class="col-xs-7">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input type="text" disabled="disabled" class="text_field form-control"  id="reg_number" name="reg_number" value="" placeholder="">
											</div>
										</div>
								</div>
								
								<div class="form-group">
									<label for="cmbexamtype1" class="control-label col-xs-5">Duration OF Training :<span style="color:red" class"require">*</span></label>
									<div class="col-xs-7">
										<div class="input-group">
											<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
											<select style="box-shadow: 0 0 10px green inset;" class="form-control" value="" id="cmbexamtype" name="cmbexamtype">
													
													<option value="Three (3) Months"> Three (3) Months </option>
													<option value="Six (6) Months"> Six (6) Months </option>
													
											</select>
										</div>
									</div>
								</div>
								
								
								<div class="form-group">
														<label for="cmbexamtype1" class="control-label col-xs-5">Class Schedule :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
																<select style="box-shadow: 0 0 10px green inset;" class="form-control" value="" id="cmbschedule" name="cmbschedule">
																		
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
									
								<div  class="col-lg-5">
								</div>
								<div  class="col-lg-7" style="align:right;">
											<input  type="button" style="width:30%;" class="pre_btn btn btn-success"  value="Previous" name="Previous"  ></input>
											<input  type="button" style="width:30%;" class="next_btn btn btn-success"  value="Next" name="next"  ></input>
								</div>
							</fieldset>
							<fieldset class="second">
								<h2 class="title">Course Register</h2>
								<p class="subtitle">Step 4</p>
								<hr>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course"  id="1" name="courses[]" value="Computer Fundamentals"> Computer Fundamentals
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="2" name="courses[]" value="Operating System"> Operating System
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="3" name="courses[]" value="Word Processing"> Word Processing
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="4" name="courses[]" value="Spreadsheet Packages"> Spreadsheet Packages
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="5" name="courses[]" value="Presentation Packages"> Presentation Packages
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="6" name="courses[]" value="Desktop Management"> Desktop Management
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:18px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox" class="course" id="7" name="courses[]" value="Internet"> Internet
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="8" name="courses[]" value="Database Management"> Database Management
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="9" name="courses[]" value="Mailing Program"> Mailing Program
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="10" name="courses[]" value="Computer Programming"> Computer Programming
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="11" name="courses[]" value="Computer Engineering"> Computer Engineering
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="12" name="courses[]" value="Computer Networking"> Computer Networking
											</label>
										</div>									
								</div>
								<div class="form-group">
										<div style="font-size:16px;font-family: 'Droid Serif', serif;font-weight:bold;color:white;" class="col-xs-10">
											<label class="checkbox-inline">
												<input type="checkbox"  class="course" id="13" name="courses[]" value="Web Site Designing"> Web Site Designing
											</label>
										</div>									
								</div>
								
								<hr>
								
								<div  class="col-lg-7" style="align:right;"><br>
											<input  type="button" style="width:30%;" class="pre_btn btn btn-success"  value="Previous" name="Previous"  ></input>
											<input  type="Submit" style="width:30%;" class="submit_btn btn btn-success"  value="Submit" name="Submit_odas"  ></input>
								</div>
								<div  class="col-lg-5" style="align:right;">
									<?php echo $err; ?>
								</div>
							</fieldset>
						</form>

						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>		
				
				<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
