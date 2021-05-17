
var curr_obj=null;
var temp_table=null;
var list_obj=null;

function logoutUser(){
    var url = "/nigeriapremierleague/userbackend.php?option=logoutUser";
	AjaxFunctionSetup(url);
}

function checkAccess(access, menuoption){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption;
    var url = "/nigeriapremierleague/databackend.php?option=checkAccess"+arg;
    AjaxFunctionSetup(url);
}

function doLeagueTableReport(arg){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var matchdateA = document.getElementById("matchdateA").value;
    var matchdateB = document.getElementById("matchdateB").value;
    var weekA = document.getElementById("weekA").value;
    var weekB = document.getElementById("weekB").value;
    var clubnameA = document.getElementById("clubnameRA").value;
    var clubnameB = document.getElementById("clubnameRB").value;
	var selectoption = document.getElementById("reportype");
	var reportype = selectoption.options[selectoption.selectedIndex].text;

	var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";
    if (matchdateA>matchdateB) error += "Start Match Date must be less than End Match Date<br><br>";
    if ((matchdateA>"" && matchdateB=="") || (matchdateA=="" && matchdateB>"")) error += "Both Start Match Date and End Match Date must be blank or populated<br><br>";
    if (weekA>weekB) error += "Start Match Week must be less than End Match Week<br><br>";
    if ((weekA>"" && weekB=="") || (weekA=="" && weekB>"")) error += "Both Start Match Week and End Match Week must be blank or populated<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var oWin=null;
	var param = "?leaguename="+leaguename+"&season="+season+"&matchdateA="+matchdateA+"&matchdateB="+matchdateB+"&weekA="+weekA+"&weekB="+weekB+"&clubnameA="+clubnameA+"&clubnameB="+clubnameB+"&reportype="+reportype;
	if(arg=="pdf"){
		oWin = window.open("pdfleaguetable.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if(arg=="graph"){
		oWin = window.open("leaguetablegraphreport.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doFixturesListsReport(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var matchdateA = document.getElementById("matchdateA").value;
    var matchdateB = document.getElementById("matchdateB").value;
    var weekA = document.getElementById("weekA").value;
    var weekB = document.getElementById("weekB").value;
    var clubname = document.getElementById("clubname").value;
	var selectoption = document.getElementById("reportype");
	var reportype = selectoption.options[selectoption.selectedIndex].text;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";
    if (matchdateA>matchdateB) error += "Start Match Date must be less than End Match Date<br><br>";
    if ((matchdateA>"" && matchdateB=="") || (matchdateA=="" && matchdateB>"")) error += "Both Start Match Date and End Match Date must be blank or populated<br><br>";
    if (weekA>weekB) error += "Start Match Week must be less than End Match Week<br><br>";
    if ((weekA>"" && weekB=="") || (weekA=="" && weekB>"")) error += "Both Start Match Week and End Match Week must be blank or populated<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var param = "?leaguename="+leaguename+"&season="+season+"&matchdateA="+matchdateA+"&matchdateB="+matchdateB+"&weekA="+weekA+"&weekB="+weekB+"&clubname="+clubname+"&reportype="+reportype;
	var oWin = window.open("pdffixtureslists.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function deleteFixtures(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Deleting your fixtures.";
    $('#showAlert').dialog('open');
	var param = "&leaguename="+leaguename+"&season="+season;
    var url = "/nigeriapremierleague/databackend.php?option=deleteFixtures"+param;
    AjaxFunctionSetup(url);
}

function doMatchesListsReport(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var matchdateA = document.getElementById("matchdateA").value;
    var matchdateB = document.getElementById("matchdateB").value;
    var weekA = document.getElementById("weekA").value;
    var weekB = document.getElementById("weekB").value;
    var clubname = document.getElementById("clubnamerec").value;
	var selectoption = document.getElementById("reportype");
	var reportype = selectoption.options[selectoption.selectedIndex].text;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";
    if (matchdateA>matchdateB) error += "Start Match Date must be less than End Match Date<br><br>";
    if ((matchdateA>"" && matchdateB=="") || (matchdateA=="" && matchdateB>"")) error += "Both Start Match Date and End Match Date must be blank or populated<br><br>";
    if (weekA>weekB) error += "Start Match Week must be less than End Match Week<br><br>";
    if ((weekA>"" && weekB=="") || (weekA=="" && weekB>"")) error += "Both Start Match Week and End Match Week must be blank or populated<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var param = "?leaguename="+leaguename+"&season="+season+"&matchdateA="+matchdateA+"&matchdateB="+matchdateB+"&weekA="+weekA+"&weekB="+weekB+"&clubname="+clubname+"&reportype="+reportype;
	//alert(param);
	var oWin = window.open("pdfmatchesresults.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function deleteMatches(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Deleting your matches.";
    $('#showAlert').dialog('open');
	var param = "&leaguename="+leaguename+"&season="+season;
    var url = "/nigeriapremierleague/databackend.php?option=deleteMatches"+param;
    AjaxFunctionSetup(url);
}

function doGoalsListsReport(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var weekA = document.getElementById("weekA").value;
    var weekB = document.getElementById("weekB").value;
    var clubname = document.getElementById("clubnamerec").value;
	var selectoption = document.getElementById("reportoption");
	var reportoption = selectoption.options[selectoption.selectedIndex].text;
	selectoption = document.getElementById("reportype");
	var reportype = "";
	if(selectoption!= null) reportype = selectoption.options[selectoption.selectedIndex].text;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";
    if (weekA>weekB) error += "Start Match Week must be less than End Match Week<br><br>";
    if ((weekA>"" && weekB=="") || (weekA=="" && weekB>"")) error += "Both Start Match Week and End Match Week must be blank or populated<br><br>";
    if (reportoption==null || reportoption=="Select an Option.....") error += "A report option must be selected<br><br>";
    //if (reportype==null || reportype=="") error += "A report type must be selected<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var param = "?leaguename="+leaguename+"&season="+season+"&weekA="+weekA+"&weekB="+weekB+"&clubname="+clubname+"&reportype="+reportype;
	var oWin = null;
	if(reportoption=="Goals"){
		oWin = window.open("pdfgoalsresults.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}else if(reportoption=="Cautions"){
		oWin = window.open("pdfcautionsresults.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}else if(reportoption=="Expulsions"){
		oWin = window.open("pdfexpulsionsresults.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doClubsListsReport(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
	var seasoname = document.getElementById("season").value;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var param = "?leaguename="+leaguename+"&season="+season+"&seasoname="+seasoname;
	//alert(param);
	var oWin = window.open("pdfclubslists.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doPlayersListsReport(){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var clubname = document.getElementById("clubnamerec").value;
	var seasoname = document.getElementById("season").value;
	var club_name = document.getElementById("clubname").value;
    var regnumber = document.getElementById("regnumber").value;
	var selectoption = document.getElementById("reportype");
	var reportype = selectoption.options[selectoption.selectedIndex].text;

    var error = "";
    if (leaguename=="") error += "League Name must not be blank<br><br>";
    if (season=="") error += "Seasons must not be blank<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var param = "?leaguename="+leaguename+"&season="+season+"&clubname="+clubname+"&regnumber="+regnumber+"&seasoname="+seasoname+"&club_name="+club_name;
	var oWin = null;
	if(reportype=="Summary"){
		oWin = window.open("pdfplayerslists.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}else{
		oWin = window.open("pdfplayersdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function updateSeason(option, table){
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("season").value;
    var winning = document.getElementById("winning").value;
    var goalsdraw = document.getElementById("goalsdraw").value;
    var goallessdraw = document.getElementById("goallessdraw").value;
    var error = "";
    if (season==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Season must not be blank.<br><br>";
        }
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+leaguename+"]["+season+"]["+winning+"]["+goalsdraw+"]["+goallessdraw;
    var url = "/nigeriapremierleague/databackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateLeagueType(option, table){
    var leaguename = document.getElementById("leaguename").value;
    var error = "";
    if (leaguename==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "League Name must not be blank.<br><br>";
        }
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+leaguename;
    var url = "/nigeriapremierleague/databackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function showClubs(){
	$('#clubstable').dialog('open');
}

function CopyFromPreviousSeason(){
    var season = document.getElementById("season").value;
    var leaguename = document.getElementById("leaguename").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	$('#copyclubstable').dialog('open');
}

function populateCopyClub(arg){
    var season = document.getElementById("seasonBrec").value;
    var leaguename = document.getElementById("leaguenameBrec").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=clubstableB&season="+season+"&leaguename="+leaguename+"&access="+arg;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateCopyClubs(arg){
//alert(arg);	
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populateClubB('clubname') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Club_Name',event) onmouseout=toolTip('msgdivB','',event)>Club_Names</a></td>";
	str += "<td>Full_Name</td><td>Club_Alias</td>";
	str += "<td><a href=javascript:populateClubB('ranks') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Club_Positions',event) onmouseout=toolTip('msgdivB','',event)>Club_Positions</a></td>";
	str += "<td>Club_Stadia</td><td><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var nameid="";
    var namevalue="";
    var longnameid="";
    var longnamevalue="";
    var aliasid="";
    var aliasvalue="";
    var rankid="";
    var rankvalue="";
    var stadiumid="";
    var stadiumvalue="";
	var checkboxid="";
	var hiddenid="";
    var col_split = "";
    var count=0;
	var k=1;
	myCheckboxes=0;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoidB"+k;
		serialnovalue=col_split[0];
		nameid="nameidB"+k;
		namevalue=col_split[1];
		longnameid="longnameidB"+k;
		longnamevalue=col_split[2];
		aliasid="aliasidB"+k;
		aliasvalue=col_split[3];
		rankid="rankidB"+k;
		rankvalue=col_split[5];
		stadiumid="stadiumidB"+k;
		stadiumvalue=col_split[7];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+namevalue+"' id='"+nameid+"' size='25' /></td>";
        str += "<td><input type='text' readonly value='"+longnamevalue+"' id='"+longnameid+"' size='35' /></td>";
        str += "<td><input type='text' readonly value='"+aliasvalue+"' id='"+aliasid+"' size='20' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' readonly value='"+rankvalue+"' id='"+rankid+"' size='10' />";
        str += "<td><input type='text' readonly value='"+stadiumvalue+"' id='"+stadiumid+"' size='35' /></td>";
		myCheckboxes++;
		str += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+namevalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('clubslistB').innerHTML=str;
}

var myCheckboxes=0;
function doCheckboxes(){
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		if(document.getElementById('selectall').checked==true){
			document.getElementById(checkboxid).checked=true;
		}else{
			document.getElementById(checkboxid).checked=false;
		}
	}

}

function PasteToCurrentSeason(){
    var season = document.getElementById("seasonBrec").value;
    var leaguename = document.getElementById("leaguenameBrec").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		if(document.getElementById(checkboxid).checked==true){
			serialnoid="serialnoidB"+k;
			serialnovalue=document.getElementById(serialnoid).value;
			nameid="nameidB"+k;
			namevalue=document.getElementById(nameid).value;
			longnameid="longnameidB"+k;
			longnamevalue=document.getElementById(longnameid).value;
			aliasid="aliasidB"+k;
			aliasvalue=document.getElementById(aliasid).value;
			rankid="rankidB"+k;
			rankvalue=document.getElementById(rankid).value;
			stadiumid="stadiumidB"+k;
			stadiumvalue=document.getElementById(stadiumid).value;
			param2 +=namevalue+"!!!"+longnamevalue+"!!!"+aliasvalue+"!!!"+rankvalue+"!!!"+stadiumvalue+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some CLUBS to copy: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
    var seasonA = document.getElementById("seasonrec").value;
    var leaguenameA = document.getElementById("leaguenamerec").value;
	param2 = "&param2="+param2;
    var param = "&param="+seasonA+"]["+leaguenameA;
    var url = "/nigeriapremierleague/databackend.php?option=copyClubs&table=clubstable"+param+param2;
//alert(season+"   "+leaguename+"   "+seasonA+"   "+leaguenameA);	//alert(url);	
	AjaxFunctionSetup(url);
}

function populateClub(arg,arg2){
	
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var season = document.getElementById("seasonrec").value;
    var leaguename = document.getElementById("leaguenamerec").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=clubstable&season="+season+"&leaguename="+leaguename+"&access="+arg;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	//alert(url);
    AjaxFunctionSetup(url);
}

function populateClubB(arg,arg2){
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var season = document.getElementById("seasonB").value;
    var leaguename = document.getElementById("leaguenameB").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=clubstableB&season="+season+"&leaguename="+leaguename+"&access="+arg;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateClubs(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populateClub('clubname') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Club_Name',event) onmouseout=toolTip('msgdiv','',event)>Club_Name</a></td>";
	str += "<td>Full_Name</td><td>Club_Alias</td>";
	str += "<td><a href=javascript:populateClub('ranks') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Club_Positions',event) onmouseout=toolTip('msgdiv','',event)>Club_Positions</a></td>";
	str += "<td>Club_Statdia</td><td>&nbsp;</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var nameid="";
    var namevalue="";
    var longnameid="";
    var longnamevalue="";
    var aliasid="";
    var aliasvalue="";
    var rankid="";
    var rankvalue="";
    var stadiumid="";
    var stadiumvalue="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		nameid="nameid"+k;
		namevalue=col_split[1];
		longnameid="longnameid"+k;
		longnamevalue=col_split[2];
		aliasid="aliasid"+k;
		aliasvalue=col_split[3];
		rankid="rankid"+k;
		rankvalue=col_split[5];
		stadiumid="stadiumid"+k;
		stadiumvalue=col_split[7];
        
		str += "<td align='right'>"+(++count)+".</td>"; 
        str += "<td><input type='text' value='"+namevalue+"' id='"+nameid+"' onblur='this.value=capitalize(this.value)' size='25' /></td>";
        str += "<td><input type='text' value='"+longnamevalue+"' id='"+longnameid+"' onblur='this.value=capAdd(this.value)' size='35' /></td>";
        str += "<td><input type='text' value='"+aliasvalue+"' id='"+aliasid+"' onblur='this.value=capAdd(this.value)' size='20' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' value='"+rankvalue+"' id='"+rankid+"' size='10' />";
        str += "<td><input type='text' value='"+stadiumvalue+"' id='"+stadiumid+"' onblur='this.value=capAdd(this.value)' size='35' /></td>";
        str += "<td><a href=javascript:updateClub('"+serialnoid+"','"+nameid+"','"+longnameid+"','"+aliasid+"','"+rankid+"','"+stadiumid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateClub('"+serialnoid+"','"+nameid+"','"+longnameid+"','"+aliasid+"','"+rankid+"','"+stadiumid+"','deleteRecord')>Delete</a></td></tr>";
    }
	if(flag==0){
		str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flag=1;
	}else{
		str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flag=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	nameid="nameid"+k;
	namevalue="";
	longnameid="longnameid"+k;
	longnamevalue="";
	aliasid="aliasid"+k;
	aliasvalue="";
	rankid="rankid"+k;
	rankvalue="";
	stadiumid="stadiumid"+k;
	stadiumvalue="";
	
	str += "<td align='right'>"+(++count)+".</td>";
	str += "<td><input type='text' value='"+namevalue+"' id='"+nameid+"' onblur='this.value=capitalize(this.value)' size='25' /></td>";
	str += "<td><input type='text' value='"+longnamevalue+"' id='"+longnameid+"' onblur='this.value=capAdd(this.value)' size='35' /></td>";
	str += "<td><input type='text' value='"+aliasvalue+"' id='"+aliasid+"' onblur='this.value=capAdd(this.value)' size='20' />";
	str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	str += "<td><input type='text' value='"+rankvalue+"' id='"+rankid+"' size='10' />";
	str += "<td><input type='text' value='"+stadiumvalue+"' id='"+stadiumid+"' onblur='this.value=capAdd(this.value)' size='35' /></td>";
	str += "<td><a href=javascript:updateClub('"+serialnoid+"','"+nameid+"','"+longnameid+"','"+aliasid+"','"+rankid+"','"+stadiumid+"','addRecord')>Save</a></td></tr>";
    str += "</table>";
    document.getElementById('clubslist').innerHTML=str;
	document.getElementById(nameid).focus();
}

function updateClub(serialno,nameid,longnameid,aliasid,rankid,stadiumid,option){
	serialno = document.getElementById(serialno).value;
	clubname = document.getElementById(nameid).value;
    longname = document.getElementById(longnameid).value;
	clubalias = document.getElementById(aliasid).value;
	ranks = document.getElementById(rankid).value;
	stadium = document.getElementById(stadiumid).value;

    var season = document.getElementById("seasonrec").value;
    var leaguename = document.getElementById("leaguenamerec").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";

    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if (ranks=="") error += "Club Position must not be blank.<br><br>";
    if (isNaN(ranks)) error += "Club Position must be numeric.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    var table ="clubstable";
    if(serialno==null) serialno="";
    
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');

    var param = "&param="+serialno+"]["+clubname+"]["+longname+"]["+clubalias+"]["+leaguename;
	param +="]["+ranks+"]["+season+"]["+stadium;
    var url = "/nigeriapremierleague/databackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    //alert(url);
	AjaxFunctionSetup(url);
}

function showPlayers(){
	$('#playerstable').dialog('open');
}

function CopyFromPreviousSeasonB(){
    var leaguename = document.getElementById("leaguename").value;
    var season = document.getElementById("season").value;
    var clubname = document.getElementById("clubname").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	$('#copyplayerstable').dialog('open');
}

function populateCopyPlayer(arg){
    var leaguename = document.getElementById("leaguenameBrec").value;
    var season = document.getElementById("seasonBrec").value;
    var clubname = document.getElementById("clubnameBrec").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=playerstableB&season="+season+"&leaguename="+leaguename+"&clubname="+clubname+"&access="+arg;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
//alert(url);	
	AjaxFunctionSetup(url);
}

function populateCopyPlayers(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populatePlayerB('regnumber') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_License_No',event) onmouseout=toolTip('msgdivB','',event)>License_No</a></td>";
	str += "<td><a href=javascript:populatePlayerB('playername') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Player_Names',event) onmouseout=toolTip('msgdivB','',event)>Player_Name</a></td>";
	str += "<td>Birth_Date</td><td>Jersey_No</td><td>Last_Club</td><td>Cotract</td><td>Position</td><td>Pictures</td><td><input type='checkbox' id='selectall' onclick='doCheckboxesB();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var nameid="";
    var namevalue="";
    var regnoid="";
    var regnovalue="";
    var bdateid="";
    var bdatevalue="";
    var pictureid="";
    var picturevalue="";
    var jerseyid="";
    var jerseyvalue="";
    var pclubid="";
    var pclubvalue="";
    var contractid="";
    var contractvalue="";
    var teampositionid="";
    var teampositionvalue="";
	var checkboxid="";
	var hiddenid="";
    var col_split = "";
    var count=0;
	var k=1;
	myCheckboxes=0;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoidB"+k;
		serialnovalue=col_split[0];
		nameid="nameidB"+k;
		namevalue=col_split[2];
		regnoid="regnoidB"+k;
		regnovalue=col_split[1];
		pictureid="pictureid"+k;
		picturevalue=col_split[7].replace(/ /g,'_');
		jerseyid="jerseyid"+k;
		jerseyvalue=col_split[8];
		pclubid="pclubid"+k;
		pclubvalue=col_split[9];
		contractid="contractid"+k;
		contractvalue=col_split[10];
		teampositionid="teampositionid"+k;
		teampositionvalue=col_split[11];
		bdateid="bdateidB"+k;
		bdatevalue=col_split[3];
		bdatevalue=bdatevalue.substr(8,2)+"/"+bdatevalue.substr(5,2)+"/"+bdatevalue.substr(0,4);
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+regnovalue+"' id='"+regnoid+"' size='23' /></td>";
        str += "<td><input type='text' readonly value='"+namevalue+"' id='"+nameid+"' size='30' /></td>";
        str += "<td><input type='text' readonly value='"+bdatevalue+"' id='"+bdateid+"' size='12' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' value='"+jerseyvalue+"' name='"+jerseyid+"' id='"+jerseyid+"' size='10' /></td>";
        str += "<td><input type='text' value='"+pclubvalue+"' name='"+pclubid+"' id='"+pclubid+"' size='20' /></td>";
        str += "<td><input type='text' value='"+contractvalue+"' name='"+contractid+"' id='"+contractid+"' size='10' /></td>";
        str += "<td><input type='text' value='"+teampositionvalue+"' name='"+teampositionid+"' id='"+teampositionid+"' size='12' /></td>";
		if(col_split[7]==null || col_split[7]==""){
			str += "<td><div id='f1_uploaded_file"+k+"' onclick=javascript:browseFiles(this.id,'"+serialnovalue+"') style='display:block; margin-left: 15px; padding: 5px 5px; text-align:center; background:#009933; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 11px; width: 50px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold;'>Upload</div></td>";
		}else{
			col_split[7] = "<div id='f1_uploaded_file"+k+"'><img src='photo/"+col_split[7]+"' width='40' height='40' style=' cursor: pointer;' onclick=javascript:browseFiles(this.id,'"+serialnovalue+"') title='Picture' alt='Applicant`s Passport' /><br/></div>";
			str += "<td align='center'>" + col_split[7] + "</td>";
		}
		myCheckboxes++;
		str += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+namevalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('playerslistB').innerHTML=str;
}

function doCheckboxesB(){
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		if(document.getElementById('selectall').checked==true){
			document.getElementById(checkboxid).checked=true;
		}else{
			document.getElementById(checkboxid).checked=false;
		}
	}

}

function PasteToCurrentSeasonB(){
    var leaguename = document.getElementById("leaguenameBrec").value;
    var season = document.getElementById("seasonBrec").value;
    var clubname = document.getElementById("clubnameBrec").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		if(document.getElementById(checkboxid).checked==true){
			serialnoid="serialnoidB"+k;
			serialnovalue=document.getElementById(serialnoid).value;
			nameid="nameidB"+k;
			namevalue=document.getElementById(nameid).value;
			regnoid="regnoidB"+k;
			regnovalue=document.getElementById(regnoid).value;
			bdateid="bdateidB"+k;
			bdatevalue=document.getElementById(bdateid).value;
			bdatevalue = bdatevalue.substr(6,4)+"-"+bdatevalue.substr(3,2)+"-"+bdatevalue.substr(0,2);
			param2 +=regnovalue+"!!!"+namevalue+"!!!"+bdatevalue+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some PLAYERS to copy: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
    var leaguenameA = document.getElementById("leaguenamerec").value;
    var seasonA = document.getElementById("seasonrec").value;
    var clubnameA = document.getElementById("clubnamerec").value;
	param2 = "&param2="+param2;
    var param = "&param="+seasonA+"]["+clubnameA+"]["+leaguenameA;
    var url = "/nigeriapremierleague/databackend.php?option=copyPlayers&table=playerstable"+param+param2;
	AjaxFunctionSetup(url);
}

function populatePlayer(arg,arg2){
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var clubname = document.getElementById("clubnamerec").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=playerstable&season="+season+"&leaguename="+leaguename+"&clubname="+clubname+"&access="+arg+"&menuoption="+arg2;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populatePlayerB(arg,arg2){
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var leaguename = document.getElementById("leaguenameB").value;
    var season = document.getElementById("seasonB").value;
    var clubname = document.getElementById("clubnameB").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=playerstableB&season="+season+"&leaguename="+leaguename+"&clubname="+clubname+"&access="+arg;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populatePlayers(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populatePlayer('regnumber') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_License_No',event) onmouseout=toolTip('msgdiv','',event)>License_No</a></td>";
	str += "<td><a href=javascript:populatePlayer('playername') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Player_Name',event) onmouseout=toolTip('msgdiv','',event)>Player_Name</a></td>";
	str += "<td>Birth_Date</td><td>Jersey_No</td><td>Last_Club</td><td>Cotract</td><td>Position</td><td>Pictures</td><td>&nbsp;</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var nameid="";
    var namevalue="";
    var regnoid="";
    var regnovalue="";
    var bdateid="";
    var bdatevalue="";
    var pictureid="";
    var picturevalue="";
    var jerseyid="";
    var jerseyvalue="";
    var pclubid="";
    var pclubvalue="";
    var contractid="";
    var contractvalue="";
    var teampositionid="";
    var teampositionvalue="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		nameid="nameid"+k;
		namevalue=col_split[2];
		regnoid="regnoid"+k;
		regnovalue=col_split[1];
		bdateid="bdateid"+k;
		bdatevalue=col_split[3];
		pictureid="pictureid"+k;
		picturevalue=col_split[7].replace(/ /g,'_');
		jerseyid="jerseyid"+k;
		jerseyvalue=col_split[8];
		pclubid="pclubid"+k;
		pclubvalue=col_split[9];
		contractid="contractid"+k;
		contractvalue=col_split[10];
		teampositionid="teampositionid"+k;
		teampositionvalue=col_split[11];
   		bdatevalue=bdatevalue.substr(8,2)+"/"+bdatevalue.substr(5,2)+"/"+bdatevalue.substr(0,4);

		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+regnovalue+"' id='"+regnoid+"' onblur='this.value=capitalize(this.value)' size='23' /></td>";
        str += "<td><input type='text' value='"+namevalue+"' id='"+nameid+"' onblur='this.value=capitalize(this.value)' size='30' /></td>";
        str += "<td><input type='text' value='"+bdatevalue+"' name='"+bdateid+"' id='"+bdateid+"' size='12' onClick=toDate('"+bdateid+"') />";
		str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' value='"+jerseyvalue+"' name='"+jerseyid+"' id='"+jerseyid+"' size='10' /></td>";
        str += "<td><input type='text' value='"+pclubvalue+"' name='"+pclubid+"' id='"+pclubid+"' size='20' /></td>";
        str += "<td><input type='text' value='"+contractvalue+"' name='"+contractid+"' id='"+contractid+"' size='10' /></td>";
        str += "<td><input type='text' value='"+teampositionvalue+"' name='"+teampositionid+"' id='"+teampositionid+"' size='12' /></td>";
		if(col_split[7]==null || col_split[7]==""){
			str += "<td><div id='f1_uploaded_file"+k+"' onclick=javascript:browseFiles(this.id,'"+serialnovalue+"') style='display:block; margin-left: 15px; padding: 5px 5px; text-align:center; background:#009933; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 11px; width: 50px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold;'>Upload</div></td>";
		}else{
			col_split[7] = "<div id='f1_uploaded_file"+k+"'><img src='photo/"+col_split[7]+"' width='40' height='40' style=' cursor: pointer;' onclick=javascript:browseFiles(this.id,'"+serialnovalue+"') title='Picture' alt='Applicant`s Passport' /><br/></div>";
			str += "<td align='center'>"+col_split[7]+"&nbsp;&nbsp;<a href=javascript:deletePic('"+serialnoid+"')>Del Pic</a>"+"</td>";
		}
        str += "<td><a href=javascript:updatePlayer('"+serialnoid+"','"+regnoid+"','"+nameid+"','"+bdateid+"','"+picturevalue+"','"+jerseyid+"','"+pclubid+"','"+contractid+"','"+teampositionid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updatePlayer('"+serialnoid+"','"+regnoid+"','"+nameid+"','"+bdateid+"','"+picturevalue+"','"+jerseyid+"','"+pclubid+"','"+contractid+"','"+teampositionid+"','deleteRecord')>Delete</a></td></tr>";
    }
	if(flag==0){
		str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flag=1;
	}else{
		str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flag=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	nameid="nameid"+k;
	namevalue="";
	regnoid="regnoid"+k;
	regnovalue="";
	bdateid="bdateid"+k;
	bdatevalue="";
	jerseyid="jerseyid"+k;
	jerseyvalue="";
	pclubid="pclubid"+k;
	pclubvalue="";
	contractid="contractid"+k;
	contractvalue="";
	teampositionid="teampositionid"+k;
	teampositionvalue="";
	
	str += "<td align='right'>"+(++count)+".</td>";
	str += "<td><input type='text' value='"+regnovalue+"' id='"+regnoid+"' onblur='this.value=capitalize(this.value)' size='23' /></td>";
	str += "<td><input type='text' value='"+namevalue+"' id='"+nameid+"' onblur='this.value=capitalize(this.value)' size='30' /></td>";
    str += "<td><input type='text' value='"+bdatevalue+"' name='"+bdateid+"' id='"+bdateid+"' size='12' onClick=toDate('"+bdateid+"') />";
	str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	str += "<td><input type='text' value='"+jerseyvalue+"' name='"+jerseyid+"' id='"+jerseyid+"' size='10' /></td>";
	str += "<td><input type='text' value='"+pclubvalue+"' name='"+pclubid+"' id='"+pclubid+"' size='20' /></td>";
	str += "<td><input type='text' value='"+contractvalue+"' name='"+contractid+"' id='"+contractid+"' size='10' /></td>";
    str += "<td><input type='text' value='"+teampositionvalue+"' name='"+teampositionid+"' id='"+teampositionid+"' size='12' /></td>";
	str += "<td>&nbsp;</td>";
	str += "<td><a href=javascript:updatePlayer('"+serialnoid+"','"+regnoid+"','"+nameid+"','"+bdateid+"','"+picturevalue+"','"+jerseyid+"','"+pclubid+"','"+contractid+"','"+teampositionid+"','addRecord')>Save</a></td></tr>";
    str += "</table>";
    document.getElementById('playerslist').innerHTML=str;
	document.getElementById(regnoid).focus();
}

function deletePic(serialno){
	serialno = document.getElementById(serialno).value;
    var url = "/nigeriapremierleague/databackend.php?option=deletePic&table=playerstable&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updatePlayer(serialno,regnoid,nameid,bdateid,picture,jerseyid,pclubid,contractid,teampositionid,option){
	picture=picture.replace(/_/g,' ');
	serialno = document.getElementById(serialno).value;
    regno = document.getElementById(regnoid).value;
	playername = document.getElementById(nameid).value;
	bdate = document.getElementById(bdateid).value;
	bdate = bdate.substr(6,4)+"-"+bdate.substr(3,2)+"-"+bdate.substr(0,2);
	jersey = document.getElementById(jerseyid).value;
	pclub = document.getElementById(pclubid).value;
	contract = document.getElementById(contractid).value;
	teamposition = document.getElementById(teampositionid).value;
    var leaguename = document.getElementById("leaguenamerec").value;
    var season = document.getElementById("seasonrec").value;
    var clubname = document.getElementById("clubnamerec").value;

    var error="";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (clubname=="") error += "Club Name must not be blank.<br><br>";

    if (regno=="") error += "License No must not be blank.<br><br>";
    if (playername=="") error += "Player Name must not be blank.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    var table ="playerstable";
    if(serialno==null) serialno="";
    
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
	if(bdate=="--") bdate="0000-00-00";

    var param = "&param="+serialno+"]["+regno+"]["+playername+"]["+bdate+"]["+clubname+"]["+season+"]["+leaguename+"]["+picture+"]["+jersey+"]["+pclub+"]["+contract+"]["+teamposition;
    var url = "/nigeriapremierleague/databackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function toDate(datefld){
    displayDatePicker(datefld, false, 'dmy', '/');
}

function populateFixture(arg,arg2,arg3){
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var season = document.getElementById("seasonrec").value;
    var leaguename = document.getElementById("leaguenamerec").value;
    var week = document.getElementById("week").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=fixturestable&season="+season+"&leaguename="+leaguename+"&week="+week+"&access="+arg;
	var url = "";
	if(arg3=="generate"){
		url = "/nigeriapremierleague/databackend.php?option=generateFixture"+param;
	}else{
		url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	}
	document.getElementById("fixtureslist").innerHTML = "";
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your fixtures generation.";
    $('#showAlert').dialog('open');
	AjaxFunctionSetup(url);
}

function populateFixtures(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td align='right'>S/No</td><td align='center'><a href=javascript:populateFixture('weeks') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Weeks',event) onmouseout=toolTip('msgdiv','',event)>Weeks</a></td>";
	str += "<td align='center'><a href=javascript:populateFixture('matchno') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Match_Nos',event) onmouseout=toolTip('msgdiv','',event)>Match_No</a></td>";
	str += "<td><a href=javascript:populateFixture('host') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Hosts',event) onmouseout=toolTip('msgdiv','',event)>Hosts</a></td>";
	str += "<td><a href=javascript:populateFixture('visitor') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Visitors',event) onmouseout=toolTip('msgdiv','',event)>Visitors</a></td>";
	str += "<td>Match_Date</td><td>Kickoff_Time</td></tr>";
    var flag=0;
    var serialnovalue="";
    var weekid="";
    var weekvalue="";
    var matchnoid="";
    var matchnovalue="";
    var hostid="";
    var hostvalue="";
    var visitorid="";
    var visitorvalue="";
    var mdateid="";
    var mdatevalue="";
    var mtimeid="";
    var mtimevalue="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnovalue=col_split[0];
		weekvalue=col_split[3];
		matchnovalue=col_split[5];
		hostvalue=col_split[8];
		visitorvalue=col_split[9];
		mdateid="mdateid"+k;
		mdatevalue=col_split[7];
		mtimeid="mtimeid"+k;
		mtimevalue=col_split[7].substr(11,8);
   		mdatevalue=mdatevalue.substr(8,2)+"/"+mdatevalue.substr(5,2)+"/"+mdatevalue.substr(0,4);
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td align='center'>"+weekvalue+"</td>";
        str += "<td align='center'>"+matchnovalue+"</td>";
        str += "<td>"+hostvalue+"</td>";
        str += "<td>"+visitorvalue+"</td>";
		str += "<td><input type='text' value='"+mdatevalue+"' name='"+mdateid+"' id='"+mdateid+"' size='12' onClick=toDate('"+mdateid+"') onBlur=updateFixtureDate('"+serialnovalue+"','"+mdateid+"','"+mtimeid+"','"+matchnovalue+"') /></td>";
		str += "<td><input type='text' value='"+mtimevalue+"' name='"+mtimeid+"' id='"+mtimeid+"' size='12' onBlur=updateFixtureDate('"+serialnovalue+"','"+mdateid+"','"+mtimeid+"','"+matchnovalue+"') onkeyup='this.value=timeFormat(this.value)' /></td></tr>";
    }
    str += "</table>";
    document.getElementById('fixtureslist').innerHTML=str;
}

function updateFixtureDate(serialno,date,time,matchno){
    var season = document.getElementById("season").value;
    var leaguename = document.getElementById("leaguename").value;
	date=document.getElementById(date).value;
	time=document.getElementById(time).value;
	datetime=date.substr(6,4)+"-"+date.substr(3,2)+"-"+date.substr(0,2)+" "+time;
    var url = "/nigeriapremierleague/databackend.php?option=updateFixtureDate"+"&table=fixturestable&serialno="+serialno+"&param="+datetime+"&matchno="+matchno+"&leaguename="+leaguename+"&season="+season;
	AjaxFunctionSetup(url);
}

function populateMatch(arg,arg2,arg3){
	createCookie("sortby",arg,false);
	if(arg2==null){
		if(readCookie("sortorder")=="ASC"){
			createCookie("sortorder","DESC",false);
		}else if(readCookie("sortorder")=="DESC"){
			createCookie("sortorder","ASC",false);
		}else{
			createCookie("sortorder","ASC",false);
		}
	}else{
		createCookie("sortorder",arg2,false);
	}
    var season = document.getElementById("seasonrec").value;
    var leaguename = document.getElementById("leaguenamerec").value;
    var week = document.getElementById("week").value;

    var error="";
    if (season=="") error += "Season must not be blank.<br><br>";
    if (leaguename=="") error += "League Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=matchestable&season="+season+"&week="+week+"&leaguename="+leaguename+"&access="+arg;
	var url = "";
	if(arg3=="generate"){
		url = "/nigeriapremierleague/databackend.php?option=generateMatch"+param;
	}else{
		url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+param;
	}
	document.getElementById("matcheslist").innerHTML = "";
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your matches generation.";
    $('#showAlert').dialog('open');
	AjaxFunctionSetup(url);
}

function populateMatches(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='font-size: 11px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td align='right'>S/No</td><td align='center'><a href=javascript:populateMatch('weeks') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Weeks',event) onmouseout=toolTip('msgdiv','',event)>Weeks</a></td>";
	str += "<td align='center'><a href=javascript:populateMatch('matchno') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Club_Positions',event) onmouseout=toolTip('msgdiv','',event)>Match_No</a></td>";
	str += "<td><a href=javascript:populateMatch('host') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Club_Positions',event) onmouseout=toolTip('msgdiv','',event)>Host_Teams</a></td><td>&nbsp;</td>";
	str += "<td>&nbsp;</td><td><a href=javascript:populateMatch('visitor') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Club_Positions',event) onmouseout=toolTip('msgdiv','',event)>Visiting_Teams</a></td>";
	str += "<td>Match_Date</td><td>Kickoff_Time</td><td>Match_Status</td><td>Lock</td><td></td></tr>";
    var flag=0;
    var serialnovalue="";
    var weekvalue="";
    var matchnovalue="";
    var hostvalue="";
    var hostgoalid="";
    var hostgoalvalue="";
    var visitorvalue="";
    var visitorgoalid="";
    var visitorgoalvalue="";
    var mdatevalue="";
    var mtimevalue="";
    var matchflagid="";
    var matchflagvalue="";
    var lockid="";
    var lockvalue="";
    var col_split = "";
	var matchofficial = "";
	var officialreport = "";
	var spectators = "";
	var commissioner = "";
	var commissionerreport = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnovalue=col_split[0];
		weekvalue=col_split[3];
		matchnovalue=col_split[7];
		hostvaluerec=col_split[1];
		hostvalue=col_split[17];
		hostgoalid="hostgoalid"+k;
		hostgoalvalue=col_split[4];
		visitorvaluerec=col_split[2];
		visitorvalue=col_split[18];
		visitorgoalid="visitorgoalid"+k;
		visitorgoalvalue=col_split[5];
		mdatevalue=col_split[9];
		mtimevalue=col_split[9].substr(11,8);
   		mdatevalue=mdatevalue.substr(8,2)+"/"+mdatevalue.substr(5,2)+"/"+mdatevalue.substr(0,4);
		matchofficial=col_split[10].replace(/ /g, '#');
		officialreport=col_split[11].replace(/ /g, '#');
		spectators=col_split[12].replace(/ /g, '#');
		commissioner=col_split[14].replace(/ /g, '#');
		commissionerreport=col_split[15].replace(/ /g, '#');
		matchflagid="matchflagid"+k;
        matchflagvalue=col_split[13];
		lockid="lockid"+k;
		lockvalue=col_split[16];

		if(lockvalue=="1"){
			str += "<td align='right'>"+(++count)+".</td>";
			str += "<td align='center'>"+weekvalue+"</td>";
			str += "<td align='center'>"+matchnovalue+"</td>";
			str += "<td align='left'>"+hostvalue+"</td><td align='left'><input type='text' readonly disabled='true' name='"+hostgoalid+"' id='"+hostgoalid+"' value='"+hostgoalvalue+"' size='3' /></td>";
			str += "<td align='left'><input type='text' readonly disabled='true' name='"+visitorgoalid+"' id='"+visitorgoalid+"' value='"+visitorgoalvalue+"' size='3' /></td><td align='left'>"+visitorvalue+"</td>";
			str += "<td>"+mdatevalue+"</td>";
			str += "<td>"+mtimevalue+"</td>";
			if(matchflagvalue=="Yes"){
				str += "<td><input type='checkbox' readonly disabled='true' id='"+matchflagid+"' checked onClick=updateGoals('"+serialnovalue+"','"+hostgoalid+"','"+visitorgoalid+"','"+matchflagid+"','"+matchflagvalue+"') >&nbsp;[Played]</td>";
			}else{
				str += "<td><input type='checkbox' readonly disabled='true' id='"+matchflagid+"' onClick=updateGoals('"+serialnovalue+"','"+hostgoalid+"','"+visitorgoalid+"','"+matchflagid+"','"+matchflagvalue+"') >&nbsp;[Pending]</td>";
			}
			str += "<td><input type='checkbox' id='"+lockid+"' checked onClick=updateLocks('"+serialnovalue+"','"+lockvalue+"') >&nbsp;[Locked]</td>";
			str += "<td>Record Locked</td></tr>";
		}else{
			str += "<td align='right'>"+(++count)+".</td>";
			str += "<td align='center'>"+weekvalue+"</td>";
			str += "<td align='center'>"+matchnovalue+"</td>";
			str += "<td align='left'>"+hostvalue+"</td><td align='left'><input type='text' name='"+hostgoalid+"' id='"+hostgoalid+"' value='"+hostgoalvalue+"' size='3' /></td>";
			str += "<td align='left'><input type='text' name='"+visitorgoalid+"' id='"+visitorgoalid+"' value='"+visitorgoalvalue+"' size='3' /></td><td align='left'>"+visitorvalue+"</td>";
			str += "<td>"+mdatevalue+"</td>";
			str += "<td>"+mtimevalue+"</td>";
			if(matchflagvalue=="Yes"){
				str += "<td><input type='checkbox' id='"+matchflagid+"' checked onClick=updateGoals('"+serialnovalue+"','"+hostgoalid+"','"+visitorgoalid+"','"+matchflagid+"','"+matchflagvalue+"') >&nbsp;[Played]</td>";
			}else{
				str += "<td><input type='checkbox' id='"+matchflagid+"' onClick=updateGoals('"+serialnovalue+"','"+hostgoalid+"','"+visitorgoalid+"','"+matchflagid+"','"+matchflagvalue+"') >&nbsp;[Pending]</td>";
			}
			str += "<td><input type='checkbox' id='"+lockid+"' onClick=updateLocks('"+serialnovalue+"','"+lockvalue+"') >&nbsp;[Open]</td>";
			str += "<td><a href=javascript:updateMatches('"+serialnovalue+"','"+weekvalue+"','"+matchnovalue+"','"+hostvalue.replace(/ /g, '_')+"','"+visitorvalue.replace(/ /g, '_')+"','"+mdatevalue+"','"+mtimevalue+"','"+hostvaluerec+"','"+visitorvaluerec+"','"+matchofficial+"','"+officialreport+"','"+spectators+"','"+commissioner+"','"+commissionerreport+"')>Update Goals</a></td></tr>";
		}
    }
    str += "</table>";
    document.getElementById('matcheslist').innerHTML=str;
}

function updateMatches(serialno,week,matchno,host,visitor,matchdate,kickoff,hostrec,visitorrec,matchofficial,officialreport,spectators,commissioner,commissionerreport){
    var season = document.getElementById("season").value;
    var leaguename = document.getElementById("leaguename").value;
	var seasonrec = document.getElementById("seasonrec").value;
    var leaguenamerec = document.getElementById("leaguenamerec").value;
	document.getElementById("leaguenameA").value=leaguename;
	document.getElementById("seasonA").value=season;
	document.getElementById("weekA").value=week;
	document.getElementById("matchnoA").value=matchno;
	document.getElementById("matchdateA").value=matchdate;
	document.getElementById("kickoffA").value=kickoff;
	document.getElementById("official").value=matchofficial.replace(/#/g, ' ');
	document.getElementById("report").value=officialreport.replace(/#/g, ' ');;
	document.getElementById("spectator").value=comaSeparated(spectators);
	document.getElementById("commissioner").value=commissioner.replace(/#/g, ' ');;
	document.getElementById("report2").value=commissionerreport.replace(/#/g, ' ');;
	    
	createCookie("hosteam",hostrec.replace(/_/g, ' '),false);
	createCookie("visiteam",visitorrec.replace(/_/g, ' '),false);
	createCookie("hostdisplay",host.replace(/_/g, ' '),false);
	createCookie("visitordisplay",visitor.replace(/_/g, ' '),false);
	$('#goalstable').dialog('open');
    var param = "&serialno="+serialno+"&season="+seasonrec+"&leaguename="+leaguenamerec+"&week="+week+"&matchno="+matchno;
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs&table=goalstable"+param;
	AjaxFunctionSetup(url);
}

function updateGoals(serialno, hostgoalid, visitorgoalid, matchflagid, matchflag){
    var season = document.getElementById("season").value;
    var leaguename = document.getElementById("leaguename").value;
    var week = document.getElementById("week").value;
    var hostgoal = document.getElementById(hostgoalid).value;
    var visitorgoal = document.getElementById(visitorgoalid).value;
	if(matchflag=="Yes"){
		if(parseInt(hostgoal,10)>0 ||parseInt(visitorgoal,10)>0){
			document.getElementById(matchflagid).checked=true;
			var error = "<br><b>Please correct the following errors:</b> <br><br><br>Make sure host and visiting team's goals are both zero to change the match flag to [Pending]";
			document.getElementById("showError").innerHTML = error;
			$('#showError').dialog('open');
			return true;
		}
		//document.getElementById(matchflagid).checked=false;
		matchflag="";
	}else{
		//document.getElementById(matchflagid).checked=true;
		matchflag="Yes";
	}
    var param = "&param="+serialno+"]["+hostgoal+"]["+visitorgoal+"]["+matchflag+"]["+season+"]["+week+"]["+leaguename;
    var url = "/nigeriapremierleague/databackend.php?option=updateGoals&table=matchestable"+param;
	AjaxFunctionSetup(url);
}

function updateLocks(serialno, lock){
	if(lock=="1"){
		lock="";
	}else{
		lock="1";
	}
    var param = "&param="+serialno+"]["+lock;
    var url = "/nigeriapremierleague/databackend.php?option=updateLocks&table=matchestable"+param;
	AjaxFunctionSetup(url);
}

var goalsaveflag="";
function populateGoals(arg){
	var hosteam = readCookie('hostdisplay');
	var visiteam = readCookie('visitordisplay');
	var hostrec = readCookie('hosteam');
	var visitorec = readCookie('visiteam');
	var row_split = arg.split('getAllRecs');
    var hoststr = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    hoststr += "<tr style='font-weight:bold; background-color:#FFFFFF;'>";
	hoststr += "<td align='center' width='350px' colspan='7'>Home Team<br><input type='text' style='text-align: center;' value='"+hosteam+"' size='20' readonly /></td></tr>";
    hoststr += "<tr style='font-weight:bold; color:#000000'>";
    hoststr += "<td>S/No</td><td>License_No</td><td>Player`s Name</td><td>Activity</td><td>Time</td><td></td></tr>";

    var visitstr = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
    visitstr += "<tr style='font-weight:bold; background-color:#FFFFFF;'>";
	visitstr += "<td align='center' width='350px' colspan='7'>Visiting Team<br><input type='text' style='text-align: center;' value='"+visiteam+"' size='20' readonly /></td></tr>";
    visitstr += "<tr style='font-weight:bold; color:#000000'>";
    visitstr += "<td>S/No</td><td>License_No</td><td>Player`s Name</td><td>Activity</td><td>Time</td><td></td></tr>";

	var flagA=0;
	var flagB=0;
    var serialnoid="";
    var serialnovalue="";
    var regvalue="";
    var regid="";
    var playervalue="";
    var playerid="";
    var activityvalue="";
    var activityid="";
    var goaltimevalue="";
    var goaltimeid="";
    var col_split = "";
    var countA=0;
    var countB=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		regnumber="regnumber"+k;
		regvalue=col_split[1];
		playerid="playerid"+k;
		playervalue=col_split[2];
		goaltimeid="goaltimeid"+k;
		goaltimevalue=col_split[6];
		activityid="activityid"+k;
		activityvalue=col_split[9];
	        if(col_split[3]==hostrec){
			if(flagA==0){
				hoststr += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
				flagA=1;
			}else{
				hoststr += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
				flagA=0;
			}
			hoststr += "<td align='right'>"+(++countA)+".</td>";
			hoststr += "<td><input type='text' name='"+regnumber+"' id='"+regnumber+"' value='"+regvalue+"' size='23' onkeyup=getRecordlist(this.id,'playerstable','recordlist2','host') onfocus=getRecordlist(this.id,'playerstable','recordlist2','host') /></td>";
			hoststr += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
			hoststr += "<td><input type='text' name='"+playerid+"' id='"+playerid+"' value='"+playervalue+"' size='15' readonly /></td>";
			if(activityvalue=="Goal"){
				hoststr += "<td><select id='"+activityid+"'><option></option><option selected>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
			}else if(activityvalue=="Caution"){
				hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option selected>Caution</option><option>Expulsion</option></select></td>";
			}else if(activityvalue=="Expulsion"){
				hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option selected>Expulsion</option></select></td>";
			}else{
				hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
			}
			hoststr += "<td><input type='text' name='"+goaltimeid+"' id='"+goaltimeid+"' value='"+goaltimevalue+"' size='3' /></td>";
			hoststr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+hostrec.replace(/ /g, '#')+"','update')>Update</a></td>";
			hoststr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+hostrec.replace(/ /g, '#')+"','delete')>Delete</a></td></tr>";
		}else{
			if(flagB==0){
				visitstr += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
				flagB=1;
			}else{
				visitstr += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
				flagB=0;
			}
			visitstr += "<td align='right'>"+(++countB)+".</td>";
			visitstr += "<td><input type='text' name='"+regnumber+"' id='"+regnumber+"' value='"+regvalue+"' size='23' onkeyup=getRecordlist(this.id,'playerstable','recordlist2','visit') onfocus=getRecordlist(this.id,'playerstable','recordlist2','visit') /></td>";
			visitstr += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
			visitstr += "<td><input type='text' name='"+playerid+"' id='"+playerid+"' value='"+playervalue+"' size='15' readonly /></td>";
			if(activityvalue=="Goal"){
				visitstr += "<td><select id='"+activityid+"'><option></option><option selected>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
			}else if(activityvalue=="Caution"){
				visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option selected>Caution</option><option>Expulsion</option></select></td>";
			}else if(activityvalue=="Expulsion"){
				visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option selected>Expulsion</option></select></td>";
			}else{
				visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
			}
			visitstr += "<td><input type='text' name='"+goaltimeid+"' id='"+goaltimeid+"' value='"+goaltimevalue+"' size='3' /></td>";
			visitstr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+visitorec.replace(/ /g, '#')+"','update')>Update</a></td>";
			visitstr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+visitorec.replace(/ /g, '#')+"','delete')>Delete</a></td></tr>";
		}
	}

	if(flagA==0){
		hoststr += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flagA=1;
	}else{
		hoststr += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flagA=0;
	}
	if(flagB==0){
		visitstr += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flagB=1;
	}else{
		visitstr += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flagB=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	regnumber="regnumber"+k;
	regvalue="";
	playerid="playerid"+k;
	playervalue="";
	goaltimeid="goaltimeid"+k;
	goaltimevalue="";
	activityid="activityid"+k;
	activityvalue="";
	
	hoststr += "<td align='right'>"+(++countA)+".</td>";
	hoststr += "<td><input type='text' name='"+regnumber+"' id='"+regnumber+"' value='"+regvalue+"' size='23' onkeyup=getRecordlist(this.id,'playerstable','recordlist2','host') onfocus=getRecordlist(this.id,'playerstable','recordlist2','host') /></td>";
	hoststr += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	hoststr += "<td><input type='text' name='"+playerid+"' id='"+playerid+"' value='"+playervalue+"' size='15' readonly /></td>";
	if(activityvalue=="Goal"){
		hoststr += "<td><select id='"+activityid+"'><option></option><option selected>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
	}else if(activityvalue=="Caution"){
		hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option selected>Caution</option><option>Expulsion</option></select></td>";
	}else if(activityvalue=="Expulsion"){
		hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option selected>Expulsion</option></select></td>";
	}else{
		hoststr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
	}
	hoststr += "<td><input type='text' name='"+goaltimeid+"' id='"+goaltimeid+"' value='"+goaltimevalue+"' size='3' /></td>";
	hoststr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+hostrec.replace(/ /g, '#')+"','save')>Save</a></td><td></td></tr>";
    hoststr += "</table>";

	++k;
	serialnoid="serialnoid"+k;
	regnumber="regnumber"+k;
	playerid="playerid"+k;
	goaltimeid="goaltimeid"+k;
	activityid="activityid"+k;
	
	visitstr += "<td align='right'>"+(++countB)+".</td>";
	visitstr += "<td><input type='text' name='"+regnumber+"' id='"+regnumber+"' value='"+regvalue+"' size='23' onkeyup=getRecordlist(this.id,'playerstable','recordlist2','visit') onfocus=getRecordlist(this.id,'playerstable','recordlist2','visit') /></td>";
	visitstr += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	visitstr += "<td><input type='text' name='"+playerid+"' id='"+playerid+"' value='"+playervalue+"' size='15' readonly /></td>";
	if(activityvalue=="Goal"){
		visitstr += "<td><select id='"+activityid+"'><option></option><option selected>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
	}else if(activityvalue=="Caution"){
		visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option selected>Caution</option><option>Expulsion</option></select></td>";
	}else if(activityvalue=="Expulsion"){
		visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option selected>Expulsion</option></select></td>";
	}else{
		visitstr += "<td><select id='"+activityid+"'><option></option><option>Goal</option><option>Caution</option><option>Expulsion</option></select></td>";
	}
	visitstr += "<td><input type='text' name='"+goaltimeid+"' id='"+goaltimeid+"' value='"+goaltimevalue+"' size='3' /></td>";
	visitstr += "<td><a href=javascript:goalsUpdate('"+serialnovalue+"','"+regnumber+"','"+playerid+"','"+activityid+"','"+goaltimeid+"','"+visitorec.replace(/ /g, '#')+"','save')>Save</a></td><td></td></tr>";
    visitstr += "</table>";
	document.getElementById('hostlist').innerHTML=hoststr;
	document.getElementById('visitorlist').innerHTML=visitstr;
	var comment="";
	if(goalsaveflag=="save"){
		comment="Record Saved.";
		goalsaveflag="";
	}
	if(goalsaveflag=="update"){
		comment="Record Updated.";
		goalsaveflag="";
	}
	if(goalsaveflag=="delete"){
		comment="Record Deleted.";
		goalsaveflag="";
	}
	if(comment.length>0){
        document.getElementById("showPrompt").innerHTML = "<b>Feedback!!!</b><br><br>"+comment;
        $('#showPrompt').dialog('open');
	}
    var season = document.getElementById("seasonA").value;
    var leaguename = document.getElementById("leaguenameA").value;
    var matchno = document.getElementById("matchnoA").value;
    var week = document.getElementById("weekA").value;
    var param = "&season="+season+"&leaguename="+leaguename+"&matchno="+matchno+"&week="+week;
    var url = "/nigeriapremierleague/databackend.php?option=getARecord&table=matchestable"+param;
	AjaxFunctionSetup(url);
}

function goalsUpdate(serialno,regnoid,playerid,activityid,goaltimeid,club,option){
	goalsaveflag=option;
	var official=document.getElementById("official").value;
	var spectator=document.getElementById("spectator").value.replace(/,/g, '');
	var report=document.getElementById("report").value;
	var commissioner=document.getElementById("commissioner").value;
	var report2=document.getElementById("report2").value;
	var param2="&param2="+official+"]["+spectator+"]["+report+"]["+commissioner+"]["+report2;

	var regno=document.getElementById(regnoid).value;
	var player=document.getElementById(playerid).value;
	var goaltime=document.getElementById(goaltimeid).value;
    var selectoption = document.getElementById(activityid);
    var activity=selectoption.options[selectoption.selectedIndex].text;
	var leaguename=document.getElementById("leaguenamerec").value;
	var season=document.getElementById("seasonrec").value;
	var week=document.getElementById("weekA").value;
	var matchno=document.getElementById("matchnoA").value;

    var error="";
    if (regno=="") error += "License No must not be blank.<br><br>";
    if (player=="") error += "Player's Name must not be blank.<br><br>";
    if (goaltime=="") error += "Time must not be blank.<br><br>";
    if (activity=="") error += "Activity must not be blank.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    var param = "&param="+serialno+"]["+regno+"]["+player+"]["+club.replace(/#/g, ' ')+"]["+season+"]["+leaguename+"]["+goaltime+"]["+week+"]["+matchno+"]["+activity+"]["+option;
    var url = "/nigeriapremierleague/databackend.php?option=goalsUpdate&table=matchestable"+param+param2;
	AjaxFunctionSetup(url);
}

function getRecords(table,serialno){
    if(serialno == null || serialno.length == 0) serialno = "1";
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
	if(table=="playerstable") {
		var leaguename = document.getElementById("leaguename").value;
		var season = document.getElementById("season").value;
		var clubname = document.getElementById("clubname").value;
		table += "&season="+season+"&clubname="+clubname+"&leaguename="+leaguename;
	}
    var url = "/nigeriapremierleague/databackend.php?option=getAllRecs"+"&table="+table+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function populateRecords(serialno, table){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/nigeriapremierleague/databackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function getRecordlist(arg2,arg3,arg4,arg5){
    curr_obj = document.getElementById(arg2);
    temp_table = arg3;
    list_obj = arg4;
	if(arg2=="week"){
		var leaguename = document.getElementById("leaguenamerec").value;
		var season = document.getElementById("seasonrec").value;
		//var week = document.getElementById("week").value;
		if(season!=null && season!="") arg2 += "&season="+season;
		if(leaguename!=null && leaguename!="") arg2 += "&leaguename="+leaguename;
	}
	if(arg2=="clubname"){
		var leaguename = document.getElementById("leaguenamerec").value;
		var season = document.getElementById("seasonrec").value;
		if(season!=null && season!="") arg2 += "&season="+season;
		if(leaguename!=null && leaguename!="") arg2 += "&leaguename="+leaguename;
	}
	if(arg2=="clubnameB"){
		var leaguename = document.getElementById("leaguenameBrec").value;
		var season = document.getElementById("seasonBrec").value;
		if(season!=null && season!="") arg2 += "&season="+season;
		if(leaguename!=null && leaguename!="") arg2 += "&leaguename="+leaguename;
	}
	if(arg2=="clubnameRA" || arg2=="clubnameRB"){
		var leaguename = document.getElementById("leaguenamerec").value;
		var season = document.getElementById("seasonrec").value;
		if(season!=null && season!="") arg2 += "&season="+season;
		if(leaguename!=null && leaguename!="") arg2 += "&leaguename="+leaguename;
	}
	if(arg2.substr(0,9)=="regnumber"){
		createCookie("currentobj",arg2,false);
		if(arg5=="host") var clubname = readCookie('hosteam');
		if(arg5=="visit") var clubname = readCookie('visiteam');
		if(arg5=="club") var clubname = document.getElementById("clubname").value;
		var leaguename = document.getElementById("leaguenamerec").value;
		var season = document.getElementById("seasonrec").value;
		if(season!=null && season!="") arg2 += "&season="+season;
		if(leaguename!=null && leaguename!="") arg2 += "&leaguename="+leaguename;
		if(clubname!=null && clubname!="") arg2 += "&clubname="+clubname;
		
	}
	createCookie("tablename",arg3,false);
    var url = "/nigeriapremierleague/databackend.php?option=getRecordlist&table="+arg3+"&currentobject="+arg2;
//alert(url);	
	AjaxFunctionSetup(url);
}

function populateCode(code,arg2){
    curr_obj.value = code.replace(/#/g,' ');
    clearLists(list_obj);
//alert(readCookie("tablename"));	
	if(readCookie("tablename")=="leaguetype")
		document.getElementById("leaguenamerec").value=arg2;
	if(readCookie("tablename")=="seasonstable")
		document.getElementById("seasonrec").value=arg2;
	if(readCookie("tablename")=="clubstable")
		document.getElementById("clubnamerec").value=arg2;
	if(readCookie("tablename")=="leaguetypeB")
		document.getElementById("leaguenameBrec").value=arg2;
	if(readCookie("tablename")=="seasonstableB")
		document.getElementById("seasonBrec").value=arg2;
	if(readCookie("tablename")=="clubstableB")
		document.getElementById("clubnameBrec").value=arg2;
	if(readCookie("tablename")=="playerstable"){
		var key = readCookie("currentobj").substr(9,readCookie("currentobj").length);
		var playerid = "playerid"+key;
		document.getElementById(playerid).value=arg2.replace(/#/g,' ');
	}
	createCookie("tablename",null,false);
}

function clearLists(arg){
    if(arg==null) arg=list_obj;
    document.getElementById(arg).innerHTML = "";
}

function resetForm(table){
	if(table=="seasonstable"){
		document.getElementById("leaguename").value=""
		document.getElementById("season").value="";
		document.getElementById("winning").value="";
		document.getElementById("goalsdraw").value="";
		document.getElementById("goallessdraw").value="";
    }
	if(table=="leaguetype"){
		document.getElementById("leaguename").value="";
	}
}

var xmlhttp

function AjaxFunctionSetup(arg){
    xmlhttp=GetXmlHttpObject();
    if(xmlhttp == null){
        alert ("Your browser does not support XMLHTTP!");
        return true;
    }

    var timestamp = new Date().getTime();
    var url = arg+"&timestamp="+timestamp;

    xmlhttp.onreadystatechange=stateChangedSetup;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}

var temp_resp="";
function stateChangedSetup(){
    if (xmlhttp.readyState==4){
        var resp = xmlhttp.responseText;
        var break_resp = "";
        $('#showAlert').dialog('close');
        /*if(resp.match("copyClubs")){
			alert(resp);
		}
        if(resp.match("copyPlayers")){
			alert(resp);
		}*/
        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
				window.location="home.php?pgid=1";
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "<b>Access Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
                document.getElementById("showPrompt").innerHTML = resp;
                $('#showPrompt').dialog('open');
            }
        }

        if(resp.match("locknotallowed")){
			break_resp = resp.split("locknotallowed");
			resp = "<b>Lock Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
			document.getElementById("showPrompt").innerHTML = resp;
			$('#showPrompt').dialog('open');
			getRecords("matchestable","1");
        }

        if(resp.match("getAllRecs")){
                //document.getElementById("showPrompt").innerHTML = readCookie('myquery');
                //$('#showPrompt').dialog('open');
//alert(resp);
            break_resp = resp.split("getAllRecs");
            var allrecords = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:95%;background-color:#009933;margin-top:5px;'>";
            allrecords += "<tr style='font-weight:bold; color:white'>";
			if(break_resp[0]=="seasonstable"){
                allrecords += "<td>S/No</td><td>League Name</td><td>Seasons</td><td align='center'>Winning Point</td><td align='center'>Goals Draw Point</td><td align='center'>Goalless Draw Point</td></tr>";
            }else if(break_resp[0]=="leaguetype"){
                allrecords += "<td width='5%'>S/No</td><td>League Name</td></tr>";
            }else if(break_resp[0]=="clubstable"){
				populateClubs(resp);
				return true;
            }else if(break_resp[0]=="clubstableB"){
				populateCopyClubs(resp);
				return true;
            }else if(break_resp[0]=="playerstable"){
				populatePlayers(resp);
				return true;
            }else if(break_resp[0]=="playerstableB"){
				populateCopyPlayers(resp);
				return true;
            }else if(break_resp[0]=="fixturestable"){
				populateFixtures(resp);
				return true;
            }else if(break_resp[0]=="matchestable"){
				populateMatches(resp);
				return true;
            }else if(break_resp[0]=="goalstable"){
				populateGoals(resp);
				return true;
            }
            var recordlist = null;
            if(break_resp[0]=="seasonstable") recordlist = document.getElementById('seasonslist');
            if(break_resp[0]=="leaguetype") recordlist = document.getElementById('leaguetypeslist');
            var counter = 0;
            var rsp = "";
            var flg = 0;
            var break_row = "";
            var compare1 = "seasonstable";
            var compare2 = "seasonstable";
            var compare3 = "seasonstable";
            for(var i=1; i < (break_resp.length-1); i++){
                break_row = break_resp[i].split("_~_");

                if (flg == 1) {
                    flg = 0;
                    rsp += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
                } else {
                    flg = 1;
                    rsp += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
				}
				rsp += "<td align='right'>" + (++counter) + ".</td>";
				if(break_resp[0]=="seasonstable"){
					rsp += "<td>" + break_row[6] + "</td>";
				}else{
					rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
				}
				if(break_resp[0]=="seasonstable"){
					rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[2] + "</a></td>";
				}else if(break_resp[0]=="leaguetype"){
				}else{
					rsp += "<td>" + break_row[2] + "</td>";
				}
				if(compare1.match(break_resp[0])){
					if(break_resp[0]=="seasonstable"){
						rsp += "<td align='center'>" + break_row[3] + "</td>";
					}else{
						rsp += "<td>" + break_row[3] + "</td>";
					}
				}
				if(compare2.match(break_resp[0])){
					if(break_resp[0]=="seasonstable"){
						rsp += "<td align='center'>" + break_row[4] + "</td>";
					}else{
						rsp += "<td>" + break_row[4] + "</td>";
					}
				}
				if(compare3.match(break_resp[0])){
					if(break_resp[0]=="seasonstable"){
						rsp += "<td align='center'>" + break_row[5] + "</td>";
					}else{
						rsp += "<td>" + break_row[5] + "</td>";
					}
				}
				rsp += "</tr>";
            }
			recordlist.innerHTML = allrecords+rsp+"</table>";
        }

        if(resp.match("getRecordlist")){
//alert(resp);
            var keyword = curr_obj.value;
            var allCodes = resp.split("getRecordlist");
            var inner_codeslist = "";
            if(navigator.appName == "Microsoft Internet Explorer"){
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:60%;background-color:#009933;margin-top:5px;'>";
            }else{
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#009933;margin-top:5px;'>";
            }
            inner_codeslist += "<tr style='font-weight:bold; color:white'>";
            inner_codeslist += "<td colspan='3' align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href='javascript:clearLists()'>X</a></td></tr>";

            var codeslist = document.getElementById(list_obj);
            codeslist.style.zIndex = 100;
            codeslist.style.position = "absolute";

            codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
            codeslist.style.left = ($(curr_obj).position().left) + 'px';

            var token = "";
            var tokensent = "";
            counter = 1;
            var colorflag = 0;
            var k=0;

            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    //if(curr_obj.id=='lecturerid' && !allCodes[k].match("Staff")) continue;
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
						if(readCookie("tablename")=="playerstable"){
	                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"','"+token[2].replace(/ /g,"#")+"')>"+token[1]+"</a></td>";
						}else{
							inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+token[0].replace(/ /g,"#")+"','"+token[1]+"')>"+token[0]+"</a></td>";
						}
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    //if(curr_obj.id=='lecturerid' && !allCodes[k].match("Staff")) continue;
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
						if(readCookie("tablename")=="playerstable"){
	                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"','"+token[2].replace(/ /g,"#")+"')>"+token[1]+"</a></td>";
						}else{
	                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+token[0].replace(/ /g,"#")+"','"+token[1]+"')>"+token[0]+"</a></td>";
						}
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            }
            inner_codeslist += "</table>";
            codeslist.style.zIndex = 100;
            codeslist.innerHTML = "";
            codeslist.innerHTML = inner_codeslist;
            return true;
        }

        if(resp.match("getARecord")){
           break_resp = resp.split("getARecord");
            createCookie("serialno",break_resp[1],false)
            var selectoption = null;
            if(break_resp[0]=="seasonstable"){
                document.getElementById("leaguenamerec").value = break_resp[2];
                document.getElementById("leaguename").value = break_resp[7];
                document.getElementById("season").value = break_resp[3];
                document.getElementById("winning").value = break_resp[4];
                document.getElementById("goalsdraw").value = break_resp[5];
                document.getElementById("goallessdraw").value = break_resp[6];
            }
            if(break_resp[0]=="matchestable"){
                document.getElementById("official").value = break_resp[11];
                document.getElementById("report").value = break_resp[12];
                document.getElementById("spectator").value = comaSeparated(break_resp[13]);
				document.getElementById("commissioner").value = break_resp[15];
				document.getElementById("report2").value = break_resp[16];
				var season = document.getElementById("seasonA").value;
				var leaguename = document.getElementById("leaguenameA").value;
				var matchno = document.getElementById("matchnoA").value;
				var week = document.getElementById("weekA").value;
				var param = "&season="+season+"&leaguename="+leaguename+"&matchno="+matchno+"&week="+week;
				var url = "/nigeriapremierleague/databackend.php?option=getAllRecs&table=matchestable"+param;
				AjaxFunctionSetup(url);
            }
            if(break_resp[0]=="leaguetype"){
                document.getElementById("leaguename").value = break_resp[2];
            }
            if(break_resp[0]=="sessionstable"){
                document.getElementById("sessiondescription").value= break_resp[2];
                document.getElementById("semesterdescription").value= break_resp[3];
                document.getElementById("semesterstartdate").value= break_resp[4];
                document.getElementById("semesterenddate").value= break_resp[5];
                document.getElementById("currentperiod").value= break_resp[6];
                selectoption = document.getElementById("currentperiod");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[6]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                /*var selectoption = document.getElementById("currentperiod");
                if(break_resp[6] == 'Yes'){
                    selectoption.selectedIndex = 2;
                }else if(break_resp[6] == 'No'){
                    selectoption.selectedIndex = 1;
                }else{
                    selectoption.selectedIndex = 0;
                }*/
            }
            return true;
        }

        if(resp.match("inserted")){
            break_resp = resp.split("inserted");
			if(break_resp[0]=="clubstable"){
				var sortby=readCookie("sortby");
				populateClub(sortby,'ASC');
				return true;
			}else if(break_resp[0]=="playerstable"){
				var sortby=readCookie("sortby");
				populatePlayer(sortby,'ASC');
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("updated")){
            break_resp = resp.split("updated");
			if(break_resp[0]=="clubstable"){
				var sortby=readCookie("sortby");
				populateClub(sortby,'ASC');
				return true;
			}else if(break_resp[0]=="playerstable"){
				var sortby=readCookie("sortby");
				populatePlayer(sortby,'ASC');
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("deleted")){
            break_resp = resp.split("deleted");
			if(break_resp[0]=="clubstable"){
				var sortby=readCookie("sortby");
				populateClub(sortby,'ASC');
				return true;
			}else if(break_resp[0]=="playerstable"){
				var sortby=readCookie("sortby");
				populatePlayer(sortby,'ASC');
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("exists_in")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Recode Exists!!!</b><br><br>The "+resp+".";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordexists")){
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The record already exists.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordused")){
            document.getElementById("showError").innerHTML = "<b>Record Used!!!</b><br><br>The record has been used in another table.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordnotexist")){
            document.getElementById("showError").innerHTML = "<b>Record Not Existing!!!</b><br><br>The record does not exist.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("noclubs4fixture")){
            document.getElementById("showError").innerHTML = "<b>Clubs Not Created!!!</b><br><br>No records of clubs exist for the Specified season and league name.";
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("oddnoofclubs")){
            document.getElementById("showError").innerHTML = "<b>Odd No of Clubs!!!</b><br><br>The number of clubs must be even.";
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("clubranknotserial")){
            document.getElementById("showError").innerHTML = "<b>Non Serial Club Positions!!!</b><br><br>The club positions must be serialy numbered.";
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("logoutUser")){
			window.location = "login.php";
		}
    }
}

function GetXmlHttpObject(){
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }

    if (window.ActiveXObject){
        // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
