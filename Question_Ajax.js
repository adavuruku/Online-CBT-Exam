
var xmlHttp;
var inc_Q_id;
var Answer_chooz="O";

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



function Next()
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
	 else
	 {
	 Answer_chooz = "O";
	 }
	// alert (Answer_chooz);
	
	 //this determine whether to increment or decrement the next
	 var q_id_no = document.getElementById("Q_id").innerHTML;
	 if (q_id_no == 4)
	  {
		//lowest number of question is 1
		inc_Q_id = 1;
	  }
	  else
	  {
		inc_Q_id = new Number(q_id_no) + 1;
	  }
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            var url="Question_Ajax_Script.php";
            url=url+"?Q_id="+inc_Q_id+"&answer_chooz="+Answer_chooz+"&current_id="+q_id_no;
            xmlHttp.onreadystatechange=QuestionChanged;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
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
	// alert (Answer_chooz);
  
  //this determine whether to increment or decrement the previous
  var q_id_no = document.getElementById("Q_id").innerHTML;
  
  if (q_id_no <= 1)
  {
	//highest number of question is 4
	inc_Q_id = 4;
  }
  else
  {
	inc_Q_id = new Number(q_id_no) - 1;
  }
  
//  alert(inc_Q_id);
   xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            /*&"?status="+kkk*/
            var url="Question_Ajax_Script.php";
            url=url+"?Q_id="+inc_Q_id+"&answer_chooz="+Answer_chooz+"&current_id="+q_id_no;
            xmlHttp.onreadystatechange=QuestionChanged;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
}


//###################################################################################
function Answer_found() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		var answe_found = xmlHttp.responseText;
		alert(answe_found);
	}
}
function Mark_choice()
{
	var new_id = document.getElementById("Q_id").innerHTML + "A";
	xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            var url="Question_Ajax_Script.php";
            url=url+"?new_id="+ new_id;
            xmlHttp.onreadystatechange=Answer_found;
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
		document.getElementById("Q_id").innerHTML=inc_Q_id;
		document.getElementById("Q_id2").innerHTML=inc_Q_id;
		Mark_choice();
	}
}

