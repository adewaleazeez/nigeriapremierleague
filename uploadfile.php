<?php
	$results = 0;

	$currentusers = $_COOKIE['currentuser'];
	$ftype = $_GET['ftype'];
	include("data.php");
					//$query = "INSERT INTO activities (userEmail, descriptions, activityDate, activityTime) VALUES ('{$currentusers}', '{$_FILES['txtFile']['type']}', '{$ftype}', '{$results}')";
					//mysql_query($query, $connection);

	//if(ereg("application/vnd.ms-excel", $_FILES['txtFile']['type']) || ereg("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", $_FILES['txtFile']['type'])) {
	//if(str_in_str($_FILES['txtFile']['type'], "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || str_in_str($_FILES['txtFile']['type'], "application/vnd.ms-excel") ){
	$target_path = "";
	if($ftype=="pic"){
		$target_path = "photo/" . basename( $_FILES['txtFile']['name']);
		$filename=$_FILES['txtFile']['name'];
		$serialno=$_COOKIE['serialno'];
		if(@move_uploaded_file($_FILES['txtFile']['tmp_name'], $target_path)) {
			$results = 1;
			$query="update playerstable set playerPicture='{$filename}' where serialno='{$serialno}'";
			$result = mysql_query($query, $connection);
		}
	}


?>
<script language="javascript" type="text/javascript">
	window.top.window.stopUpload(<?php echo $results; ?>);
</script>
