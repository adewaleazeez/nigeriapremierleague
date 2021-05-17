<?php
 
$dataPoints = array(
	array("label"=> "Education", "y"=> 284935),
	array("label"=> "Entertainment", "y"=> 256548),
	array("label"=> "Lifestyle", "y"=> 245214),
	array("label"=> "Business", "y"=> 233464),
	array("label"=> "Music & Audio", "y"=> 200285),
	array("label"=> "Personalization", "y"=> 194422),
	array("label"=> "Tools", "y"=> 180337),
	array("label"=> "Books & Reference", "y"=> 172340),
	array("label"=> "Travel & Local", "y"=> 118187),
	array("label"=> "Puzzle", "y"=> 107530)
);
	
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
	var chart1 = new CanvasJS.Chart("chartContainer1", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Top 10 Google Play Categories - till 2017"
		},
		axisY: {
			title: "Number of Apps"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart1.render();
 
	var chart2 = new CanvasJS.Chart("chartContainer2", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Top 10 Google Play Categories - till 2017"
		},
		axisY: {
			title: "Number of Apps"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart2.render();
}

</script>
</head>
<body>
<div id="chartContainer1" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
<?php
	/*$leaguenames = trim($_GET['leaguename']);
	if($leaguenames == null) $leaguenames = "";

	$seasons = trim($_GET['season']);
	if($seasons == null) $seasons = "";

	$matchdateA = trim($_GET['matchdateA']);
	if($matchdateA == null){
		$matchdateA = "";
	}else{
		$matchdateA = substr($matchdateA,6,4)."-".substr($matchdateA,3,2)."-".substr($matchdateA,0,2);
	}

	$matchdateB = trim($_GET['matchdateB']);
	if($matchdateB == null){
		$matchdateB = "";
	}else{
		$matchdateB = substr($matchdateB,6,4)."-".substr($matchdateB,3,2)."-".substr($matchdateB,0,2);
	}

	$weekA = trim($_GET['weekA']);
	if($weekA == null) $weekA = "";
	
	$weekB = trim($_GET['weekB']);
	if($weekB == null) $weekB = "";

	$clubnameA = trim($_GET['clubnameA']);
	if($clubnameA == null) $clubnameA = "";

	$clubnameB = trim($_GET['clubnameB']);
	if($clubnameB == null) $clubnameB = "";

	include("../FusionCharts/Includes/FusionCharts.php");
	include("data.php"); 
	
	$currentuser = $_COOKIE['currentuser'];
	$query .= "delete from leaguetable where username='{$currentuser}'";
	mysql_query($query, $connection);

	$queryA = "SELECT distinct clubname FROM clubstable where clubname<>'' ";
	if($clubnameA != "") $queryA .= " and clubname='{$clubnameA}' "; 
	if($clubnameB != "") $queryA .= " or clubname='{$clubnameB}' "; 
	if($seasons != "") $queryA .= " and season='{$seasons}' "; 
	if($leaguenames != "") $queryA .= " and leaguename='{$leaguenames}' "; 
	$queryA .= " order by clubname";
	$resultA = mysql_query($queryA, $connection);
	if(mysql_num_rows($resultA) > 0){
		while ($rowA = mysql_fetch_array($resultA)) {
			extract ($rowA);

			$query = "select count(*) as homeplay from matchestable where host='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' ";
			$query .= " and playflag='Yes' ";
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homewin==null) $homewin=0;
			}

			$query = "select count(*) as awayplay from matchestable where visitor='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' ";
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaywin==null) $awaywin=0;
			}
		
			$query = "select count(*) as homewin from matchestable where host='{$rowA[0]}' and hostscore > visitorscore ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homewin==null) $homewin=0;
			}

			$query = "select count(*) as awaywin from matchestable where visitor='{$rowA[0]}' and visitorscore > hostscore ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaywin==null) $awaywin=0;
			}
		
			$query = "select count(*) as homegoalsdraw from matchestable where host='{$rowA[0]}' and hostscore = visitorscore and hostscore>0 ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homegoalsdraw==null) $homegoalsdraw=0;
			}

			$query = "select count(*) as homegoalessdraw from matchestable where host='{$rowA[0]}' and hostscore = visitorscore and hostscore=0 ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homegoalessdraw==null) $homegoalessdraw=0;
			}

			$query = "select count(*) as awaygoalsdraw from matchestable where visitor='{$rowA[0]}' and visitorscore = hostscore and hostscore>0 ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaygoalsdraw==null) $awaygoalsdraw=0;
			}
		
			$query = "select count(*) as awaygoalessdraw from matchestable where visitor='{$rowA[0]}' and visitorscore = hostscore and hostscore=0 ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaygoalessdraw==null) $awaygoalessdraw=0;
			}
		
			$query = "select count(*) as homeloss from matchestable where host='{$rowA[0]}' and hostscore < visitorscore ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homeloss==null) $homeloss=0;
			}

			$query = "select count(*) as awayloss from matchestable where visitor='{$rowA[0]}' and visitorscore < hostscore ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awayloss==null) $awayloss=0;
			}
		
			$query = "select sum(hostscore) as homegoalfavour from matchestable where host='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homegoalfavour==null) $homegoalfavour=0;
			}

			$query = "select sum(visitorscore) as awaygoalfavour from matchestable where visitor='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaygoalfavour==null) $awaygoalfavour=0;
			}
		
			$query = "select sum(visitorscore) as homegoalagainst from matchestable where host='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homegoalagainst==null) $homegoalagainst=0;
			}

			$query = "select sum(hostscore) as awaygoalagainst from matchestable where visitor='{$rowA[0]}' ";
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
			if($clubnameA != ""){
				$query .= " and ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($matchdateA != "")
				$query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
			if($weekA != "")
				$query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' "; 
			$query .= " and playflag='Yes' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($awaygoalagainst==null) $awaygoalagainst=0;
			}

			$wins = $homewin + $awaywin;

			$plays = $homeplay + $awayplay;
 
			$homedraws = $homegoalsdraw + $homegoalessdraw;
			$awaydraws = $awaygoalsdraw + $awaygoalessdraw;
			$draws = $homedraws + $awaydraws;

			$losss = $homeloss + $awayloss;

			$goalsfavours = $homegoalfavour + $awaygoalfavour;
			$goalsagainsts = $homegoalagainst + $awaygoalagainst;

			$homegoalsaggregate = $homegoalfavour - $homegoalagainst;
			$awaygoalsaggregate = $awaygoalfavour - $awaygoalagainst;
			$goalsaggregate = $goalsfavours - $goalsagainsts;
			
			$winningpoint = 0;
			$goalsdrawpoint = 0;
			$goalessdrawpoint = 0;

			$query = "select * from seasonstable where season='{$seasons}' and leaguename='{$leaguenames}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				$winningpoint = $row[3];
				$goalsdrawpoint = $row[4];
				$goalessdrawpoint = $row[5];
				}
			}else{
				$winningpoint = 3;
				$goalsdrawpoint = 1;
				$goalessdrawpoint = 1;
			}
			$homepoint = ($homewin * $winningpoint) + ($homegoalsdraw * $goalsdrawpoint) + ($homegoalessdraw * $goalessdrawpoint);
			$awaypoint = ($awaywin * $winningpoint) + ($awaygoalsdraw * $goalsdrawpoint) + ($awaygoalessdraw * $goalessdrawpoint);
			$points = $homepoint + $awaypoint;
			
			$query = "insert into leaguetable (clubname, play, playhome, playaway, win, winhome, winaway, draw, drawhome, drawaway, loss, losshome, lossaway, goalsfavour, goalsfavourhome, goalsfavouraway, goalsagainst, goalsagainsthome, goalsagainstaway, goalsaggregate, goalsaggregatehome, goalsaggregateaway, ranks, ranks, season, leaguename, username, pointhome, pointaway) values ('{$rowA[0]}', {$plays}, {$homeplay}, {$awayplay}, {$wins}, {$homewin}, {$awaywin}, {$draws}, {$homedraws}, {$awaydraws}, {$losss}, {$homeloss}, {$awayloss}, {$goalsfavours}, {$homegoalfavour}, {$awaygoalfavour}, {$goalsagainsts}, {$homegoalagainst}, {$awaygoalagainst}, {$goalsaggregate}, {$homegoalsaggregate}, {$awaygoalsaggregate}, {$points}, 0, '{$seasons}', '{$leaguenames}', '{$currentuser}', {$homepoint}, {$awaypoint}) ";
			mysql_query($query, $connection);
		}
	}
   
	echo "<TABLE border='0'>";
	echo "<TR><TD colspan='2' align='center' style='font-size:30px'>THE NIGERIA FOOTBALL LEAGUE</td></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:15px'>THE LEAGUE TABLE</TD></TR>";
	if($leaguenames!=null && $leaguenames!=""){
		echo "<TR><TD align='center' style='font-size:15px'>LEAGUE NAME: ".$leaguenames."</TD></TR>";
	}
	if($seasons!=null && $seasons!=""){
		echo "<TR><TD align='center' style='font-size:15px'>SEASON: ".$seasons."</TD></TR>";
	}
	if($matchdateA!=null && $matchdateA!=""){
		echo "<TR><TD align='center' style='font-size:15px'>".$matchdateA.'  To  '.$matchdateB."</TD></TR>";
	}
	
	if($weekA!=null && $weekA!=""){
		echo "<TR><TD align='center' style='font-size:15px'>Week".$weekA."  To  Week".$weekB."</TD></TR>";
	}

	$barXMLPos  = "";
	$barXMLPos .= "<graph caption='Column Chart Showing Teams Positions' xAxisName='Teams' yAxisName='' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLPla  = "";
	$barXMLPla .= "<graph caption='Column Chart Showing No of Games Played by Each Team' xAxisName='Teams' yAxisName='Game(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLWin  = "";
	$barXMLWin .= "<graph caption='Column Chart Showing No of Games Won by Each Team' xAxisName='Teams' yAxisName='Game(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLDrw  = "";
	$barXMLDrw .= "<graph caption='Column Chart Showing No of Games Drawn by Each Team' xAxisName='Teams' yAxisName='Game(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLLos = "";
	$barXMLLos.= "<graph caption='Column Chart Showing No of Games Lost by Each Team' xAxisName='Teams' yAxisName='Game(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLGF  = "";
	$barXMLGF .= "<graph caption='Column Chart Showing Goals Favour For Each Team' xAxisName='Teams' yAxisName='Goal(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLGA  = "";
	$barXMLGA .= "<graph caption='Column Chart Showing Goals Against For Each Team' xAxisName='Teams' yAxisName='Goal(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLAG  = "";
	$barXMLAG .= "<graph caption='Column Chart Showing  Goals Aggregate For Each Team' xAxisName='Teams' yAxisName='Goal(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$barXMLPnt  = "";
	$barXMLPnt .= "<graph caption='Column Chart Showing Points Eaned by Each Team' xAxisName='Teams' yAxisName='ranks(s)' decimalPrecision='0'  formatNumberScale='0' rotateNames='1' bgcolor='F1f1f1' numberSuffix=''>";

	$pieXMLPos  = "";
	$pieXMLPos .= "<graph caption='Pie Chart Showing Teams Positions' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix='' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLPla  = "";
	$pieXMLPla .= "<graph caption='Pie Chart Showing No of Games Played by Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Game(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLWin  = "";
	$pieXMLWin .= "<graph caption='Pie Chart Showing No of Games Won by Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Game(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLDrw  = "";
	$pieXMLDrw .= "<graph caption='Pie Chart Showing No of Games Drawn by Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Game(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLLos = "";
	$pieXMLLos.= "<graph caption='Pie Chart Showing No of Games Lost by Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Game(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLGF  = "";
	$pieXMLGF .= "<graph caption='Pie Chart Showing Goals Favour For Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Goal(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$pieXMLGA  = "";
	$pieXMLGA .= "<graph caption='Pie Chart Showing Goals Against For Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Goal(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	//$pieXMLAG  = "";
	//$pieXMLAG .= "<graph caption='Pie Chart Showing  Goals Aggregate For Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' Goal(s)' showValues='1' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100'>";

	$pieXMLPnt  = "";
	$pieXMLPnt .= "<graph caption='Pie Chart Showing Points Eaned by Each Team' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix=' ranks(s)' showValues='1' showPercentageInLabel='0' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='300'>";

	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by ranks desc, goalsaggregate desc, goalsfavour desc, clubname";
	$result = mysql_query($query, $connection);
echo $query."<br><br>";
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$count++;
			$queryA = "update leaguetable set ranks={$count} where serialno={$row[0]}";
			mysql_query($queryA, $connection);
		}
	}

	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by ranks desc, goalsaggregate desc, goalsfavour desc, clubname";
	$result = mysql_query($query, $connection);
echo $query."<br><br>";
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$count++;
			if($count==1) $curcolor="F6BD0F";
			if($count==2) $curcolor="8BBA00";
			if($count==3) $curcolor="FF8E46";
			if($count==4) $curcolor="008E8E";
			if($count==5) $curcolor="D64646";
			if($count==6) $curcolor="8E468E";
			if($count==7) $curcolor="588526";
			if($count==8) $curcolor="B3AA00";
			if($count==9) $curcolor="008ED6";
			if($count==10) $curcolor="9D080D";
			if($count==11) $curcolor="A186BE";
			if($count==12) $curcolor="AFD8F8";
			if($count==13) $curcolor="66FFFF";
			if($count==14) $curcolor="FFFF33";
			if($count==15) $curcolor="CC0000";
			if($count==16) $curcolor="6600FF";
			if($count==17) $curcolor="333366";
			if($count==18) $curcolor="FF0000";
			if($count==19) $curcolor="FFFF99";
			if($count==20) $curcolor="000099";

			$theclubHome= $clubname."(Home)";
			$theclubAway= $clubname."(Away)";
			$theclubTotal= $clubname."(Total)";

			$barXMLPos  .= "<set name='".$clubname."' value='".$ranks."' color='".$curcolor."' />";

			if($playhome!=0) 
				$barXMLPla  .= "<set name='".$theclubHome."' value='".$playhome."' color='FF0000' />";
			if($playaway!=0) 
				$barXMLPla  .= "<set name='".$theclubAway."' value='".$playaway."' color='FFFF00' />";
			if($play!=0) 
				$barXMLPla  .= "<set name='".$theclubTotal."' value='".$play."' color='000099' />";
			$barXMLPla .= "<set name='' value='' color='' />";

			if($winhome!=0) 
				$barXMLWin  .= "<set name='".$theclubHome."' value='".$winhome."' color='FF0000' />";
			if($winaway!=0) 
				$barXMLWin  .= "<set name='".$theclubAway."' value='".$winaway."' color='FFFF00' />";
			if($win!=0) 
				$barXMLWin  .= "<set name='".$theclubTotal."' value='".$win."' color='000099' />";
			$barXMLWin .= "<set name='' value='' color='' />";

			if($drawhome!=0) 
				$barXMLDrw  .= "<set name='".$theclubHome."' value='".$drawhome."' color='FF0000' />";
			if($drawaway!=0) 
				$barXMLDrw  .= "<set name='".$theclubAway."' value='".$drawaway."' color='FFFF00' />";
			if($draw!=0) 
				$barXMLDrw  .= "<set name='".$theclubTotal."' value='".$draw."' color='000099' />";
			$barXMLDrw .= "<set name='' value='' color='' />";

			if($losshome!=0) 
				$barXMLLos .= "<set name='".$theclubHome."' value='".$losshome."' color='FF0000' />";
			if($lossaway!=0) 
				$barXMLLos .= "<set name='".$theclubAway."' value='".$lossaway."' color='FFFF00' />";
			if($loss!=0) 
				$barXMLLos .= "<set name='".$theclubTotal."' value='".$loss."' color='000099' />";
			$barXMLLos.= "<set name='' value='' color='' />";

			if($goalsfavourhome!=0) 
				$barXMLGF  .= "<set name='".$theclubHome."' value='".$goalsfavourhome."' color='FF0000' />";
			if($goalsfavouraway!=0) 
				$barXMLGF  .= "<set name='".$theclubAway."' value='".$goalsfavouraway."' color='FFFF00' />";
			if($goalsfavour!=0) 
				$barXMLGF  .= "<set name='".$theclubTotal."' value='".$goalsfavour."' color='000099' />";
			$barXMLGF .= "<set name='' value='' color='' />";

			if($goalsagainsthome!=0) 
				$barXMLGA  .= "<set name='".$theclubHome."' value='".$goalsagainsthome."' color='FF0000' />";
			if($goalsagainstaway!=0) 
				$barXMLGA  .= "<set name='".$theclubAway."' value='".$goalsagainstaway."' color='FFFF00' />";
			if($goalsagainst!=0) 
				$barXMLGA  .= "<set name='".$theclubTotal."' value='".$goalsagainst."' color='000099' />";
			$barXMLGA .= "<set name='' value='' color='' />";

			if($goalsaggregatehome!=0) 
				$barXMLAG  .= "<set name='".$theclubHome."' value='".$goalsaggregatehome."' color='FF0000' />";
			if($goalsaggregateaway!=0) 
				$barXMLAG  .= "<set name='".$theclubAway."' value='".$goalsaggregateaway."' color='FFFF00' />";
			if($goalsaggregate!=0) 
				$barXMLAG  .= "<set name='".$theclubTotal."' value='".$goalsaggregate."' color='000099' />";
			$barXMLAG .= "<set name='' value='' color='' />";

			if($pointhome!=0) 
				$barXMLPnt  .= "<set name='".$theclubHome."' value='".$pointhome."' color='FF0000' />";
			if($pointaway!=0) 
				$barXMLPnt  .= "<set name='".$theclubAway."' value='".$pointaway."' color='FFFF00' />";
			if($ranks!=0) 
				$barXMLPnt  .= "<set name='".$theclubTotal."' value='".$ranks."' color='000099' />";
			$barXMLPnt .= "<set name='' value='' color='' />";
				
			if($ranks!=0) 
				$pieXMLPos  .= "<set name='".$clubname."' value='".$ranks."' color='".$curcolor."' />";
			if($play!=0) 
				$pieXMLPla  .= "<set name='".$clubname."' value='".$play."' color='".$curcolor."' />";
			if($win!=0) 
				$pieXMLWin  .= "<set name='".$clubname."' value='".$win."' color='".$curcolor."' />";
			if($draw!=0) 
				$pieXMLDrw  .= "<set name='".$clubname."' value='".$draw."' color='".$curcolor."' />";
			if($loss!=0) 
				$pieXMLLos .= "<set name='".$clubname."' value='".$loss."' color='".$curcolor."' />";
			if($goalsfavour!=0) 
				$pieXMLGF  .= "<set name='".$clubname."' value='".$goalsfavour."' color='".$curcolor."' />";
			if($goalsagainst!=0) 
				$pieXMLGA  .= "<set name='".$clubname."' value='".$goalsagainst."' color='".$curcolor."' />";
			//if($goalsaggregate!=0) 
			//	$pieXMLAG  .= "<set name='".$clubname."' value='".$goalsaggregate."' color='".$curcolor."' />";
			if($ranks!=0) 
				$pieXMLPnt  .= "<set name='".$clubname."' value='".$ranks."' color='".$curcolor."' />";

		}
	}

	$barXMLPos .= "</graph>";
	$barXMLPla .= "</graph>";
	$barXMLWin .= "</graph>";
	$barXMLDrw .= "</graph>";
	$barXMLLos.= "</graph>";
	$barXMLGF .= "</graph>";
	$barXMLGA .= "</graph>";
	$barXMLAG .= "</graph>";
	$barXMLPnt .= "</graph>";

	$pieXMLPos .= "</graph>";
	$pieXMLPla .= "</graph>";
	$pieXMLWin .= "</graph>";
	$pieXMLDrw .= "</graph>";
	$pieXMLLos.= "</graph>";
	$pieXMLGF .= "</graph>";
	$pieXMLGA .= "</graph>";
	//$pieXMLAG .= "</graph>";
	$pieXMLPnt .= "</graph>";


	//Create the chart - Column 3D Chart with data from XML variable using dataXML method
	//echo "<TABLE border='1'>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLPos, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLPos, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLPla, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLPla, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLWin, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLWin, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLDrw, "myNext", 900, 500) . "</TD></TR>";
	
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLDrw, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLLos, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLLos, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLGF, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLGF, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLGA, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLGA, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLAG, "myNext", 900, 500) . "</TD></TR>";
	//echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLAG, "myNext", 900, 500) . "</TD></TR>";

	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $barXMLPnt, "myNext", 900, 500) . "</TD></TR>";
	echo "<TR><TD>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $pieXMLPnt, "myNext", 900, 500) . "</TD></TR>";

	echo "</TABLE>";*/
?>
