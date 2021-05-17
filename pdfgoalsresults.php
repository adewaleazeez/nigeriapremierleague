<?php

	global $leaguenames;
	$leaguenames = trim($_GET['leaguename']);
	if($leaguenames == null) $leaguenames = "";

	global $seasons;
	$seasons = trim($_GET['season']);
	if($seasons == null) $seasons = "";

	global $weekA;
	$weekA = trim($_GET['weekA']);
	if($weekA == null) $weekA = "";
	
	global $weekB;
	$weekB = trim($_GET['weekB']);
	if($weekB == null) $weekB = "";

	global $clubnameA;
	$clubnames = trim($_GET['clubname']);
	if($clubnames == null) $clubnames = "";

	global $reportype;
	$reportype = trim($_GET['reportype']);
	if($reportype == null) $reportype = "";

	require('fpdf.php');

	class PDF extends FPDF{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='P', $unit='mm', $size='A4'){
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
			$weekA = $GLOBALS['weekA'];
			$weekB = $GLOBALS['weekB'];
			$reportype = $GLOBALS['reportype'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(190,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(190,7,'THE GOALS RESULTS',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(190,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasons!=null && $seasons!=""){
				$this->Cell(190,7,$seasons.' SEASON',0,0,'C');
				$this->Ln();
			}			
			if($weekA!=null && $weekA!=""){
				$this->Cell(190,7,'Week'.$weekA.'   To   Week' . $weekB ,0,0,'C');
				$this->Ln();
			}
			$this->Cell(190,7,'REPORT TYPE: Goals '.$reportype,0,0,'C');
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
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

	$query = "select a.*, b.clubname as club_name from goalstable a, clubstable b where a.serialno>0 and a.activity='Goal' and a.clubname=b.serialno ";
	if($reportype=="List by No of Goals") $query="select count(*) as goals, a.serialno, a.regnumber, a.playername, a.clubname, a.season, a.leaguename, a.goaltime, a.weeks, a.matchno, b.clubname as club_name from goalstable a, clubstable b where a.serialno>0 and a.activity='Goal' and a.clubname=b.serialno ";
	if($reportype=="List by Clubs") $query="select count(*) as goals, a.serialno, a.regnumber, a.playername, a.clubname, a.season, a.leaguename, a.goaltime, a.weeks, a.matchno, b.clubname as club_name from goalstable a, clubstable b where a.serialno>0 and a.activity='Goal' and a.clubname=b.serialno ";
	if($seasons != "") $query .= " and a.season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and a.leaguename='{$leaguenames}' "; 
	if($clubnames != "")	$query .= " and a.clubname='{$clubnames}' ";
	if($weekA != "") $query .= " and a.weeks>='{$weekA}' and a.weeks<='{$weekB}' ";
	if($reportype=="List by No of Goals") $query .= " group by a.regnumber order by goals desc, a.clubname, a.playername ";
	if($reportype=="List by Time of Goals") $query .= " order by a.goaltime ";
	if($reportype=="List by Weeks") $query .= " order by a.weeks, a.clubname ";
	if($reportype=="List by Clubs") $query .= " group by a.clubname order by goals desc, a.clubname ";
	$result = mysql_query($query, $connection);
	$headerflag="";
	$printheader="Yes";
	$count=1;
//echo $query;
	if(mysql_num_rows($result) > 0){
		$count=0;
		$pagelinecounter=1;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			
			if($reportype=="List by Weeks" && $weeks>intval($headerflag)){
				$pagelinecounter++;
				$pdf->Ln(5);
				$pdf->Cell(100,5,"WEEK: ".$weeks,1,1,'L');
				$pdf->Ln(1);
				$headerflag=$weeks;
			}

			if($pagelinecounter==$linesperpage){
				$pdf->AddPage();
				$pagelinecounter = 1;
				if($reportype=="List by Weeks" && $weeks>intval($headerflag)){
					$pagelinecounter++;
					$pdf->Ln(5);
					$pdf->Cell(100,5,"WEEK: ".$weeks,1,1,'L');
					$pdf->Ln(1);
					$headerflag=$weeks;
				}
				$printheader="Yes";
			}

			if($printheader=="Yes"){
				$printheader="No";

				$pdf->Cell(10,5,"S/NO",1,0,'R');
				if($reportype=="List by Time of Goals" || $reportype=="List by Weeks" || $reportype=="List by No of Goals"){
					$pdf->Cell(50,5,"LICENSE NO",1,0,'L');
					$pdf->Cell(40,5,"PLAYER",1,0,'L');
				}
				$pdf->Cell(40,5,"CLUB",1,0,'L');
				if($reportype=="List by Time of Goals" || $reportype=="List by Weeks"){
					$pdf->Cell(15,5,"WEEK",1,0,'C');
					$pdf->Cell(25,5,"MATCH NO",1,0,'C');
					$pdf->Cell(15,5,"TIME",1,0,'C');
				}
				if($reportype=="List by No of Goals" || $reportype=="List by Clubs"){
					$pdf->Cell(25,5,"NO OF GOALS",1,0,'C');
				}
				$pdf->Ln(5);
				$count=1;
				$pagelinecounter++;
			}

			$pdf->Cell(10,5,$count++.".",1,0,'R');
			if($reportype=="List by Time of Goals" || $reportype=="List by Weeks" || $reportype=="List by No of Goals"){
				$pdf->Cell(50,5,$regnumber,1,0,'L');
				$pdf->Cell(40,5,substr($playername,0,24),1,0,'L');
			}
			$pdf->Cell(40,5,$club_name,1,0,'L');
			if($reportype=="List by Time of Goals" || $reportype=="List by Weeks"){
				$pdf->Cell(15,5,$weeks,1,0,'C');
				$pdf->Cell(25,5,$matchno,1,0,'C');
				$pdf->Cell(15,5,$goaltime,1,0,'C');
			}
			if($reportype=="List by No of Goals" || $reportype=="List by Clubs"){
				$pdf->Cell(25,5,$goals,1,0,'C');
			}
			$pdf->Ln(5);
			$pagelinecounter++;
		}
	}
	$pdf->Output();
?>
