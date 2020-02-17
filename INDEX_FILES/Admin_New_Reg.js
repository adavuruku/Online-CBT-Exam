
   function byId(e)
    {
        return document.getElementById(e);
    }

function samedetails1() 
{ 
			if (byId('samedetails').checked ==true)
			{
				//retrieve from personal details
				var value1 = byId('f_name').value;
				var value1B = byId('o_name').value;
				
				var value2 = byId('p_number').value;
				var value3 = byId('h_addrees').value;
				
				//load in to guardian boxes
				byId('g_name').value = value1 + " " + value1B;
				byId('gp_number').value = value2;
				byId('gh_addrees').value = value3;
			}else
			{
				byId('g_name').value = "";
				byId('gp_number').value = "";
				byId('gh_addrees').value = "";
			}
			
}
		
function addOption(combo, val, txt)
    {
        var option = document.createElement('option');
        option.value = val;
        option.title = txt;
        option.appendChild(document.createTextNode(txt));
        combo.appendChild(option);
    }
		
function load_year()
{
		//load year
		var combo2 = byId('cmbyear');
		for (var i=0; i <= 25; i++)
		{ 
			var year_reduce = new Number(2025) - new Number(i);
			 var year_add = new String(year_reduce)
			addOption(combo2, year_add, year_add);			
			//alert(year_add)
		}
		
		//load day
		var combo2 = byId('cmbday');
		for (var day=1; day <= 30; day++)
		{ 
			 var day_add = new String(day);
			 if (day_add.length ==1){
				day_add = "0" + day_add;
			 }
				addOption(combo2, day_add, day_add);			
		}
}
    
function show_new_id()
{
	var j = new Number(byId('reg_inc').innerHTML);
	var year = byId('cmbyear').value;
	var q = j + 1;
	var pp =new String(q).length;
	if (pp == 1){
		pp = "00" + q;
	}
	if (pp == 2){
		pp = "0" + q;
	}
	byId('reg_number').value = "PCNL/"+year+"/"+pp;
}
function noNumbers(e, t) 
{
            try {

                if (window.event) {
                    var charCode = window.event.keyCode;}

                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }

                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            catch (err) {
                alert(err.Description);
            }

         
        } 
