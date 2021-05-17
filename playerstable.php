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

                $("#playerstable").dialog({
                    autoOpen: true,
                    position:[500,220],
                    title: 'Players Setup',
                    height: 460,
                    width: 1200,
                    modal: false,
                    buttons: {
                        Copy_From_Previous_Season: function() {
                            CopyFromPreviousSeasonB();
                        },
                        Close: function() {
                            $('#playerstable').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#copyplayerstable").dialog({
                    autoOpen: false,
                    position:[180,170],
                    title: 'Copy Players',
                    height: 460,
                    width: 1100,
                    modal: false,
                    buttons: {
                        Paste_To_Current_Season: function() {
                            PasteToCurrentSeasonB();
                        },
                        Close: function() {
                            $('#copyplayerstable').dialog('close');
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

			var theholder=null;
            function browseFiles(id,serialno){
				createCookie("serialno",serialno,false);
				theholder=id;
                var txtFile = document.getElementById("txtFile");
                txtFile.click();
            }

			function submitForm(){
                var submitButton = document.getElementById("submitButton");
                submitButton.click();
			}
			
			function startUpload(id){
				var filename = document.getElementById('txtFile').value;
				var filenames = filename.split("\\");
				var theImage = filenames[filenames.length-1];
				theImage = theImage.replace(/ /g,'_');
				createCookie("theImage",theImage,false);
				document.getElementById('f1_upload_process').style.visibility = 'visible';
				document.getElementById('f1_upload_form').style.visibility = 'hidden';
				//document.getElementById(id).style.visibility = 'hidden';
				//document.getElementById('f1_uploaded_file').style.visibility = 'hidden';
			}

			function stopUpload(success){
				var result = '';
				if(success == 1){
					result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
					//alert("The file was uploaded successfully!");
				}else {
					createCookie("theImage",null,false);
					result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
					alert("There was an error during file upload!");
				}
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
				//var theImage = readCookie("theImage");
				//theImage = theImage.replace(/_/g,' ');
				//document.getElementById(theholder).innerHTML = "<img src='photo/"+theImage+"'  border='1' width='50' height='50' title='Picture' alt='Applicant`s Passport'/>";
				//document.getElementById('f1_upload_form').style.visibility = 'visible';      
				//document.getElementById(thebutton).style.visibility = 'visible';      
				//document.getElementById('f1_uploaded_file').style.visibility = 'visible';      
				populatePlayer('regnumber','ASC');
				return true;   
			}

			function loadImage(imageID){
				document.getElementById('f1_uploaded_file').innerHTML = "<img src='photo/"+imageID+"'  border='1' width='150' height='150' title='Picture' alt='Applicant`s Passport'/>";
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
					<form action="uploadfile.php?ftype=pic" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
						<div id="f1_upload_form" style="font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; color: #666666; height:100px;" align="center"><br/>
							<div style="visibility: hidden">
								<input type="file" name="txtFile" id="txtFile" onchange="javascript:submitForm();" />
								<INPUT type="submit" id="submitButton" value="Submit" name="submitButton" />
							</div>
							<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;"></iframe>
						</div>
					</form>
                    <div style="font-size: 11px; " id="playerstable">
						<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:400px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
						<table>
							<tr>
								<td width='10%' align="right"><b>League:</b></td>
								<td width='20%'>
									<input type="text" id="leaguename" size="40" onkeyup="getRecordlist(this.id,'leaguetype','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'leaguetype','recordlist1');" />
									<input type="hidden" id="leaguenamerec" />
								</td>
								<td width='10%' align="right"><b>Season:</b></td>
								<td width='20%'>
									<input type="text" id="season" size="15" onkeyup="getRecordlist(this.id,'seasonstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'seasonstable','recordlist1');" />
									<input type="hidden" id="seasonrec" />
								</td>
								<td width='10%' align="right"><b>Club:</b></td>
								<td width='30%'>
									<input type="text" id="clubname" size="20" style="display:inline" onkeyup="getRecordlist(this.id,'clubstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'clubstable','recordlist1');" />
									&nbsp;&nbsp;<input type="button" style="display:inline" id="populateplayers" onclick="populatePlayer('regnumber','ASC')" value=" List Players " />
									<input type="hidden" id="clubnamerec" />
								</td>
							</tr>
							<tr>
								<td colspan="6">
									<div id="playerslist" style="max-height:310px; max-width:1150px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist1" style="max-height:250px; width:150px; overflow:auto;"></div>
					</div>

                    <div style="font-size: 11px; " id="copyplayerstable">
						<table>
							<tr>
								<td width='10%' align="right"><b>League:</b></td>
								<td width='20%'>
									<input type="text" id="leaguenameB" size="40" onkeyup="getRecordlist(this.id,'leaguetypeB','recordlist1B');" onclick="this.value=''; getRecordlist(this.id,'leaguetypeB','recordlist1B');" />
									<input type="hidden" id="leaguenameBrec" />
								</td>
								<td width='10%' align="right"><b>Season:</b></td>
								<td width='20%'>
									<input type="text" id="seasonB" size="15" onkeyup="getRecordlist(this.id,'seasonstableB','recordlist1B');" onclick="this.value=''; getRecordlist(this.id,'seasonstableB','recordlist1B');" />
									<input type="hidden" id="seasonBrec" />
								</td>
								<td width='10%' align="right"><b>Club:</b></td>
								<td width='30%'>
									<input type="text" id="clubnameB" size="20" style="display:inline" onkeyup="getRecordlist(this.id,'clubstableB','recordlist1B');" onclick="this.value=''; getRecordlist(this.id,'clubstableB','recordlist1B');" />
									&nbsp;&nbsp;<input type="button" style="display:inline" id="populateplayersB" onclick="populateCopyPlayer('playername','ASC')" value="List Players" />
									<input type="hidden" id="clubnameBrec" />
								</td>
							</tr>
							<tr>
								<td colspan="6">
									<div id="playerslistB" style="max-height:310px;  max-width:1150px; overflow:auto;"></div>
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
	//getRecords('playerstable');
</script>