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
	$clubname = trim($_GET['clubname']);
	if($clubname == null) $clubname = "";

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
			$matchdateA = $GLOBALS['matchdateA'];
			$matchdateB = $GLOBALS['matchdateB'];
			$weekA = $GLOBALS['weekA'];
			$weekB = $GLOBALS['weekB'];
			$clubnameA = $GLOBALS['clubnameA'];
			$clubnameB = $GLOBALS['clubnameB'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(190,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(190,7,'THE FIXTURES LISTS',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(190,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasons!=null && $seasons!=""){
				$this->Cell(190,7,$seasons.' SEASON',0,0,'C');
				$this->Ln();
			}
			if($matchdateA!=null && $matchdateA!=""){
				$this->Cell(190,7,$matchdateA.'   To   ' . $matchdateB ,0,0,'C');
				$this->Ln();
			}
			
			if($weekA!=null && $weekA!=""){
				$this->Cell(190,7,'Week'.$weekA.'   To   Week' . $weekB ,0,0,'C');
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
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

	$query = "SELECT distinct serialno FROM clubstable where clubname<>'' ";
	if($seasons != "") $query .= " and season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
	$result = mysql_query($query, $connection);
	$noofclubs=mysql_num_rows($result);

	$linesperpage=45;
	$linespergroup=0;
	if($reportype=="List by Weeks"){
		$linespergroup = $noofclubs/2;
	}
	if($reportype=="List by Dates"){
		$linespergroup = $noofclubs/2;
	}
	if($reportype=="List by Clubs"){
		$linespergroup = --$noofclubs;
	}
	
	$query = "SELECT *, ";
	$query .= "(select clubname from clubstable where host=serialno) as hostname, ";
	$query .= "(select clubname from clubstable where visitor=serialno) as visitorname ";
	$query .= "from fixturestable where serialno>0 ";
	if($seasons != "") $query .= " and season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
	if($clubname != "")	$query .= " and (host='{$clubname}' or visitor='{$clubname}') ";
	if($matchdateA != "") $query .= " and matchdate>='{$matchdateA}' and matchdate<='{$matchdateB}' "; 
	if($weekA != "") $query .= " and weeks>='{$weekA}' and weeks<='{$weekB}' ";
	if($reportype=="List by Weeks") $query .= " order by weeks, matchno ";
	if($reportype=="List by Dates") $query .= " order by matchdate, matchno ";
	if($reportype=="List by Clubs") $query .= " order by host, matchno ";
	$result = mysql_query($query, $connection);
	$headerflag="";
	$printheader="No";
	$count=1;
	if(mysql_num_rows($result) > 0){
		$count=0;
		$pagelinecounter=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($reportype=="List by Weeks" && $weeks>intval($headerflag)){
				if(($linesperpage - $pagelinecounter) < $linespergroup){
					$pdf->AddPage();
					$pagelinecounter = 0;
				}
				$pagelinecounter++;
				$pdf->Ln(5);
				$pdf->Cell(100,5,"WEEK: ".$weeks,1,1,'L');
				$pdf->Ln(1);
				$headerflag=$weeks;
				$printheader="Yes";
			}

			if($reportype=="List by Dates" && $matchdate>$headerflag){
				if(($linesperpage - $pagelinecounter) < $linespergroup){
					$pagelinecounter = 0;
					$pdf->AddPage();
				}
				$matchdates=substr($matchdate,8,2)."/".substr($matchdate,5,2)."/".substr($matchdate,0,4);
				$pagelinecounter++;
				$pdf->Ln(5);
				$pdf->Cell(100,5,"MATCH DATE: ".$matchdates,1,1,'L');
				$pdf->Ln(1);
				$headerflag=$matchdate;
				$printheader="Yes";
			}

//echo $host." out ".$headerflag."\n<br>\n<br>";
			if($reportype=="List by Clubs" && $host>$headerflag){
//echo $host." in ".$headerflag."\n<br>\n<br>";
//echo ($linesperpage - $pagelinecounter)." out ".$linespergroup."\n<br>\n<br>";
				if(($linesperpage - $pagelinecounter) < $linespergroup){
//echo ($linesperpage - $pagelinecounter)." in ".$linespergroup."\n<br>\n<br>";
					$pagelinecounter = 0;
					$pdf->AddPage();
				}
				$pagelinecounter++;
				$pdf->Ln(5);
				$pdf->Cell(100,5,"CLUB NAME: ".$host,1,1,'L');
				$pdf->Ln(1);
				$headerflag=$host;
				$printheader="Yes";
			}

			if($printheader=="Yes"){
				$printheader="No";

				$pdf->Cell(10,5,"S/NO",1,0,'R');
				$pdf->Cell(48,5,"HOST TEAM",1,0,'L');
				$pdf->Cell(48,5,"VISITING TEAM",1,0,'L');
				$pdf->Cell(16,5,"WEEK",1,0,'C');
				$pdf->Cell(22,5,"MATCH NO",1,0,'C');
				$pdf->Cell(26,5,"MATCH DATE",1,0,'C');
				$pdf->Cell(20,5,"KICK OFF",1,0,'C');
				$pdf->Ln(5);
				$count=1;
				$pagelinecounter++;
			}
			$pdf->Cell(10,5,$count++.".",1,0,'R');
			$pdf->Cell(48,5,$visitorname,1,0,'L');
			$pdf->Cell(48,5,$visitorname,1,0,'L');
			$pdf->Cell(16,5,$weeks,1,0,'C');
			$pdf->Cell(22,5,$matchno,1,0,'C');
			$matchdates=substr($matchdate,8,2)."/".substr($matchdate,5,2)."/".substr($matchdate,0,4);
			$kickoff=substr($matchdate,11,8);
			$pdf->Cell(26,5,$matchdates,1,0,'C');
			$pdf->Cell(20,5,$kickoff,1,0,'C');
			$pdf->Ln(5);
			$pagelinecounter++;
		}
	}
	$pdf->Output();
?>
