<?php
/*******EDIT LINES 3-8*******/
session_start(); 
require_once 'site_root_config.php';
$root = my_site_root();
$DB_Server = "localhost"; //MySQL Server    
$DB_Username = "root"; //MySQL Username     
$DB_Password = "";             //MySQL Password     
$DB_DBName = "online_cbt_exam";         //MySQL Database Name  
$DB_TBLName = "online_cbt_user"; //MySQL Table Name   

/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection 
if (!isset($_SESSION['cmbexamschedule']))
{
	header("location: ".$root."exam_logout.php");
}
$filename = "Exam_Result_for_".$_SESSION['cmbexamschedule']."_Class_".$_SESSION['cmbyear'];//File Name
$F="0";  
$sql = "Select id, Full_Name,Reg_No,Score,Percentage,Date_Of_Exam,Year_Reg,Class_Schedule,Exam_Status from $DB_TBLName Where Exam_Status !='".$F."' AND Year_Reg = '".$_SESSION['cmbyear']."'AND Class_Schedule = '".$_SESSION['cmbexamschedule']."'";

$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
//select database   
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());   
//execute query 
$result = @mysql_query($sql,$Connect) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());    
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++) {
	if($i <=5)
	{
		echo mysql_field_name($result,$i) . "\t";
	}
}
print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysql_fetch_row($result))
    {
        $schema_insert = "";
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
			if($j <=5)
			{
			   if(!isset($row[$j]))
					$schema_insert .= "NULL".$sep;
				elseif ($row[$j] != "")
					$schema_insert .= "$row[$j]".$sep;
				else
					$schema_insert .= "".$sep;
			}
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    } 
unset($_SESSION['cmbexamschedule']);
unset($_SESSION['cmbyear']);	
?>	