
var xmlHttp;
var inc_Q_id_Answer;
var Answer_chooz="O";
var answer_found_to_mark;
function openloader(){
    document.getElementById("error").innerHTML ='<img src="Server_Pictures_Print/images/loader.gif" class="img-responsive" alt="Uploading...."/>';
	document.getElementById("error1").innerHTML ='<img src="Server_Pictures_Print/images/loader.gif" class="img-responsive" alt="Uploading...."/>';
}
function closeloader(){
    document.getElementById("error").innerHTML ='';
	 document.getElementById("error1").innerHTML ='';
}
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
	  // Internet Explorer
	  try
		{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e)
		{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	return xmlHttp;
}

function submit_exam_question()
{
	var r=confirm("Are You sure You want to Submit the Exam ..you stil have some time left");
	if (r==true)
	  {
		return true;
        exit;
	  }
	  else
	  {
		return false;
        exit;
	  }
}





function Previous()
{
	//this determine the option dats is choose
	if (document.getElementById("A").checked==true){
		Answer_chooz = "A";
	 }else if (document.getElementById("B").checked==true){
		Answer_chooz = "B";
	 }
	 else if (document.getElementById("C").checked==true){
		Answer_chooz = "C";
	 }else if(document.getElementById("D").checked==true){
		Answer_chooz = "D";
	 }
	 else{
	 Answer_chooz = "O";
	 }
	var q_id_no = document.getElementById("Q_id").innerHTML;
	xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            /*&"?status="+kkk*/
            var url="Question_Ajax_Script.php";
            url=url+"?Q_id="+inc_Q_id_Answer+"&answer_chooz="+Answer_chooz+"&current_id="+q_id_no;
            xmlHttp.onreadystatechange=QuestionChanged;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
}


//###################################################################################
function Answer_found() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		answer_found_to_mark = xmlHttp.responseText;
		//alert(answe_found);
		Previous();
	}
}
function Mark_choice(determine_n_p)
{
	var new_id = document.getElementById("Q_id").innerHTML;
	inc_Q_id_Answer = 0;
	  if (determine_n_p  =="previous")
	  {
		  if (new_id <= 1)
		  {
			//highest number of question is 4
			inc_Q_id_Answer = 4;
		  }
		  else
		  {
			inc_Q_id_Answer = new Number(new_id) - 1;
		  }
	}  
	  //next
	  if (determine_n_p  =="next")
	  {
		  if (new_id == 4)
		  {
			//lowest number of question is 1
			inc_Q_id_Answer = 1;
		  }
		  else
		  {
			inc_Q_id_Answer = new Number(new_id) + 1;
		  }
	  }
	  		
	xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            openloader();
			var url="Question_Ajax_Script.php";
            url=url+"?new_id="+ inc_Q_id_Answer;
            xmlHttp.onreadystatechange = Answer_found;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
}

//###################################################################################


/* when Question is change*/
function QuestionChanged() 
{ 
	
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("Question_Container").innerHTML="";
		document.getElementById("Question_Container").innerHTML=xmlHttp.responseText;
		document.getElementById("Q_id").innerHTML = inc_Q_id_Answer;
		document.getElementById("Q_id2").innerHTML = inc_Q_id_Answer;
		//alert(answer_found_to_mark);
		closeloader();
		if(answer_found_to_mark =="A")
		{
			document.getElementById("A").checked=true;
		}
		else if(answer_found_to_mark =="B")
		{
			document.getElementById("B").checked=true;
		}
		else if(answer_found_to_mark =="C")
		{
			document.getElementById("C").checked=true;
		}
		else if(answer_found_to_mark =="D")
		{
			document.getElementById("D").checked=true;
		}
		 else
		 {
			document.getElementById("O").checked=true;
		 }
	
		
	}
}

v