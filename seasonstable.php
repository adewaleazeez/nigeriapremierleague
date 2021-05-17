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

                $("#point").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Seasons Setup',
                    height: 440,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateSeason("addRecord", "seasonstable");
                        },
                        Delete: function() {
                            updateSeason("deleteRecord", "seasonstable");
                        },
                        Update: function() {
                            updateSeason("updateRecord", "seasonstable");
                        },
                        New: function() {
                            resetForm("seasonstable");
                        },
                        Close: function() {
                            $('#point').dialog('close');
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
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size: 13px; " id="point">
						<table>
							<tr>
								<td width='6%'>&nbsp;</td>
								<td><b>League Name:</b></td>
								<td><b>Season:</b></td>
								<td><b>Winning Point:</b></td>
								<td><b>Goals Draw Point:</b></td>
								<td><b>Goalless Draw Point:</b></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="text" id="leaguename" size="40" onkeyup="getRecordlist(this.id,'leaguetype','recordlist1');" onfocus="getRecordlist(this.id,'leaguetype','recordlist1');" />
									<input type="hidden" id="leaguenamerec" />
								</td>
								<td>
									<input type="text" id="season" name="season" size="10" />
								</td>
								<td>
									<input type="text" style="text-align: center;" id="winning" name="winning" size="15" />
								</td>
								<td>
									<input type="text" style="text-align: center;" id="goalsdraw" name="goalsdraw" size="17" />
								</td>
								<td>
									<input type="text" style="text-align: center;" id="goallessdraw" name="goallessdraw" size="25" />
								</td>
							</tr>
						</table>
						<div id="seasonslist" style="height:270px; max-width:850px; overflow:auto;"></div>
						<div id="recordlist1" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	getRecords('seasonstable');
</script>