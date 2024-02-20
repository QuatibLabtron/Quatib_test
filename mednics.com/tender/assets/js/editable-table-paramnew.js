$(function(){
	$("#addnewclick").click(function() {
		document.getElementById("add_param").reset();
			document.getElementById("gen_id").value="";
		$("#addnewform").toggle("slow");
	});


	
});

function edit(gen_id)
 {

	$.ajax({
		type:"POST",
    	url:"parameter/editparam", 
		data :{ gen_id:gen_id},
		success: function(myvar){
			 window.mydata = myvar;
			var a=trim(myvar);
	//alert(a);
	var arr1 = new Array();
	//var arr2 = new Array();
	arr1=a.split("##");
	//arr2=arr1[1].split("##");
	
	/*if(arr1[0] == "edit")
	{*/
		document.getElementById("gen_name").value=arr1[1];

		 // document.getElementById("gen_value").value=arr1[2];
		 document.getElementById("gen_order").value=arr1[4];
		document.getElementById("gen_group").value=arr1[3];
		
		 // document.getElementById("gen_status").value=arr1[5];
	
		// document.getElementById("USR_password").value=arr1[6];
		// document.getElementById("USR_DPT_id").value=arr1[7];
		// document.getElementById("USR_REL_id").value=arr1[8];
		document.getElementById("gen_id").value=arr1[0];
		$("#addnewform").toggle("slow");
	/*}*/
                                          
			
		}
	});
}

function deleting(gen_id) {
	var d=confirm("Are you Sure deleting data with id { "+gen_id+" }");
			if(d==1)
			{
	$.ajax({
		type:"POST",
    	url:"parameter/delete", 
    	dataType:"json",
		data :{ gen_id:gen_id},
		success: function(response){
			 if(response.success==true){
           alert(response.message);
           location.reload();
          }else{
            alert(response.message);
          }                         
			
		}
	});
				}
	
}


function LTrim( value )
{
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
}

function RTrim( value )
{
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
}

function trim( value )
{
	return LTrim(RTrim(value));
}