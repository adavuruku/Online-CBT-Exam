<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$global="";
$passport_part = $profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg" style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
$c = $dd = $school = $dept = $level = $matno=$email = $gender = $datereg = $studname =$newpassword = $oldpassword = $retype= $err = $paserr="";

	$passport_part = $_SESSION['passport'];
	//$reg=$_SESSION['REGNO'];
	
	function update_database_record($moveto4,$imgData)
	{
			global $conn;
			$stmt = $conn->prepare("UPDATE online_cbt_user SET  Pic_Ext=?,image_data=? WHERE Reg_No=? Limit 1");
			$stmt->execute(array($moveto4,$imgData,$_SESSION['Reg_No_Print']));
			$affected_rows = $stmt->rowCount();
	}
	
	
	function water_mark_image($moveto2,$moveto3,$imgData)
	{
		$watermark = imagecreatefrompng('Server_Pictures_Print/images/fpiputme.png');
		$watermark_widht = imagesx($watermark);
		$watermark_height =imagesy($watermark);
		$image =imagecreatetruecolor ($watermark_widht, $watermark_height);
		$image = imagecreatefromjpeg($moveto2);
		$image_size = getimagesize($moveto2);
		$x = $image_size[0] - $watermark_widht - 20;
		$y = $image_size[1] - $watermark_height - 20;
		imagecopymerge($image, $watermark, $x, $y, 0, 0, $watermark_widht, $watermark_height, 50);
		
		//this saves it to its destination folder
		imagejpeg ($image,$moveto2);
		
		update_database_record($moveto3,$imgData);
	}
	
	//process your image
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['uploaded']['name']))
	{
				$userfolder ="Server_Pictures_Print/Server_Pics/";
				
                $FILE = addslashes($_FILES['uploaded']['name']);
                $path_parts = pathinfo($FILE);
                $ext= $path_parts['extension'];
                $image_size = getimagesize($_FILES['uploaded']['tmp_name']);
				
               //check if the user select something else apart from image
                   if ($image_size == false)
                    {
                        $paserr= "Error: Please the selected file is not a Valid image";
						$passport_part = $_SESSION['passport'];
						echo $paserr;
						echo $passport_part;
                    }
                    else
                    {           
                        //get the height and width of image
						$image_size = getimagesize($_FILES['uploaded']['tmp_name']);
						$x = $image_size[0];
						$y = $image_size[1];
                        $size = ($_FILES['uploaded']['size'])/1240;
                       // $size2 = $size /1240;
						if (($x > 350) || ($y > 450))
						{
							$paserr= "Error: Please check the File height and breadth";
								$passport_part = $_SESSION['passport'];
								echo $paserr;
								echo $passport_part;
						}
						else
						{
						
							/*$d=mt_rand(100000,200000);
							$z =str_split($d);
							$k="";
							$add = array("K","d","M","sa","iO","P","Q","wi","S","T","gO","aZ");
							foreach ($z as $value)
							{
								$f=$add[$value];
								$k=$k.$f;
							}*/
							
							$_SESSION['temp_passport_name'] = str_replace("/","",$_SESSION['Reg_No_Print']);
							 
							 //this hold the files and its path
							 $tmpName  = $_FILES['uploaded']['tmp_name'];
							 //get the file in binary format
								
							$imgData =addslashes (file_get_contents($_FILES['uploaded']['tmp_name']));
							 
							 if ($ext =="jpg" && $size <=200 )
							 {  
								$extension =".jpg";                            
								//this copy the file to a new folder which can be specify by you
								$newpath= $_SESSION['temp_passport_name'].$extension;
								$moveto= $userfolder.$newpath;
								move_uploaded_file($tmpName,$moveto);
								$passport_part = '<img src='.$moveto.' style="height:180px;width:200px;border:4px solid white;padding:3px" class="img-responsive"  ></img>';
								
								if (file_exists($userfolder.$_SESSION['temp_passport_name'].".jpeg"))
								 {
									unlink($userfolder.$_SESSION['temp_passport_name'].".jpeg");
								 }
								water_mark_image($moveto,$extension,$imgData);
								$passport_part = '<img src='.$moveto.' style="height:180px;width:200px;border:4px solid white;padding:3px"  class="img-responsive"  ></img>';
								echo $passport_part;
							 }
							elseif ($ext =="jpeg" && $size <= 200)
							 {
								 $extension =".jpeg";                                                        
								//this copy the file to a new folder which can be specify by you
								$newpath= $_SESSION['temp_passport_name'].$extension;
								$moveto= $userfolder.$newpath;
								move_uploaded_file($tmpName,$moveto);
								$passport_part = '<img src='.$moveto.' style="height:180px;width:200px;border:4px solid white;padding:3px" class="img-responsive"  ></img>';
								
								if (file_exists($userfolder.$_SESSION['temp_passport_name'].".jpg"))
								 {
									unlink($userfolder.$_SESSION['temp_passport_name'].".jpg");
								 }
								water_mark_image($moveto,$extension,$imgData);
								
								$passport_part = '<img src='.$moveto.' style="height:180px;width:200px;border:4px solid white;padding:3px"   class="img-responsive"  ></img>';
								$_SESSION['passport']= $passport_part;
								echo $passport_part;
							 }
							 else
							 {
								$paserr= "Error: Please check the File size and file extension";
								$passport_part = $_SESSION['passport'];
								echo $paserr;
								echo $passport_part;
							 }
						}
					}
			$_SESSION['passport'] = $passport_part;					
	}
	
	$_SESSION['passport'] = $passport_part;
	
?>