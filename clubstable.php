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

                $("#clubstable").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Clubs Setup',
                    height: 480,
                    width: 1200,
                    modal: false,
                    buttons: {
                        Copy_From_Previous_Season: function() {
                            CopyFromPreviousSeason();
                        },
                        Close: function() {
                            $('#clubstable').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#copyclubstable").dialog({
                    autoOpen: false,
                    position:[180,150],
                    title: 'Copy Clubs',
                    height: 480,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Paste_To_Current_Season: function() {
                            PasteToCurrentSeason();
                        },
                        Close: function() {
                            $('#copyclubstable').dialog('close');
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
                    <div style="font-size: 11px; " id="clubstable">
						<table>
							<tr>
								<td width='10%' align="right"><b>League:</b></td>
								<td width='30%'>
									<input type="text" id="leaguename" size="40" style="display:inline" onkeyup="getRecordlist(this.id,'leaguetype','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'leaguetype','recordlist1');" />
									<input type="hidden" id="leaguenamerec" />
								</td>
								<td width='10%' align="right"><b>Season:</b></td>
								<td width='30%'>
									<input type="text" id="season" size="15" onkeyup="getRecordlist(this.id,'seasonstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'seasonstable','recordlist1');" />
									<input type="hidden" id="seasonrec" />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" style="display:inline" id="populateclubs" onclick="populateClub('clubname','ASC')" value="List Clubs" />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="clubslist" style="max-height:320px; max-width:1150px;  overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist1" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>

                    <div style="font-size: 11px; " id="copyclubstable">
						<table>
							<tr>
								<td width='10%' align="right"><b>League:</b></td>
								<td width='20%'>
									<input type="text" id="leaguenameB" size="40" style="display:inline" onkeyup="getRecordlist(this.id,'leaguetypeB','recordlist1B');" onclick="this.value=''; getRecordlist(this.id,'leaguetypeB','recordlist1B');" />
									<input type="hidden" id="leaguenameBrec" />
								</td>
								<td width='10%' align="right"><b>Season:</b></td>
								<td width='20%'>
									<input type="text" id="seasonB" size="15" onkeyup="getRecordlist(this.id,'seasonstableB','recordlist1B');" onclick="this.value=''; getRecordlist(this.id,'seasonstableB','recordlist1B');" />
									<input type="hidden" id="seasonBrec" />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" style="display:inline" id="populateclubsB" onclick="populateCopyClub('clubname')" value="List Clubs" />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="clubslistB" style="max-height:320px; max-width:1150px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdivB"></div>
						<div id="recordlist1B" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	//getRecords('clubstable');
</script>