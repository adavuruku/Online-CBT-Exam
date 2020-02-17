<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$Answer_score=$P=$R =0;
$user_full_name = "";
$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
$display_for_move ="";
if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_login']))
{
	header("location: exam_logout.php");
}

//this log user out if he refresh the page
if(!isset($_SESSION['All_Log_In']))
{
	header("location: exam_logout.php");
}
	$user_name = $_SESSION['user_name'];

	//get the last question from Db
	$stmt = $conn->prepare("SELECT id FROM online_cbt_question ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$_SESSION['last_question'] = $row['id'];
	//ends here
	
	//update user has login so he cant login in other computers again
	$stmt = $conn->prepare("UPDATE online_cbt_user SET Login_Status=? Where Reg_No=? Limit 1");
	$stmt->execute(array('1',$_SESSION['user_name']));
	$affected_rows = $stmt->rowCount();

	//retrieve the users details 
	$stmt = $conn->prepare("SELECT Pic_Ext, Full_Name, Reg_No FROM online_cbt_user where Reg_No=?");
	$stmt->execute(array($_SESSION['user_name']));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//mkdir('PRINT/UPLOADS/'.$userfolder,0777);
		$user_full_name = $row['Full_Name'];
		
		if ($row['Pic_Ext'] <> "")
		{
			$user_name =str_replace("/","",$_SESSION['user_name']);
			$user_name = $user_name.$row['Pic_Ext'];
			$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/'.$user_name.'" style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
		}
	}
	
	//retrieve all the number of questions
	$stmt = $conn->prepare("SELECT * FROM online_cbt_question");
	$stmt->execute();
	if ($stmt->rowCount () >= 1)
	{
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			$JAVA3 = "onClick="."Mark_the_Question(".$row['id'].") id=".$row['id']."P";
			if ($row['id'] == 1){
				$JAVA = "class="."active";
				$JAVA2="href="."#".$row['id'];
				
				$display_for_move = $display_for_move."<a ".$JAVA." ".$JAVA3." ".$JAVA2." >".$row['id']."</a>";
			}else{
				$JAVA2="href="."#".$row['id'];
				$display_for_move = $display_for_move."<a ".$JAVA2." ".$JAVA3." >".$row['id']."</a>";
			}
			//$JAVA = "onClick="."Mark_the_Question(".$row['id'].")";
		}
	}
	
//submit the exam here	
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$stmt = $conn->prepare("SELECT * FROM online_cbt_question");
	$stmt->execute();
	//$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$P = $stmt->rowCount ();
	
	for ($x=1; $x<=$P; $x++)
	{
		$R = $_POST[$x];
		//echo $R;
		
		//RETRIEVE THE QUESTION TO MARK
		$stmt = $conn->prepare("SELECT id, Cbt_Answer FROM online_cbt_question where id=?");
		$stmt->execute(array($x));
		if ($stmt->rowCount () == 1)
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($R == $row['Cbt_Answer'])
			{
				$Answer_score = $Answer_score + 1;
			}
		}
	} 
		
		//calc percent
		$percentage_score = (100 * $Answer_score)/$P;
		
		
		$_SESSION['movin_nxtpagee'] = $_SESSION['user_name'];
		$_SESSION['movin_result_nxtpagee'] = "yes";
		$_SESSION['score_result_no'] = $Answer_score;
		$_SESSION['percent_result_score'] = $percentage_score." %";
		
		unset($_SESSION['user_login']);
		unset($_SESSION['user_name']);
		
		//unset this session to it wont interfere with reprint page ...check Exam_user_reprint_Result.php page
		//and Exam_Result_View.php page so u can understand
		if(isset($_SESSION['reprint']))
		{
			unset($_SESSION['reprint']);
		}
		header("location: Exam_Result_View.php?id=".$_SESSION['movin_nxtpagee']);
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
<script type="text/javascript" src="Exam_Question2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").modal('show');		
	});
</script>
<script type="text/javascript">
function call_the_main_convert()
{
	var hrs_S = '<?php  echo $_SESSION['Exam_hours'];?>';
	var mins_S = '<?php echo $_SESSION['Exam_minutes'];?>';
	var secs_S = '<?php echo $_SESSION['Exam_seconds'];?>';
	var  cur = hrs_S + " " + mins_S +  " " + secs_S
	//alert (cur);
	convert_to_seconds_to_continue(hrs_S, mins_S, secs_S);

}
</script>
<style>
#myScrollspy  > ul > a
{
	height:20px;
	width:20px;
	Padding:5px;
	//background-color:yellow;
	color:yellow;
	float:left;
	margin-left:5px;
	margin-top:5px;
	margin-bottom:5px;
}
</style>

</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;" onload="call_the_main_convert()" >

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:yellow"  id="countdown" href="#">
					</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:grey">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-sm modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" style="color:RED;font-family:Tahoma, Times, serif;font-size:20px;font-weight:bold" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:yellow;font-family:Tahoma, Times, serif;font-size:20px;font-weight:bold">Important Notice</h4>
            </div>
            <div class="modal-body" style="background-color:cadetBlue" >
               <p style="color:YELLOW;font-family:Tahoma, Times, serif;font-size:15px;font-weight:bold" >Don't Refresh Or Reload This Page By Any Means As this may Log you Out of the Exam and as well terminate the Exam at that Point.</p>
				<p  style="color:YELLOW;font-family:comic sans ms;font-size:15px;font-weight:bold">Signed By : Management .</p>
                <p class="text-warning"><small style="color:white;font-family:comic sans ms;">Copyright © 2015</small></p>
            </div>
            <div class="modal-footer" style="background-color:grey">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row" style="top: 30px;">
				<form role="form" name="quizform"  id="frm1" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
			
			<div  class="col-sm-3 col-md-3 col-lg-3" style="padding-left:20px;background-color:CadetBlue;padding-top:20px;" >
				<!-- display user details like passport ..name.. ID ..Class type -->
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<!-- Passport -->
					<?php echo $profile_Pics;?>
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<p></P>
					<p></P>
					<p><?php echo $user_full_name;?></P>
					<p></P>
					<p><?php echo $_SESSION['user_name'];?></P>
					<p></P>
					<p>You have  - <span id="all_question"><?php echo $_SESSION['last_question'];?></span> Question's to Answer</P>
					<p></P>
				</div>
				
			</div>
				





				
			<div  class="col-sm-7 col-md-7 col-lg-7">
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-10">
											<button  type="button"  name="sule"  onclick="validate();" class="btn btn-success">Submit Exam</button>
								</div>
								<div  class="col-lg-2"></div>
				</div>
				
				
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
					<?php
						$stmt = $conn->prepare("SELECT * FROM online_cbt_question");
						$stmt->execute();
						//$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if ($stmt->rowCount () >= 1)
						{
							echo '<table>';
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
							{
								$question =htmlspecialchars_decode($row['Cbt_Question']);
								echo '<tr  id='.$row['id'].'>
											<td style="vertical-align:top;">'.$row['id'].'</td>
											<td width="15px"></td>
											<td>'.$question.'</td>
										</tr>
										<tr>
											<td colspan="2"></td>
											<td>A. <input type="radio" id="'.$row['id'].'A" name="'.$row['id'].'" value="A" >'."	".$row['Option_1'].'</input></br>
											B. <input type="radio" id="'.$row['id'].'B" name="'.$row['id'].'" value="B" >'."	".$row['Option_2'].'</input></br>
											C. <input type="radio" id="'.$row['id'].'C" name="'.$row['id'].'" value="C" >'."	".$row['Option_3'].'</input></br>
											D. <input type="radio" id="'.$row['id'].'D" name="'.$row['id'].'" value="D" >'."	".$row['Option_4'].'</input></br>
											<input style="visibility:hidden;" type="radio"  id="'.$row['id'].'O" checked="checked" name="'.$row['id'].'" value="O"></input></td>
										</tr>';
							}
							echo '</table>';
						}
							
						?>
				
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-10">
											<button  type="button"  name="sule"  onclick="validate();" class="btn btn-success">Submit Exam</button>
								</div>
								<div  class="col-lg-2"></div>
							
				</div>
				<?php //unset the session so user can not refresh page
				unset($_SESSION['All_Log_In']); ?>	
			</div>			
			<div  class="col-sm-2 col-md-2 col-lg-2">
			<div id="myScrollspy" class="col-lg-12" style="background-color:CadetBlue;padding-bottom:10px;">
						<ul style="background-color:CadetBlue;padding-bottom:10px;" class="nav nav-tabs nav-stacked affix-top" data-spy="affix" data-offset-top="125">
											<?php echo $display_for_move;?></ul>
					
				</div>
			
			</div>
						
						<div class="clearfix visible-sm-block"></div>
						<div class="clearfix visible-md-block"></div>
						<div class="clearfix visible-lg-block"></div>
					
		</form>
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
