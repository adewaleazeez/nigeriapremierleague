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
			$club_names = $GLOBALS['club_names'];
			$this->Image('images/NPFL.jpeg',10,10,50,40);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(200,7,'Nigeria Professional Football League',0,0,'C');
			$this->Ln(7);
			$this->SetFont('Times','B',15);
			$this->Cell(200,7,'THE PLAYERS DETAILS LIST',0,0,'C');
			$this->Ln();
			//if($leaguenames!=null && $leaguenames!=""){
			//	$this->Cell(200,7,'LEAGUE NAME: '.$leaguenames,0,0,'C');
			//	$this->Ln();
			//}
			if($seasonames!=null && $seasonames!=""){
				$this->Cell(200,7,$seasonames.' SEASON',0,0,'C');
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

	$query = "select a.*, b.clubname from playerstable a, clubstable b where a.serialno>0 and a.clubname=b.serialno ";
	if($seasons != "") $query .= " and a.season='{$seasons}' "; 
	if($leaguenames != "") $query .= " and a.leaguename='{$leaguenames}' "; 
	if($clubnames != "")	$query .= " and a.clubname='{$clubnames}' ";
	if($regnumbers != "")	$query .= " and a.regnumber='{$regnumbers}' ";
	$query .= " order by b.clubname, a.regnumber ";
	$result = mysql_query($query, $connection);
	$theclub="";
	$count=1;

	if(mysql_num_rows($result) > 0){
		$count=0;
		$linesperpage=5;
		$pagelinecounter=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			if($regnumbers!=""){
				$dateofbirths=substr($dateofbirth,8,2)."/".substr($dateofbirth,5,2)."/".substr($dateofbirth,0,4);
				$currentY=$pdf->GetY();
				$pdf->Cell(160,10,"LICENSE NO: ".$regnumber,"TLR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"BIRTH DATE: ".$dateofbirths,"LR",0,'L');
				$currentX=$pdf->GetX();
				$pdf->Ln(10);
				$pdf->Cell(160,10,"NAMES: ".$playername,"LR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"CURRENT CLUB: ".$clubname,"LR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"PREVIOUS CLUB: ".$previousclub,"LR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"JERSEY NO: ".$jerseyno,"LR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"CONTRACT LENGTH: ".$contractduration,"LR",0,'L');
				$pdf->Ln(10);
				$pdf->Cell(160,10,"POSITION PLAYING: ".$teamposition,"LRB",0,'L');
				$pdf->Ln(15);
				$currentY2=$pdf->GetY();
				$pdf->SetY($currentY);
				$pdf->SetX($currentX);
				if($playerPicture!=null && $playerPicture!="" && file_exists('photo/'.$playerPicture)){
					$pdf->Cell(65,60,$pdf->Image('photo/'.$playerPicture,$pdf->GetX()-70,$pdf->GetY()+5,65,60),0,0,'L');
				}else{
					//$pdf->Cell(65,60,"",1,0,'L');
				}
				$pdf->SetY($currentY2);
			}else{
				if((($pagelinecounter % $linesperpage)==0 || $clubname>$theclub)&& $pagelinecounter>0){
					$pdf->AddPage();
					if($clubname>$theclub) {
						$theclub=$clubname;
						$pagelinecounter=0;
					}
				}

				$dateofbirths=substr($dateofbirth,8,2)."/".substr($dateofbirth,5,2)."/".substr($dateofbirth,0,4);
				$currentY=$pdf->GetY();
				$pdf->Cell(20,10,"S/NO: ".(++$count),1,0,'L');
				$pdf->Cell(90,10,"LICENSE NO: ".$regnumber,1,0,'L');
				$pdf->Cell(50,10,"BIRTH DATE: ".$dateofbirths,1,0,'L');
				$currentX=$pdf->GetX();
				$pdf->Ln(10);
				$pdf->Cell(160,10,"NAMES: ".$playername,1,0,'L');
				$pdf->Ln(10);
				$pdf->Cell(80,10,"CURRENT CLUB: ".$clubname,1,0,'L');
				$pdf->Cell(80,10,"PREVIOUS CLUB: ".$previousclub,1,0,'L');
				$pdf->Ln(10);
				$pdf->Cell(30,10,"JERSEY NO: ".$jerseyno,1,0,'L');
				$pdf->Cell(60,10,"CONTRACT LENGTH: ".$contractduration,1,0,'L');
				$pdf->Cell(80,10,"POSITION PLAYING: ".substr($teamposition,0,16),"LB",0,'L');
				$pdf->Ln(15);
				$currentY2=$pdf->GetY();
				$pdf->SetY($currentY);
				$pdf->SetX($currentX);
				if($playerPicture!=null && $playerPicture!="" && file_exists('photo/'.$playerPicture)){
					$pdf->Cell(35,40,$pdf->Image('photo/'.$playerPicture,$pdf->GetX(),$pdf->GetY(),35,40),1,0,'L');
				}else{
					$pdf->Cell(35,40,"",1,0,'L');
				}
				$pdf->SetY($currentY2);
				$pagelinecounter++;
				$theclub=$clubname;
			}
		}
	}
	$pdf->Output();
?>
