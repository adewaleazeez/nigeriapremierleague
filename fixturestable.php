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

                $("#fixturestable").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Fixtures Generation',
                    height: 500,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Delete: function() {
                            deleteFixtures();
                        },
                        Close: function() {
                            $('#fixturestable').dialog('close');
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
                    <div style="font-size:65%; height:235px; width:100%; top:5px; left:10px" id="fixturestable">
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
									<input type="text" id="week" size="10" style="text-align: center;" onkeyup="getRecordlist(this.id,'fixturestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'fixturestable','recordlist1');" />
								</td>
								<td align="right">
									<input type="button" style="display:inline" id="generateclubs" onclick="populateFixture('weeks','ASC','generate')" value="Generate Fixtures" />
								</td>
								<td align="right">
									<input type="button" style="display:inline" id="populateclubs" onclick="populateFixture('weeks','ASC','populate')" value="List Fixtures" />
								</td>
							</tr>
							<tr>
								<td colspan="9">
									<div id="fixtureslist" style="max-height:380px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist1" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	//getRecords('clubstable');
</script>