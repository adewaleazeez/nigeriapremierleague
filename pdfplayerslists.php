<?php

	global $leaguenames;
	$leaguenames = trim($_GET['leaguename']);
	if($leaguenames == null) $leaguenames = "";

	global $seasons;
	$seasons = trim($_GET['season']);
	if($seasons == null) $seasons = "";

	global $clubnames;
	$clubnames = trim($_GET['clubname']);
	if($clubnames == null) $clubnames = "";

	global $regnumbers;
	$regnumbers = trim($_GET['regnumber']);
	if($regnumbers == null) $regnumbers = "";

	global $seasonames;
	$seasonames = trim($_GET['seasoname']);
	if($seasonames == null) $seasonames = "";

	global $club_names;
	$club_names = trim($_GET['club_name']);
	if($club_names == null) $club_names = "";

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
			$seasonames = $GLOBALS['seasonames'];
			$club_names = $GLOBALS['club_names'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(275,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(275,7,'THE PLAYERS LIST',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(275,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasonames!=null && $seasonames!=""){
				$this->Cell(275,7,$seasonames.' SEASON',0,0,'C');
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

	$query = "select a.*, b.clubname from playerstable a, clubstable b where a.serialno>0 and a.clubname=b.serialno";
	if($seasons != "") $query .= " and a.season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and a.leaguename='{$leaguenames}' "; 
	if($clubnames != "")	$query .= " and a.clubname='{$clubnames}' ";
	if($regnumbers != "")	$query .= " and a.regnumber='{$regnumbers}' ";
	$query .= " order by b.clubname, a.regnumber ";
	$result = mysql_query($query, $connection);
	$headerflag="";
	$printheader="Yes";
	$count=1;
	if(mysql_num_rows($result) > 0){
		$count=1;
		$linesperpage=12;
		$pagelinecounter=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			if($clubname>$headerflag){
				$pagelinecounter++;
				$pdf->Ln(5);
				$pdf->Cell(100,5,"CLUB NAME: ".$clubname,1,1,'L');
				$pdf->Ln(1);
				$headerflag=$clubname;
			}

			if((($pagelinecounter % $linesperpage)==0) || $clubname>$headerflag){
				$pdf->AddPage();
				$pdf->Ln(5);
				$pdf->Cell(100,5,"CLUB NAME: ".$clubname,1,1,'L');
				$pdf->Ln(1);
				if($clubname>$headerflag){
					$pagelinecounter = 1;
					$headerflag=$clubname;
					$count=1;
				}
				$pagelinecounter++;
				$printheader="Yes";
			}

			if($printheader=="Yes"){
				$printheader="No";

				$pdf->Cell(10,5,"S/NO",1,0,'R');
				$pdf->Cell(50,5,"LICENSE NO",1,0,'L');
				$pdf->Cell(70,5,"NAMES",1,0,'L');
				$pdf->Cell(25,5,"BIRTH DATE",1,0,'L');
				//$pdf->Cell(25,5,"JERSEY NO",1,0,'L');
				$pdf->Cell(60,5,"PREVIOUS CLUB",1,0,'L');
				$pdf->Cell(40,5,"CONTRACT LENGTH",1,0,'L');
				//$pdf->Cell(30,5,"POSITION PLAYED",1,0,'L');
				$pdf->Cell(20,5,"PICTURE",1,0,'C');
				$pdf->Ln(5);
				$pagelinecounter++;
			}

			$dateofbirths=substr($dateofbirth,8,2)."/".substr($dateofbirth,5,2)."/".substr($dateofbirth,0,4);
			$pdf->Cell(10,10,$count++.".",1,0,'R');
			$pdf->Cell(50,10,$regnumber,1,0,'L');
			$pdf->Cell(70,10,$playername,1,0,'L');
			$pdf->Cell(25,10,$dateofbirths,1,0,'L');
			//$pdf->Cell(25,10,$jerseyno,1,0,'L');
			$pdf->Cell(60,10,$previousclub,1,0,'L');
			$pdf->Cell(40,10,$contractduration,1,0,'L');
			//$pdf->Cell(30,10,$teamposition,1,0,'L');
			if($playerPicture!=null && $playerPicture!="" && file_exists('photo/'.$playerPicture)){
				$pdf->Cell(20,10,$pdf->Image('photo/'.$playerPicture,$pdf->GetX()+5,$pdf->GetY(),10,10),1,0,'L');
			}else{
				$pdf->Cell(20,10,"",1,0,'L');
			}
			$pdf->Ln(10);
			$pagelinecounter++;
		}
	}
	$pdf->Output();
?>
