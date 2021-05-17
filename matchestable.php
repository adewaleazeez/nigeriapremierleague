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

                $("#matchestable").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Matches Update',
                    height: 480,
                    width: 1050,
                    modal: false,
                    buttons: {
                        Delete: function() {
                            deleteMatches();
                        },
                        Close: function() {
                            $('#matchestable').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#goalstable").dialog({
                    autoOpen: false,
                    position:[50,50],
                    title: 'Goals, Cautions & Expulsions Update',
                    height: 550,
                    width: 1200,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#goalstable').dialog('close');
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
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size: 11px; " id="matchestable">
						<table width='100%'>
							<tr>
								<td align="right"><b>League:</b></td>
								<td>
									<input type="text" id="leaguename" size="40" onkeyup="getRecordlist(this.id,'leaguetype','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'leaguetype','recordlist1');" />
									<input type="hidden" id="leaguenamerec" />
								</td>
								<td align="right"><b>Season:</b></td>
								<td>
									<input type="text" id="season" size="15" onkeyup="getRecordlist(this.id,'seasonstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'seasonstable','recordlist1');" />
									<input type="hidden" id="seasonrec" />
								</td>
								<td align="right"><b>Week:</b></td>
								<td>
									<input type="text" id="week" size="10" style="text-align: center;" onkeyup="getRecordlist(this.id,'matchestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'matchestable','recordlist1');" />
								</td>
								<td align="right">
									<input type="button" style="display:inline" id="populateclubs" onclick="populateMatch('weeks','ASC','generate')" value="Generate Matches" />
								</td>
								<td align="right">
									<input type="button" style="display:inline" id="populateclubs" onclick="populateMatch('weeks','ASC','populate')" value="List Matches" />
								</td>
							</tr>
							<tr>
								<td colspan="8">
									<div id="matcheslist" style="max-height:330px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist1" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>
                    <div style="font-size: 11px; " id="goalstable">
						<table width='100%'>
							<tr>
								<td><b>League</b></td>
								<td><b>Season</b></td>
								<td align="center"><b>Week</b></td>
								<td align="center"><b>Match No</b></td>
								<td align="center"><b>Match Date</b></td>
								<td align="center"><b>Kickoff Time</b></td>
								<td align="center"><b>Attendance</b></td>
							</tr>
							<tr>
								<td>
									<input type="text" id="leaguenameA" size="40" disabled='true' />
								</td>
								<td>
									<input type="text" id="seasonA" size="20" disabled='true' />
								</td>
								<td align="center">
									<input type="text" style="text-align: center;" id="weekA" size="10" disabled='true' />
								</td>
								<td align="center">
									<input type="text" style="text-align: center;" id="matchnoA" size="10" disabled='true' />
								</td>
								<td align="center">
									<input type="text" style="text-align: center;" id="matchdateA" size="20" disabled='true' />
								</td>
								<td align="center">
									<input type="text" style="text-align: center;" id="kickoffA" size="20" disabled='true' />
								</td>
								<td align="center">
									<input type="text" id="spectator" style="text-align: right;" onkeyup='this.value=comaSeparated(this.value)' onblur='this.value=comaSeparated(this.value)' size="10" />
								</td>
							</tr>
							<tr>
								<td colspan='7'>
									<table>
										<tr>
											<td>
												<b>Match Referee</b><br>
												<input type="text" id="official" onblur='this.value=capitalize(this.value)' size="30" />
											</td>
											<td>
												<b>Match Referee's Report</b><br>
												<textarea id="report" rows="3" cols="60" ></textarea>
											</td>
											<td>
												<b>Match Commissioner</b><br>
												<input type="text" id="commissioner" onblur='this.value=capitalize(this.value)' size="30" />
											</td>
											<td>
												<b>Match Commissioner's Report</b><br>
												<textarea id="report2" rows="3" cols="70" ></textarea>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan='7'>
									<table>
										<tr>
											<td>
												<div id="hostlist" style="max-height:290px; max-width:560px; overflow:auto;"></div>
											</td>
											<td>
												<div id="visitorlist" style="max-height:290px; max-width:560px; overflow:auto;"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<div id="recordlist2" style="max-height:250px; max-width:350px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	//getRecords('clubstable');
</script>