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
				$this->Cell(275,7,$seasons.' SEASON',0,0,'C');
				$this->Ln();
			}			
			if($weekA!=null && $weekA!=""){
				$this->Cell(190,7,'Week'.$weekA.'   To   Week' . $weekB ,0,0,'C');
				$this->Ln();
			}
			$this->Cell(190,7,'REPORT TYPE: Cautions '.$reportype,0,0,'C');
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

	$query = "select * from goalstable where serialno>0 and activity='Caution' ";
	if($reportype=="List by No of Cautions") $query="select count(*) as cautions, serialno, regnumber, playername, clubname, season, leaguename, goaltime, weeks, matchno from goalstable where serialno>0 and activity='Caution' ";
	if($reportype=="List by Clubs") $query="select count(*) as cautions, serialno, regnumber, playername, clubname, season, leaguename, goaltime, weeks, matchno from goalstable where serialno>0 and activity='Caution' ";
	if($seasons != "") $query .= " and season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
	if($clubnames != "")	$query .= " and clubname='{$clubnames}' ";
	if($weekA != "") $query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' ";
	if($reportype=="List by No of Cautions") $query .= " group by regnumber order by cautions desc, clubname, playername ";
	if($reportype=="List by Time of Cautions") $query .= " order by goaltime ";
	if($reportype=="List by Weeks") $query .= " order by weeks, clubname ";
	if($reportype=="List by Clubs") $query .= " group by clubname order by cautions desc, clubname ";
	$result = mysql_query($query, $connection);
	$headerflag="";
	$printheader="Yes";
	$count=1;
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
				if($reportype=="List by Time of Cautions" || $reportype=="List by Weeks" || $reportype=="List by No of Cautions"){
					$pdf->Cell(40,5,"LICENSE NO",1,0,'L');
					$pdf->Cell(60,5,"PLAYER",1,0,'L');
				}
				$pdf->Cell(30,5,"CLUB",1,0,'L');
				if($reportype=="List by Time of Cautions" || $reportype=="List by Weeks"){
					$pdf->Cell(15,5,"WEEK",1,0,'C');
					$pdf->Cell(25,5,"MATCH NO",1,0,'C');
					$pdf->Cell(15,5,"TIME",1,0,'C');
				}
				if($reportype=="List by No of Cautions" || $reportype=="List by Clubs"){
					$pdf->Cell(30,5,"NO OF CAUTIONS",1,0,'C');
				}
				$pdf->Ln(5);
				$count=1;
				$pagelinecounter++;
			}

			$pdf->Cell(10,5,$count++.".",1,0,'R');
			if($reportype=="List by Time of Cautions" || $reportype=="List by Weeks" || $reportype=="List by No of Cautions"){
				$pdf->Cell(40,5,$regnumber,1,0,'L');
				$pdf->Cell(60,5,substr($playername,0,24),1,0,'L');
			}
			$pdf->Cell(30,5,$clubname,1,0,'L');
			if($reportype=="List by Time of Cautions" || $reportype=="List by Weeks"){
				$pdf->Cell(15,5,$weeks,1,0,'C');
				$pdf->Cell(25,5,$matchno,1,0,'C');
				$pdf->Cell(15,5,$goaltime,1,0,'C');
			}
			if($reportype=="List by No of Cautions" || $reportype=="List by Clubs"){
				$pdf->Cell(30,5,$cautions,1,0,'C');
			}
			$pdf->Ln(5);
			$pagelinecounter++;
		}
	}
	$pdf->Output();
?>
