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
		<script type="text/javascript" src="js/users.js"></script>
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

                $("#changepass").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Change Users Password',
                    height: 440,
                    width: 700,
                    modal: false,
                    buttons: {
                        Change_Password: function() {
                            var reg = changePass();
                            if(reg.length>0){
                                $('#showAlert').dialog('close');
                                document.getElementById("showError").innerHTML = reg;
                                $('#showError').dialog('open');
                            }
                        },
                        Clear: function() {
                            clearPassForm();
                        },
                        Close: function() {
                            $('#changepass').dialog('close');
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
                    <div style="font-size:65%; height:235px; width:415px; top:5px; left:10px" id="changepass">
						<table style="width:550px;">
							<tr class="formLabel">
								<td width="30%"><b>User Name:</b></td>
								<!-- UserName -->
								<td width="70%" class="input">
									<input type="text" id="username2" name="username2" size="27" disabled="true" readonly class="textField" />
								</td>
							</tr>

							<tr class="formLabel">
								<td width="30%"><b>First Name:</b></td>
								<!-- FirstName -->
								<td width="70%" class="input">
									<input type="text" id="firstname2" name="firstname2" disabled="true" readonly size="20" />
								</td>
							</tr>

							<tr class="formLabel">
								<td width="30%"><b>Last Name:</b></td>
								<!-- LastName -->
								<td width="70%" class="input">
									<input type="text" id="lastname2" name="lastname2" disabled="true" readonly size="20" />
								</td>
							</tr>

							<tr class="formLabel">
								<td width="30%"><b>Old Password:</b></td>
								<!-- Password -->
								<td width="70%" class="input">
									<input type="password" id="password" name="password" size="20" maxlength=20 class="textField" />
								</td>
							</tr>
							<tr class="formLabel">
								<td width="30%"><b>New Password:</b></td>
								<!-- Password -->
								<td width="70%" class="input">
									<input type="password" id="newpassword" name="newpassword" size="20" maxlength=20 class="textField" />
								</td>
							</tr>
							<tr class="formLabel">
								<td width="30%"><b>Repeat New Password:</b></td>
								<!-- Password -->
								<td width="70%" class="input">
									<input type="password" id="rptpassword" name="rptpassword" size="20" maxlength=20 onkeypress="checkEnter(event)" class="textField" />
								</td>
							</tr>
						</table>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	getPassword();
</script>