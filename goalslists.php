<!-- 
    Document   : login
    Created on : 28-Feb-2011
    Author     : Adewale Azeez
-->

<!--@page contentType="text/html" pageEncoding="UTF-8"-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Nigeria Professional Football League Portal Systems</title>
		<!-- DEMO styles - specific to this page -->
		<link rel="stylesheet" type="text/css" href="css/complex.css" />
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <link href="css/calendar.css" rel="stylesheet" type="text/css"/>
		<!--[if lte IE 7]>
			<style type="text/css"> body { font-size: 85%; } </style>
		<![endif]-->

        <script type="text/javascript" src="js/calendar.js"></script>
		<script type="text/javascript" src="js/jquery-ui-latest.js"></script>
		<script type="text/javascript" src="js/jquery.layout-latest.js"></script>
		<script type="text/javascript" src="js/complex.js"></script>
		<script type="text/javascript" src="js/setup.js"></script>
		<script type="text/javascript" src="js/utilities.js"></script>

		<script language="javascript" src="js/jquery.marquee.js"></script>

		<link href="css/mycss.css" rel="stylesheet" type="text/css"/>
		<link href="css/westmart.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript">
            checkLogin();
        </script>
        <script type="text/javascript">
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#goalslists").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Goals, Caution & Expulsion Report',
                    height: 440,
                    width: 900,
                    modal: false,
                    buttons: {
                        PDF: function() {
                            doGoalsListsReport();
                        },
                        Close: function() {
                            $('#goalslists').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#showPrompt").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 300,
                    width: 300,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showPrompt').dialog('close');
                        }
                    }
                });

                $("#showAlert").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 280,
                    width: 350,
                    modal: true
                });

                $("#showError").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Error Message',
                    height: 300,
                    width: 300,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showError').dialog('close');
                        }
                    }
                });

            });

			function doOption(){
				var selectoption = document.getElementById("reportoption");
				var reportoption = selectoption.options[selectoption.selectedIndex].text;
				if(reportoption=="Goals"){
					var str ="<select id='reportype'><option>List by No of Goals</option><option>List by Time of Goals</option>";
					str +="<option>List by Weeks</option><option>List by Clubs</option></select>";
					document.getElementById("repotype").innerHTML=str;
				}else if(reportoption=="Cautions"){
					var str ="<select id='reportype'><option>List by No of Cautions</option><option>List by Time of Cautions</option>";
					str +="<option>List by Weeks</option><option>List by Clubs</option></select>";
					document.getElementById("repotype").innerHTML=str;
				}else if(reportoption=="Expulsions"){
					var	str ="<select id='reportype'><option>List by No of Expulsions</option><option>List by Time of Expulsions</option>";
					str +="<option>List by Weeks</option><option>List by Clubs</option></select>";
					document.getElementById("repotype").innerHTML=str;
				}else{
					document.getElementById("repotype").innerHTML="";
				}
			}
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size:65%; height:235px; top:5px; left:10px" id="goalslists">
						<table>
							<tr>
								<td align="right"><b>League Name:</b></td>
								<td>
									<input type="text" id="leaguename" size="40" onkeyup="getRecordlist(this.id,'leaguetype','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'leaguetype','recordlist1');" />
									<input type="hidden" id="leaguenamerec" />
								</td>
								<td align="right"><b>Season:</b></td>
								<td>
									<input type="text" id="season" size="15" onkeyup="getRecordlist(this.id,'seasonstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'seasonstable','recordlist1');" />
									<input type="hidden" id="seasonrec" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Start Match Week:</b></td>
								<td>
									<input type="text" id="weekA" size="10" style="text-align: center;" onkeyup="getRecordlist(this.id,'matchestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'matchestable','recordlist1');" />
								</td>
								<td align="right"><b>End Match Week:</b></td>
								<td>
									<input type="text" id="weekB" size="10" style="text-align: center;" onkeyup="getRecordlist(this.id,'matchestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'matchestable','recordlist1');" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Club Name:</b></td>
								<td>
									<input type="text" id="clubname" size="20" style="display:inline" onkeyup="getRecordlist(this.id,'clubstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'clubstable','recordlist1');" />
									<input type="hidden" id="clubnamerec" />
								</td>
								<td align="right"><b>Report_Option:</b></td>
								<td>
									<select id="reportoption" onchange="doOption();">
										<option>Select an Option.....</option>
										<option>Goals</option>
										<option>Cautions</option>
										<option>Expulsions</option>
									</select>
								</td>
								<td align='right'><b>Report_Type:</b></td>
								<td><div id='repotype'></div></td>
							</tr>
						</table>
						<div id="recordlist1" style="max-height:230px; width:150px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
