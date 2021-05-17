<?php

	global $leaguenames;
	$leaguenames = trim($_GET['leaguename']);
	if($leaguenames == null) $leaguenames = "";

	global $seasons;
	$seasons = trim($_GET['season']);
	if($seasons == null) $seasons = "";

	global $matchdateA;
	$matchdateA = trim($_GET['matchdateA']);
	if($matchdateA == null){
		$matchdateA = "";
	}else{
		$matchdateA = substr($matchdateA,6,4)."-".substr($matchdateA,3,2)."-".substr($matchdateA,0,2);
	}

	global $matchdateB;
	$matchdateB = trim($_GET['matchdateB']);
	if($matchdateB == null){
		$matchdateB = "";
	}else{
		$matchdateB = substr($matchdateB,6,4)."-".substr($matchdateB,3,2)."-".substr($matchdateB,0,2);
	}

	global $weekA;
	$weekA = trim($_GET['weekA']);
	if($weekA == null) $weekA = "";
	
	global $weekB;
	$weekB = trim($_GET['weekB']);
	if($weekB == null) $weekB = "";

	global $clubnameA;
	$clubnameA = trim($_GET['clubnameA']);
	if($clubnameA == null) $clubnameA = "";

	global $clubnameB;
	$clubnameB = trim($_GET['clubnameB']);
	if($clubnameB == null) $clubnameB = "";

	global $reportype;
	$reportype = trim($_GET['reportype']);
	if($reportype == null) $reportype = "";

	require('fpdf.php');

	class PDF extends FPDF{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='L', $unit='mm', $size='A4'){
			// Call parent constructor
			$this->FPDF($orientation,$unit,$size);
			// Initialization
			$this->B = 0;
			$this->I = 0;
			$this->U = 0;
			$this->HREF = '';
		}
		// Page header
		function Header(){
			$leaguenames = $GLOBALS['leaguenames'];
			$seasons = $GLOBALS['seasons'];
			$matchdateA = $GLOBALS['matchdateA'];
			$matchdateB = $GLOBALS['matchdateB'];
			$weekA = $GLOBALS['weekA'];
			$weekB = $GLOBALS['weekB'];
			$clubnameA = $GLOBALS['clubnameA'];
			$clubnameB = $GLOBALS['clubnameB'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',30);
			$this->Ln(3);
			$this->Cell(320,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(320,7,'THE LEAGUE TABLE',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(320,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasons!=null && $seasons!=""){
				$this->Cell(320,7,$seasons.' SEASON',0,0,'C');
				$this->Ln();
			}
			if($matchdateA!=null && $matchdateA!=""){
				$this->Cell(320,7,$matchdateA.'   To   ' . $matchdateB ,0,0,'C');
				$this->Ln();
			}
			
			if($weekA!=null && $weekA!=""){
				$this->Cell(320,7,'Week'.$weekA.'   To   Week' . $weekB ,0,0,'C');
				$this->Ln();
			}
			$this->Ln(20);
		}

		// Page footer
		function Footer(){
			$this->SetY(-10);
			$this->SetFont('Times','B',7.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$this->Cell(0,5,'Powered By: Immaculate High-Tech Systems Ltd.',0,0,'C');
		}
	}

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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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

			$query = "select count(*) as awayplay from matchestable where visitor='{$rowA[0]}' ";
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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
			if($clubnameA != ""){
				$query = "select count(*) as homeplay from matchestable where ";
				$query .= " ((host='{$clubnameA}' and visitor='{$clubnameB}') or (host='{$clubnameB}' and visitor='{$clubnameA}'))";
			}
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 
			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
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

	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by points desc, goalsaggregate desc, goalsfavour desc, clubname";
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

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Ln(20);
	$pdf->SetFont('Times','B',10);
	if($reportype=="Separate Home and Away Matches"){
		$currentY=$pdf->GetY();

		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+62);
		$pdf->Cell(72,5,"HOME",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+136);
		$pdf->Cell(72,5,"AWAY",1,1,'C');
			
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+210);
		$pdf->Cell(72,5,"TOTAL",1,1,'C');
	}
	//----------Next Line
	$currentY=$pdf->GetY();
	$pdf->Cell(10,5,"S/NO",1,1,'R');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+10);
	$pdf->Cell(50,5,"TEAMS",1,1,'L');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+62);
	$pdf->Cell(9,5,"PL",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+71);
	$pdf->Cell(9,5,"W",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+80);
	$pdf->Cell(9,5,"D",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+89);
	$pdf->Cell(9,5,"L",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+98);
	$pdf->Cell(9,5,"GF",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+107);
	$pdf->Cell(9,5,"GA",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+116);
	$pdf->Cell(9,5,"GD",1,1,'C');
	
	$pdf->SetY($currentY);
	$pdf->SetX($pdf->GetX()+125);
	$pdf->Cell(9,5,"PNT",1,1,'C');
		
	if($reportype=="Separate Home and Away Matches"){
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+136);
		$pdf->Cell(9,5,"PL",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+145);
		$pdf->Cell(9,5,"W",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+154);
		$pdf->Cell(9,5,"D",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+163);
		$pdf->Cell(9,5,"L",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+172);
		$pdf->Cell(9,5,"GF",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+181);
		$pdf->Cell(9,5,"GA",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+190);
		$pdf->Cell(9,5,"GD",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+199);
		$pdf->Cell(9,5,"PNT",1,1,'C');

		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+210);
		$pdf->Cell(9,5,"PL",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+219);
		$pdf->Cell(9,5,"W",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+228);
		$pdf->Cell(9,5,"D",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+237);
		$pdf->Cell(9,5,"L",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+246);
		$pdf->Cell(9,5,"GF",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+255);
		$pdf->Cell(9,5,"GA",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+264);
		$pdf->Cell(9,5,"GD",1,1,'C');
		
		$pdf->SetY($currentY);
		$pdf->SetX($pdf->GetX()+273);
		$pdf->Cell(9,5,"PNT",1,1,'C');
	}

	//----------Next Line
	$pdf->Ln(2);

	$query = "select * from leaguetable where season='{$seasons}' and leaguename='{$leaguenames}' and username='{$currentuser}' order by points desc, goalsaggregate desc, goalsfavour desc, clubname";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$currentY=$pdf->GetY();
			$pdf->Cell(10,5,$ranks.'.',1,1,'R');
			
			$pdf->SetY($currentY);
			$pdf->SetX($pdf->GetX()+10);
			$pdf->Cell(50,5,$clubname,1,1,'L');
			
			if($reportype=="Separate Home and Away Matches"){
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+62);
				$pdf->Cell(9,5,$playhome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+71);
				$pdf->Cell(9,5,$winhome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+80);
				$pdf->Cell(9,5,$drawhome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+89);
				$pdf->Cell(9,5,$losshome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+98);
				$pdf->Cell(9,5,$goalsfavourhome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+107);
				$pdf->Cell(9,5,$goalsagainsthome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+116);
				$pdf->Cell(9,5,$goalsaggregatehome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+125);
				$pdf->Cell(9,5,$pointhome,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+136);
				$pdf->Cell(9,5,$playaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+145);
				$pdf->Cell(9,5,$winaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+154);
				$pdf->Cell(9,5,$drawaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+163);
				$pdf->Cell(9,5,$lossaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+172);
				$pdf->Cell(9,5,$goalsfavouraway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+181);
				$pdf->Cell(9,5,$goalsagainstaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+190);
				$pdf->Cell(9,5,$goalsaggregateaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+199);
				$pdf->Cell(9,5,$pointaway,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+210);
				$pdf->Cell(9,5,$play,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+219);
				$pdf->Cell(9,5,$win,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+228);
				$pdf->Cell(9,5,$draw,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+237);
				$pdf->Cell(9,5,$loss,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+246);
				$pdf->Cell(9,5,$goalsfavour,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+255);
				$pdf->Cell(9,5,$goalsagainst,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+264);
				$pdf->Cell(9,5,$goalsaggregate,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+273);
				$pdf->Cell(9,5,$points,1,1,'C');
			}else{
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+62);
				$pdf->Cell(9,5,$play,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+71);
				$pdf->Cell(9,5,$win,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+80);
				$pdf->Cell(9,5,$draw,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+89);
				$pdf->Cell(9,5,$loss,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+98);
				$pdf->Cell(9,5,$goalsfavour,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+107);
				$pdf->Cell(9,5,$goalsagainst,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+116);
				$pdf->Cell(9,5,$goalsaggregate,1,1,'C');
				
				$pdf->SetY($currentY);
				$pdf->SetX($pdf->GetX()+125);
				$pdf->Cell(9,5,$points,1,1,'C');
			}
		}
	}
	$pdf->Output();
?>
