<?php
	
	$leaguenames = trim($_GET['leaguename']);
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

	//include("../FusionCharts/Includes/FusionCharts.php");
	include("data.php"); 
	
	$currentuser = $_COOKIE['currentuser'];
	$query .= "delete from leaguetable where username='{$currentuser}'";
	mysql_query($query, $connection);

	$queryA = "SELECT distinct serialno FROM clubstable where clubname<>'' ";
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
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
				if($homeplay==null) $homeplay=0;
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
				if($awayplay==null) $awayplay=0;
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
			
			$query = "insert into leaguetable (clubname, play, playhome, playaway, win, winhome, winaway, draw, drawhome, drawaway, loss, losshome, lossaway, goalsfavour, goalsfavourhome, goalsfavouraway, goalsagainst, goalsagainsthome, goalsagainstaway, goalsaggregate, goalsaggregatehome, goalsaggregateaway, points, ranks, season, leaguename, username, pointhome, pointaway) values ('{$rowA[0]}', {$plays}, {$homeplay}, {$awayplay}, {$wins}, {$homewin}, {$awaywin}, {$draws}, {$homedraws}, {$awaydraws}, {$losss}, {$homeloss}, {$awayloss}, {$goalsfavours}, {$homegoalfavour}, {$awaygoalfavour}, {$goalsagainsts}, {$homegoalagainst}, {$awaygoalagainst}, {$goalsaggregate}, {$homegoalsaggregate}, {$awaygoalsaggregate}, {$points}, 0, '{$seasons}', '{$leaguenames}', '{$currentuser}', {$homepoint}, {$awaypoint}) ";
			mysql_query($query, $connection);
		}
	}
   
	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by ranks desc, goalsaggregate desc, goalsfavour desc, clubname";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$count++;
			$queryA = "update leaguetable set ranks={$count} where serialno={$row[0]}";
			mysql_query($queryA, $connection);
		}
	}
	
	$barXMLPos = array();
	$barXMLPla = array();
	$barXMLWin = array();
	$barXMLDrw = array();
	$barXMLLos = array();
	$barXMLGF = array();
	$barXMLGA = array();
	$barXMLAG = array();
	$barXMLPnt = array();

	$pieXMLPos = array();
	$pieXMLPla = array();
	$pieXMLWin = array();
	$pieXMLDrw = array();
	$pieXMLLos = array();
	$pieXMLGF = array();
	$pieXMLGA = array();
	$pieXMLAG = array();
	$pieXMLPnt = array();

	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by ranks desc, goalsaggregate desc, goalsfavour desc, clubname";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$theclubHome= $clubname."(Home)";
			$theclubAway= $clubname."(Away)";
			$theclubTotal= $clubname."(Total)";

			if($ranks!=0)
				$barXMLPos[$count]=array("label"=> $clubname, "y"=> $ranks);


			if($playhome!=0)
				$barXMLPla[$count]=array("label"=> $theclubHome, "y"=> $playhome);

			if($playaway!=0)
				$barXMLPla[$count]=array("label"=> $theclubAway, "y"=> $playaway);

			if($play!=0)
				$barXMLPla[$count]=array("label"=> $theclubTotal, "y"=> $play);


			if($winhome!=0)
				$barXMLWin[$count]=array("label"=> $theclubHome, "y"=> $winhome);

			if($winaway!=0)
				$barXMLWin[$count]=array("label"=> $theclubAway, "y"=> $winaway);

			if($win!=0)
				$barXMLWin[$count]=array("label"=> $theclubTotal, "y"=> $win);


			if($drawhome!=0)
				$barXMLDrw[$count]=array("label"=> $theclubHome, "y"=> $drawhome);

			if($drawaway!=0)
				$barXMLDrw[$count]=array("label"=> $theclubAway, "y"=> $drawaway);

			if($draw!=0)
				$barXMLDrw[$count]=array("label"=> $theclubTotal, "y"=> $draw);


			if($losshome!=0)
				$barXMLLos[$count]=array("label"=> $theclubHome, "y"=> $losshome);

			if($lossaway!=0)
				$barXMLLos[$count]=array("label"=> $theclubAway, "y"=> $lossaway);

			if($loss!=0)
				$barXMLLos[$count]=array("label"=> $theclubTotal, "y"=> $loss);


			if($goalsfavourhome!=0)
				$barXMLGF[$count]=array("label"=> $theclubHome, "y"=> $goalsfavourhome);

			if($goalsfavouraway!=0)
				$barXMLGF[$count]=array("label"=> $theclubAway, "y"=> $goalsfavouraway);

			if($goalsfavour!=0)
				$barXMLGF[$count]=array("label"=> $theclubTotal, "y"=> $goalsfavour);


			if($goalsagainsthome!=0)
				$barXMLGA[$count]=array("label"=> $theclubHome, "y"=> $goalsagainsthome);

			if($goalsagainstaway!=0)
				$barXMLGA[$count]=array("label"=> $theclubHome, "y"=> $goalsagainstaway);

			if($goalsagainst!=0)
				$barXMLGA[$count]=array("label"=> $theclubHome, "y"=> $goalsagainst);

			if($goalsaggregatehome!=0)
				$barXMLAG[$count]=array("label"=> $theclubHome, "y"=> $goalsaggregatehome);

			if($goalsaggregateaway!=0)
				$barXMLAG[$count]=array("label"=> $theclubAway, "y"=> $goalsaggregateaway);

			if($goalsaggregate!=0)
				$barXMLAG[$count]=array("label"=> $theclubTotal, "y"=> $goalsaggregate);

			if($pointhome!=0)
				$barXMLPnt[$count]=array("label"=> $theclubHome, "y"=> $pointhome);

			if($pointaway!=0)
				$barXMLPnt[$count]=array("label"=> $theclubAway, "y"=> $pointaway);

			if($points!=0)
				$barXMLPnt[$count]=array("label"=> $theclubTotal, "y"=> $points);

			if($ranks!=0)
				$barXMLPnt[$count]=array("label"=> $theclubTotal, "y"=> $ranks);


			if($ranks!=0)
				$pieXMLPos[$count]=array("label"=> $clubname, "y"=> $ranks);

			if($play!=0)
				$pieXMLPla[$count]=array("label"=> $clubname, "y"=> $play);

			if($win!=0)
				$pieXMLWin[$count]=array("label"=> $clubname, "y"=> $win);

			if($draw!=0)
				$pieXMLDrw[$count]=array("label"=> $clubname, "y"=> $draw);

			if($loss!=0)
				$pieXMLLos[$count]=array("label"=> $clubname, "y"=> $loss);

			if($goalsfavour!=0)
				$pieXMLGF[$count]=array("label"=> $clubname, "y"=> $goalsfavour);

			if($goalsagainst!=0)
				$pieXMLGA[$count]=array("label"=> $clubname, "y"=> $goalsagainst);

			if($goalsaggregate!=0)
				$pieXMLAG[$count]=array("label"=> $clubname, "y"=> $goalsaggregate);

			if($ranks!=0)
				$pieXMLPnt[$count]=array("label"=> $clubname, "y"=> $ranks);

			$count++;
		}
	}

?>
<!DOCTYPE HTML>
<html>
<head>
<style> 
	h1 { 
		text-align:center; 
		color:green; 
	} 
	h2 { 
		text-align:center; 
		color:green; 
	} 
	h3 { 
		text-align:center; 
		color:green; 
	} 
	body { 
		width:100%; 
	} 
	.container .box { 
		width:1540px; 
		margin:50px; 
		display:table; 
	} 
	.container .box .box-row { 
		display:table-row; 
	} 
	.container .box .box-cell { 
		display:table-cell; 
		width:100%; 
		padding:10px; 
	} 
</style> 
<script>
window.onload = function () {
	
	var barPosition = new CanvasJS.Chart("barPosition", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing Teams Positions"
		},
		axisY: {
			title: "Number of Positions"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLPos, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barPosition.render();
	
	var piePosion = new CanvasJS.Chart("piePosion", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing Teams Positions"
		},
		axisY: {
			title: "Number of Positions"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLPos, JSON_NUMERIC_CHECK); ?>
		}]
	});
	piePosion.render();
	
	var barGamePlayed = new CanvasJS.Chart("barGamePlayed", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing No of Games Played by Each Team"
		},
		axisY: {
			title: "Number of Games Played"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLPla, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGamePlayed.render();
 
	var pieGamePlayed = new CanvasJS.Chart("pieGamePlayed", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing No of Games Played by Each Team"
		},
		axisY: {
			title: "Number of Games Played"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLPla, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGamePlayed.render();

	var barGameWon = new CanvasJS.Chart("barGameWon", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing No of Games Won by Each Team"
		},
		axisY: {
			title: "Number of Games Won"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLWin, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameWon.render();
 
	var pieGameWon = new CanvasJS.Chart("pieGameWon", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing No of Games Won by Each Team"
		},
		axisY: {
			title: "Number of Games Won"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLWin, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameWon.render();

	var barGameDraw = new CanvasJS.Chart("barGameDraw", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing No of Games Drawn by Each Team"
		},
		axisY: {
			title: "Number of Games Drawn"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLDrw, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameDraw.render();
 
	var pieGameDraw = new CanvasJS.Chart("pieGameDraw", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing No of Games Drawn by Each Team"
		},
		axisY: {
			title: "Number of Games Drawn"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLDrw, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameDraw.render();

	var barGameLos = new CanvasJS.Chart("barGameLos", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing No of Games Lost by Each Team"
		},
		axisY: {
			title: "Number of Games Lost"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLLos, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameLos.render();
 
	var pieGameLos = new CanvasJS.Chart("pieGameLos", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing No of Games Lost by Each Team"
		},
		axisY: {
			title: "Number of Games Lost"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLLos, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameLos.render();
	
	var barGameGF = new CanvasJS.Chart("barGameGF", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing Goals Favour For Each Team"
		},
		axisY: {
			title: "Number of Goals Favour"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLGF, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameGF.render();
 
 	var pieGameGF = new CanvasJS.Chart("pieGameGF", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing Goals Favour For Each Team"
		},
		axisY: {
			title: "Number of Goals Favour"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLGF, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameGF.render();

	var barGameGA = new CanvasJS.Chart("barGameGA", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing Goals Against For Each Team"
		},
		axisY: {
			title: "Number of Goals Against"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLGA, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameGA.render();
 
	var pieGameGA = new CanvasJS.Chart("pieGameGA", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing Goals Against For Each Team"
		},
		axisY: {
			title: "Number of Goals Against"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLGA, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameGA.render();

	var barGameAG = new CanvasJS.Chart("barGameAG", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing  Goals Aggregate For Each Team"
		},
		axisY: {
			title: "Number of Goals Aggregate"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLAG, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGameAG.render();
 
	/*var pieGameAG = new CanvasJS.Chart("pieGameAG", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing  Goals Aggregate For Each Team"
		},
		axisY: {
			title: "Number of Goals Aggregate"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLAG, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGameAG.render();*/
	
	var barGamePnt = new CanvasJS.Chart("barGamePnt", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Column Chart Showing Points Eaned by Each Team"
		},
		axisY: {
			title: "Number of Points"
		},
		data: [{
			type: "column",
			dataPoints: <?php echo json_encode($barXMLPnt, JSON_NUMERIC_CHECK); ?>
		}]
	});
	barGamePnt.render();
 
	var pieGamePnt = new CanvasJS.Chart("pieGamePnt", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Pie Chart Showing Points Eaned by Each Team"
		},
		axisY: {
			title: "Number of Points"
		},
		data: [{
			type: "pie",
			dataPoints: <?php echo json_encode($pieXMLPnt, JSON_NUMERIC_CHECK); ?>
		}]
	});
	pieGamePnt.render();
	
}

</script>
</head>
<body>
	<h1>THE NIGERIA PROFESSIONAL FOOTBALL LEAGUE</h1>
	<h2>THE LEAGUE TABLE</h2>
	<h3>LEAGUE NAME: <?php echo $leaguenames ?></h3>
	<h3>SEASON: <?php echo $seasons ?></h3>
	<h3><?php echo $matchdateA?> To <?php echo $matchdateB ?></h3>
	<h3></h3>
	<h3></h3>
	
		<div class="box-cell box1" id="barPosition" style="height: 370px; width: 100%;"></div>
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="piePosion" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
		
		<div class="box-cell box1" id="barGamePlayed" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGamePlayed" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
		
		<div class="box-cell box1" id="barGameWon" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameWon" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
		
		<div class="box-cell box1" id="barGameDraw" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameDraw" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
			
		<div class="box-cell box1" id="barGameLos" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameLos" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
			
		<div class="box-cell box1" id="barGameGF" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameGF" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
			
		<div class="box-cell box1" id="barGameGA" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameGA" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"></div>
			
		<div class="box-cell box1" id="barGameAG" style="height: 370px; width: 100%;"></div> 
		<!--div style="height: 50px"></div>
		<div class="box-cell box2" id="pieGameAG" style="height: 370px; width: 100%;"></div-->
		<div style="height: 100px"></div>
			
		<div class="box-cell box1" id="barGamePnt" style="height: 370px; width: 100%;"></div> 
		<div style="height: 50px"><?php echo $barXMLPnt; ?></div>
		<div class="box-cell box2" id="pieGamePnt" style="height: 370px; width: 100%;"></div>
		<div style="height: 100px"><?php echo $pieXMLPnt; ?></div>
			
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
