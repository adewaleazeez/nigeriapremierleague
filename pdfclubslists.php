<?php

	global $leaguenames;
	$leaguenames = trim($_GET['leaguename']);
	if($leaguenames == null) $leaguenames = "";

	global $seasons;
	$seasons = trim($_GET['season']);
	if($seasons == null) $seasons = "";

	global $seasonames;
	$seasonames = trim($_GET['seasoname']);
	if($seasonames == null) $seasonames = "";

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
			$seasonames = $GLOBALS['seasonames'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(190,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(190,7,'THE CLUBS LIST',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(190,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasonames!=null && $seasonames!=""){
				$this->Cell(190,7,$seasonames.' SEASON',0,0,'C');
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

	$query = "select * from clubstable where serialno>0 ";
	if($seasons != "") $query .= " and season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
	$query .= " order by clubname ";
	$result = mysql_query($query, $connection);
	$headerflag="";
	$printheader="Yes";
	$count=1;
	if(mysql_num_rows($result) > 0){
		$count=0;
		$pagelinecounter=1;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			
			if($pagelinecounter==$linesperpage){
				$pdf->AddPage();
				$pagelinecounter = 1;
				$printheader="Yes";
			}

			if($printheader=="Yes"){
				$printheader="No";

				$pdf->Cell(10,5,"S/NO",1,0,'R');
				$pdf->Cell(45,5,"CLUB NAME",1,0,'L');
				$pdf->Cell(65,5,"FULL CLUB NAME",1,0,'L');
				$pdf->Cell(30,5,"CLUB ALIAS",1,0,'L');
				$pdf->Cell(45,5,"STADIUM",1,0,'L');
				$pdf->Ln(5);
				$count=1;
				$pagelinecounter++;
			}

			$pdf->Cell(10,5,$count++.".",1,0,'R');
			$pdf->Cell(45,5,$clubname,1,0,'L');
			$pdf->Cell(65,5,$longname,1,0,'L');
			$pdf->Cell(30,5,$clubalias,1,0,'L');
			$pdf->Cell(45,5,substr($stadium,0,25),1,0,'L');
			$pdf->Ln(5);
			$pagelinecounter++;
		}
	}
	$pdf->Output();
?>
