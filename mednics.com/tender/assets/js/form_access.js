// JavaScript Document

var xmlHttp;
var uri = "";
var callingFunc = "";
var sResponse = "";

function GetXmlHttpObject()
{

	xmlHttp=null;
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
				//alert('jigishtry');
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				//alert('jigishtried');
		}
		catch (e)
		{
				//alert('jigishcatch');
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				//alert('jigishcatched');
		}
	}
//	alert(xmlHttp);
	return xmlHttp;
}


function remoteCall(sUrl, sQueryStr, sCalledBy)
{
	//alert(sUrl);
	//alert(sQueryStr);
	//alert(sCalledBy);
	//str = 'nick_name='+escape(document.createPF.nick_name.value)+'&sex='+escape(document.createPF.sex.value)+'&age='+escape(document.createPF.age.value);

/*	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = stateHandler;
		req.open("POST", sUrl, true);
		req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		req.send(sQueryStr);
		// branch for IE/Windows ActiveX version
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = stateHandler;
			req.open("POST", sUrl, true);
			req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			req.send(sQueryStr);
		}
	}
*/	//alert(sQueryStr);
	uri = sUrl;
	callingFunc = sCalledBy;
	
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	if (xmlHttp) 
	{
		xmlHttp.onreadystatechange = stateHandler;
		xmlHttp.open("POST", sUrl, true);
		xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlHttp.send(sQueryStr);
	}	
//	alert('jigish');
}

function stateHandler() 
{
	if (xmlHttp.readyState == 4)
	{
		/*if (xmlHttp.status == 200)
		{*/
			sResponse = xmlHttp.responseText;
			//alert(sResponse);
			eval(callingFunc+'()');
/*		}
		else 
		{
			//alert('Failed!');
		} */
	}
	return true;
}

function addslashes(str) 
{
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\0/g,'\\0');
	return str;
}

function stripslashes(str) 
{
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\0/g,'\0');
	str=str.replace(/\\\\/g,'\\');
	return str;
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


function emptyDropdown1(otherDropD)
{
		var sagar = otherDropD.length;
		for(var i = 0;i<sagar;i++)
		{
			otherDropD.remove(otherDropD.i);
		}
}

function IsEmpty(fieldvalue, fieldformname)
{	
	var err = '';
	if(fieldvalue.length == 0)
	{
		err += fieldformname +" should not be empty  \n";
		return err;
	}	
	return err;
}

function fireEvent(obj,evt){
	
	var fireOnThis = obj;
	if( document.createEvent ) {
	  var evObj = document.createEvent('MouseEvents');
	  evObj.initEvent( evt, true, false );
	  fireOnThis.dispatchEvent(evObj);
	} else if( document.createEventObject ) {
	  fireOnThis.fireEvent('on'+evt);
	}
}
/*
function getreadtitute(str)
{
	remoteCall("index.php?c=add_student&m=getbranch&readtituteId="+str,"","loadbranch");
}

function loadbranch()
{
//alert(sResponse);
	var arr1 = new Array();
	var arr2 = new Array();
	
	var oSel = document.getElementById("readtitute_id");
	emptyDropdown1(oSel);
	oSel[0]  = new Option("--Please Select--","");
	var j = 0;
	
	arr1 = sResponse.split("||");
	//alert(sResponse)
	for(i in arr1)
	{
		if(arr1[i] != "")
		{
			j++;
			arr2 = arr1[i].split("#");
			oSel[j]  = new Option(arr2[1], parseInt(trim(arr2[0])));
		}
	}
}
*/
function getcourseyears(str)
{
	remoteCall("index.php?c=coursesubject&m=getyears&courseId="+str,"","loadyears");
}

function loadyears()
{
//alert(sResponse);
	var arr1 = new Array();
	var arr2 = new Array();
	
	var oSel = document.getElementById("year_id");
	emptyDropdown1(oSel);
	oSel[0]  = new Option("--Please Select--","");
	var j = 0;
	
	arr1 = sResponse.split("||");
	//alert(sResponse)
	for(i in arr1)
	{
		if(arr1[i] != "")
		{
			j++;
			arr2 = arr1[i].split("#");
			oSel[j]  = new Option(arr2[1], parseInt(trim(arr2[0])));
		}
	}
}


function getdivisions(str)
{
	remoteCall("index.php?c=coursesubject&m=getdivisions&yearId="+str,"","loaddivisions");
}

function loaddivisions()
{
//alert(sResponse);
	var arr = new Array();
	
	arr = sResponse.split("@@@v@@@");

	var arr1 = new Array();
	var arr2 = new Array();
	var arr3 = new Array();
	var arr4 = new Array();
	
	var oSel = document.getElementById("division_id");
	emptyDropdown1(oSel);
	oSel[0]  = new Option("--Please Select--","");
	var j = 0;
	
	arr1 = arr[0].split("||");
	//alert(sResponse)
	for(i in arr1)
	{
		if(arr1[i] != "")
		{
			j++;
			arr2 = arr1[i].split("#");
			oSel[j]  = new Option(arr2[1], parseInt(trim(arr2[0])));
		}
	}
	
	var oSel1 = document.getElementById("subject_id");
	emptyDropdown1(oSel1);
	oSel1[0]  = new Option("--Please Select--","");
	var j = 0;
	
	arr3 = arr[1].split("||");
	//alert(sResponse)
	for(i in arr3)
	{
		if(arr3[i] != "")
		{
			j++;
			arr4 = arr3[i].split("#");
			oSel1[j]  = new Option(arr4[1], parseInt(trim(arr4[0])));
		}
	}
}


function getgroups(str)
{
	remoteCall("index.php?c=coursesubject&m=getgroups&yearId="+str,"","loadgroups");
}

function loadgroups()
{
//alert(sResponse);
	var arr1 = new Array();
	var arr2 = new Array();
	
	var oSel = document.getElementById("group_id");
	emptyDropdown1(oSel);
	oSel[0]  = new Option("--Please Select--","");
	var j = 0;
	
	arr1 = sResponse.split("||");
	//alert(sResponse)
	for(i in arr1)
	{
		if(arr1[i] != "")
		{
			j++;
			arr2 = arr1[i].split("#");
			oSel[j]  = new Option(arr2[1], parseInt(trim(arr2[0])));
		}
	}
}


function include(arr, obj) {
    for(var i=0; i<arr.length; i++) {
        if (trim(arr[i]) == obj) return true;
    }
}


var image = "<img src='assets/images/ajax-loader_red.gif'>";
function getReport()
{
	var USR_id=document.getElementById('USR_id').value;
	if(USR_id == ''){
		alert('Please select Employee');
		document.getElementById('main_result').style.display='none';
	}else{
		document.getElementById('main_result').style.display='Block';		remoteCall(baseUrl+"form_access/det/"+USR_id,'',"display_det");	}
	
	
}


function display_det()
{
	//alert(sResponse);
	document.getElementById('main_result').innerHTML='';
	document.getElementById('main_result').innerHTML=sResponse;
}

function update_access(mod,pag)
{
	//alert(mod+'hiii'+pag);
	document.getElementById("err"+mod).innerHTML="<center>" + image + "<b> Please Wait While Updating Access</b></center>";
	var str='';
	var modcnt=document.getElementById(mod+'pgcount').value;
	var USR_id=document.getElementById('USR_id').value;
	for(var i=0;i<modcnt;i++)
	{
		//alert(i);
		var ffma_accessid=document.getElementById(mod+'ffma_access'+i).value;
		if(ffma_accessid=="0")
		{
			//alert("no");
			str=str+ffma_accessid+'#';
		}
		else
		{
			//alert("yes");
			str=str+ffma_accessid+'#';
		}
		//var ffma_accessid=document.getElementById(mod+'fma_access'+i).value;
		if(document.getElementById(mod+'fma_access'+i).checked==true)
		{
			//alert("true");
			str=str+'1#';
		}
		else
		{
			str=str+'0#';
			//alert("false");
		}
		if(document.getElementById(mod+'read'+i).checked==true)
		{
			//alert("true");
			str=str+'1#';
		}
		else
		{
			str=str+'0#';
			//alert("false");
		}
		if(document.getElementById(mod+'upd'+i).checked==true)
		{
			//alert("true");
			str=str+'1#';
		}
		else
		{
			str=str+'0#';
			//alert("false");
		}
		if(document.getElementById(mod+'del'+i).checked==true)
		{
			//alert("true");
			str=str+'1#';
		}
		else
		{
			str=str+'0#';
			//alert("false");
		}
		if(document.getElementById(mod+'write'+i).checked==true)
		{
			//alert("true");
			str=str+'1#';
		}
		else
		{
			str=str+'0#';
			//alert("false");
		}
		var pgid=document.getElementById(mod+'sbm_id'+i).value;
		str=str+USR_id+'#';
		str=str+mod+'#';
		str=str+pgid+'#';
		str=str+'@';
	}
		remoteCall(baseUrl+"form_access/update","fma_access="+trim(str)+"&USR_id="+USR_id+"&mod="+mod,"display_change");}
function display_change()
{
	//alert(trim(sResponse));
	var s=new Array();
	s=trim(sResponse).split("@");
	//alert(s[1]);
	document.getElementById('main_result').innerHTML='';
	document.getElementById('main_result').innerHTML=trim(s[0]);
	document.getElementById('mod'+s[1]).style.display='block';
	document.getElementById('modstat'+s[1]).value='1';
	location.reload();
}

function open_down(modid)
{
	//alert("hi");
	var stat=document.getElementById('modstat'+modid).value;
	if(stat=="0")
	{
		document.getElementById('mod'+modid).style.display='block';
		document.getElementById('my'+modid).src='assets/images/minus.gif';
		document.getElementById('show'+modid).title='Click Here To Collapse';
		//document.getElementById('modimg'+modid).innerHTML='';
		//document.getElementById('modimg'+modid).innerHTML='<img src="../images/minus.gif" />';
		document.getElementById('modstat'+modid).value='1';
	}
	else
	{
		document.getElementById('mod'+modid).style.display='none';
		document.getElementById('my'+modid).src='assets/images/plus.gif';
		document.getElementById('show'+modid).title='Click Here To Expand';
		//document.getElementById('modimg'+modid).innerHTML='';
		//document.getElementById('modimg'+modid).innerHTML='<img src="../images/plus.gif" />';
		document.getElementById('modstat'+modid).value='0';
	}
}
function close_up(modid)
{
	document.getElementById('mod'+modid).style.display='none';
	document.getElementById('modimg'+modid).innerHTML='';
	document.getElementById('modimg'+modid).innerHTML='<img src="assets/images/plus.gif" onclick="open_down('+modid+');" />';
}
function check_access(mod,inc)
{
	if(document.getElementById(mod+'fma_access'+inc).checked==true)
	{
		//alert("yes");
		document.getElementById(mod+'all'+inc).disabled=false;
		document.getElementById(mod+'read'+inc).disabled=false;
		document.getElementById(mod+'upd'+inc).disabled=false;
		document.getElementById(mod+'del'+inc).disabled=false;
		document.getElementById(mod+'write'+inc).disabled=false;
	}
	else
	{
		//alert("no");
		document.getElementById(mod+'all'+inc).disabled=true;
		document.getElementById(mod+'read'+inc).disabled=true;
		document.getElementById(mod+'upd'+inc).disabled=true;
		document.getElementById(mod+'del'+inc).disabled=true;
		document.getElementById(mod+'write'+inc).disabled=true;
	}
}

function check_all(mod,inc)
{
	if(document.getElementById(mod+'all'+inc).checked==false)
	{
		//alert("yes");
		
		document.getElementById(mod+'read'+inc).checked=false;
		document.getElementById(mod+'upd'+inc).checked=false;
		document.getElementById(mod+'del'+inc).checked=false;
		document.getElementById(mod+'write'+inc).checked=false;
	}
	else
	{
		//alert("no");
		
		document.getElementById(mod+'read'+inc).checked=true;
		document.getElementById(mod+'upd'+inc).checked=true;
		document.getElementById(mod+'del'+inc).checked=true;
		document.getElementById(mod+'write'+inc).checked=true;
	}
}

function open_window()
	{
		//alert("hi in pop");
		FileName = window.open('../main/search_all_user.php', 'sdfsdf', 'toolbar=0,scrollbars=yes,location=0,statusbar=1,menubar=0,resizable=no,width=600,height=300,left = 1050,top = 254');
	}
	
function dept_change(uid)
{
	//alert(uid);
	//getdetails();
}

