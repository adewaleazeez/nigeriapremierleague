<?php
	$option = str_replace("'", "`", trim($_GET['option']));
	$leaguenames = str_replace("'", "`", trim($_GET['leaguename']));
	if($leaguenames==null) $leaguenames="";
	$seasons = str_replace("'", "`", trim($_GET['season']));
	if($seasons==null) $seasons="";
	$clubnames = str_replace("'", "`", trim($_GET['clubname']));
	if($clubnames==null) $clubnames="";
	$week = str_replace("'", "`", trim($_GET['week']));
	if($week==null) $week="";
	$matchnos = str_replace("'", "`", trim($_GET['matchno']));
	if($matchnos==null) $matchnos="";
	$userNames = str_replace("'", "`", trim($_GET['userName'])); 
	$serialnos = str_replace("'", "`", trim($_GET['serialno']));
	$accesss = str_replace("'", "`", trim($_GET['access']));
	$pages = str_replace("'", "`", trim($_GET['page']));
	$menus = str_replace("'", "`", trim($_GET['menu']));
	$actives = str_replace("'", "`", trim($_GET['active']));
	$currentusers = str_replace("'", "`", trim($_GET['currentuser']));
	$menuoption = str_replace("'", "`", trim($_GET['menuoption']));
	$access = str_replace("'", "`", trim($_GET['access']));
	$param = str_replace("'", "`", trim($_GET['param']));
	$param2 = str_replace("'", "`", trim($_GET['param2']));
	$table = str_replace("'", "`", trim($_GET['table']));
	$currentobject = str_replace("'", "`", trim($_GET['currentobject']));
	include("data.php");

	if($option == "checkAccess"){
		$query = "SELECT * FROM usersmenu where userName = '{$currentusers}' and menuOption = '{$menuoption}'";
		$result = mysql_query($query, $connection);
		$resp="checkAccess";
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);

			if($accessible == "Yes"){
				$resp="checkAccessSuccess";
			}else{
				$resp="checkAccessFailed".$menuoption;
			}
		}else{
			$resp="checkAccessFailed".$menuoption;
		}
		echo $resp;
	}

	if($option == "copyClubs"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		$parameter2 = explode("_~_", $param2);
		$count=0;
		foreach($parameter2 as $code){
			$count++;
			$parameter3 = explode("!!!", $code);
			$query = "SELECT * FROM clubstable where clubname = '{$parameter3[0]}' and longname='{$parameter3[1]}' and clubalias='{$parameter3[2]}' and leaguename='{$parameter1[1]}' and season='{$parameter1[0]}' and stadium='{$parameter3[4]}' "; //and ranks='{$parameter3[3]}' 
//echo $query;				
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query="insert into clubstable (clubname,longname,clubalias,leaguename,ranks,season,stadium) values ('{$parameter3[0]}','{$parameter3[1]}','{$parameter3[2]}','{$parameter1[1]}',{$count},'{$parameter1[0]}','{$parameter3[4]}')";
				mysql_query($query, $connection);
			}
		}
		$option="getAllRecs"; 
		$table="clubstable";
		$seasons=$parameter1[0];
		$leaguenames=$parameter1[1];
		setcookie('myquery', $query, false);
	}

	if($option == "copyPlayers"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		$parameter2 = explode("_~_", $param2);
		foreach($parameter2 as $code){
			$parameter3 = explode("!!!", $code);
			$query = "SELECT * FROM playerstable where regnumber = '{$parameter3[0]}' and playername='{$parameter3[1]}' and dateofbirth='{$parameter3[2]}' and clubname='{$parameter1[1]}' and season='{$parameter1[0]}' and leaguename='{$parameter1[2]}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "SELECT max(serialno) as sno FROM playerstable where regnumber = '{$parameter3[0]}' and playername='{$parameter3[1]}' and dateofbirth='{$parameter3[2]}' ";
//echo $query."<br>\n";
				$result = mysql_query($query, $connection);
				$row = mysql_fetch_array($result);
				extract ($row);
				$query = "SELECT a.regnumber, a.playerPicture, a.jerseyno, b.clubname, a.contractduration, a.teamposition FROM playerstable a, clubstable b where a.serialno= {$sno} and a.clubname=b.serialno";
//echo $query."<br>\n";
				$result = mysql_query($query, $connection);
				$row = mysql_fetch_array($result);
				extract ($row);
				$query="insert into playerstable (regnumber,playername,dateofbirth,clubname,season,leaguename,playerPicture,jerseyno,previousclub,contractduration,teamposition) values ('{$parameter3[0]}','{$parameter3[1]}','{$parameter3[2]}','{$parameter1[1]}','{$parameter1[0]}','{$parameter1[2]}','{$row[1]}','{$row[2]}','{$row[3]}','','{$row[5]}')";
//echo $query."<br>\n";
				mysql_query($query, $connection);
			}
		}
		$option="getAllRecs"; 
		$table="playerstable";
		$seasons=$parameter1[0];
		$clubnames=$parameter1[1];
	}

	if($option == "generateFixture"){
		$query = "SELECT * FROM {$table} where season='{$seasons}' and leaguename='{$leaguenames}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$query = "SELECT * FROM clubstable where season='{$seasons}' and leaguename='{$leaguenames}' order by ranks";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$count=1;
				$resp="";
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					if($row[5]!=$count){
						$resp="clubranknotserial";
						break;
					}
					$count++;
				}

				$row = mysql_fetch_array($result);
				extract ($row);

				$noofclubs = mysql_num_rows($result);
				if(($noofclubs % 2)!=0){
					echo "oddnoofclubs";
					return true;
				}else if($resp=="clubranknotserial"){
					echo $resp;
					return true;
				}else{
					$noofmatches = $noofclubs * ($noofclubs -1);
					$noofweeks = ($noofclubs -1) * 2;
					$fixtures="";
					$fixtures=array();
					for($k=0; $k<$noofmatches; $k++)$fixtures[$k] = array(array(""),array(""),array(""));
					$count=0;
					$k=0;
					for($k=0; $k<($noofclubs/2); $k++){
						$fixtures[$k][0] = ++$count;
						$fixtures[$k][1] = ++$count;
						$fixtures[$k][2] = 1;
					}

					for($j=2; $j<=($noofweeks/2) ; $j++){
						if(($j % 2)==0){
							for($l=0; $l<(($noofclubs/2)-1); $l++){
								$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
								$fixtures[$k][1] = $fixtures[($k-($noofclubs/2))+1][0];
								$fixtures[$k][2] = $j;
								$k++;
							}
							$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
							$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)-(($noofclubs/2)-1)][0];
							$fixtures[$k][2] = $j;
							$k++;
						}else{
							$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
							$fixtures[$k][1] = $fixtures[$k-1][1];
							$fixtures[$k][2] = $j;
							$k++;
							for($l=1; $l<(($noofclubs/2)-1); $l++){
								$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
								$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)-1][0];
								$fixtures[$k][2] = $j;
								$k++;
							}
							$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)-1][0];
							$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)][0];
							$fixtures[$k][2] = $j;
							$k++;
						}
					}

					/* 2nd Round Top Down Approach (20->1, 21->2, ..........38->19)
					$m=0;
					for(; $k<($noofmatches); $k++){
						$fixtures[$k][0] = $fixtures[$m][1];
						$fixtures[$k][1] = $fixtures[$m][0];
						$fixtures[$k][2] = intval($fixtures[$m][2])+($noofclubs -1);
						$m++;
					}*/

					/* 2nd Round Bottom Up  Approach (20->19, 21->18, 22->17, .........38->1)
					$m=$k-1;
					for(; $k<($noofmatches); $k++){
						$fixtures[$k][0] = $fixtures[$m][1];
						$fixtures[$k][1] = $fixtures[$m][0];
						$fixtures[$k][2] = ($noofclubs+($noofclubs-1)) - intval($fixtures[$m][2]);
						$m--;
					}*/

					// 2nd Round Hybrid Approach ((20->19, 21->1, 22->2, ............38->18)
					$m=$k-1;
					for(; $k<($noofmatches); $k++){
						if($k >= (($noofmatches/2)+($noofclubs/2))){
							$fixtures[$k][0] = $fixtures[$k - (($noofmatches/2)+($noofclubs/2)) ][1];
							$fixtures[$k][1] = $fixtures[$k - (($noofmatches/2)+($noofclubs/2)) ][0];
							$fixtures[$k][2] = ($noofclubs + ($noofclubs-1)) - intval($fixtures[$m][2]);
						}else{
							$fixtures[$k][0] = $fixtures[$m][1];
							$fixtures[$k][1] = $fixtures[$m][0];
							$fixtures[$k][2] = ($noofclubs + ($noofclubs-1)) - intval($fixtures[$m][2]);
						}
						$m--;
					}

					for($k=0; $k<count($fixtures); $k++){
						//echo $fixtures[$k][0].", ".$fixtures[$k][1].", ".$fixtures[$k][2]."   $k<br>\n";
						$hostclub="";
						$visitclub="";
						$query = "SELECT serialno FROM clubstable where season='{$seasons}' and leaguename='{$leaguenames}' and ranks='{$fixtures[$k][0]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) > 0){
							$row = mysql_fetch_array($result);
							extract ($row);
							$hostclub=$serialno;
						}
						
						$query = "SELECT serialno FROM clubstable where season='{$seasons}' and leaguename='{$leaguenames}' and ranks='{$fixtures[$k][1]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) > 0){
							$row = mysql_fetch_array($result);
							extract ($row);
							$visitclub=$serialno;
						}
						$matchnos= $k+1;
						$query="insert into fixturestable (host, visitor, weeks, matchno, leaguename, season, matchdate) values ('{$hostclub}', '{$visitclub}', '{$fixtures[$k][2]}', {$matchnos}, '{$leaguenames}', '{$seasons}', '0000-00-00')";
//echo $query;						
						mysql_query($query, $connection);
					}
					$option="getAllRecs"; 
					$table="fixturestable";
				}
			}else{
				echo "noclubs4fixture";
				return true;
			}
		}else{
			$option="getAllRecs"; 
			$table="fixturestable";
		}
		$option="getAllRecs"; 
		$table="fixturestable";
	}

	if($option == "updateFixtureDate"){
		if(strlen($param)>=10){
			$query="update fixturestable set matchdate='{$param}' where serialno='{$serialnos}'";
			mysql_query($query, $connection);
			$query="update matchestable set matchdate='{$param}' where season='{$seasons}' and leaguename='{$leaguenames}' and matchno={$matchnos}";
			mysql_query($query, $connection);
		}
	}

	if($option == "deleteFixtures"){
		$query="select * from matchestable where season='{$seasons}' and leaguename='{$leaguenames}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result)>0){
			echo $table."recordused";
		}else{
			$query="delete from fixturestable where season='{$seasons}' and leaguename='{$leaguenames}' ";
			mysql_query($query, $connection);
			$option="getAllRecs"; 
			$table="fixturestable";
		}
	}

	if($option == "generateMatch"){
		$query = "SELECT * FROM fixturestable where season='{$seasons}' and leaguename='{$leaguenames}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result)>0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$queryB = "SELECT * FROM matchestable where season='{$row[6]}' and leaguename='{$row[4]}'  and matchno={$row[5]} ";
				$resultB = mysql_query($queryB, $connection);
				if(mysql_num_rows($resultB)==0){
					$queryC = "insert into matchestable (host, visitor, weeks, hostscore, visitorscore, leaguename, matchno, season, matchdate, playflag, recordlock) values ('{$row[1]}', '{$row[2]}', {$row[3]}, 0, 0, '{$row[4]}', {$row[5]}, '{$row[6]}', '{$row[7]}', 'No', '')";
					mysql_query($queryC, $connection);
				}
			}
		}
		$option="getAllRecs"; 
		$table="matchestable";
	}

	if($option == "deleteMatches"){
		$query="select * from goalstable where season='{$seasons}' and leaguename='{$leaguenames}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result)>0){
			echo $table."recordused";
		}else{
			$query="delete from matchestable where season='{$seasons}' and leaguename='{$leaguenames}' ";
			mysql_query($query, $connection);
			$option="getAllRecs"; 
			$table="matchestable";
		}
	}

	if($option == "deletePic"){
		$query="update playerstable set playerPicture='' where serialno={$serialnos} ";
		mysql_query($query, $connection);
		$option="getAllRecs"; 
	}

	if($option == "updateGoals"){
		$parameter = explode("][", $param);
		$seasons=$parameter[4];
		$week=$parameter[5];
		$leaguenames=$parameter[6];
		$query = "update matchestable set hostscore={$parameter[1]}, visitorscore={$parameter[2]}, playflag='{$parameter[3]}' where serialno={$parameter[0]} ";
		mysql_query($query, $connection);
		$option="getAllRecs"; 
		$table="matchestable";
	}

	if($option == "updateLocks"){
		$currentuser = $_COOKIE['currentuser'];
		$query="select * from usersmenu  where userName='{$currentuser}' and menuOption='Lock Matches Records'";
		$result=mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
			$accessible=$row[3];
			if($accessible=='No'){
				echo "locknotallowedLock Matches Records";
				return true;
			}
		}
		$parameter = explode("][", $param);
		$serialno=$parameter[0];
		$query = "update matchestable set recordlock='{$parameter[1]}'  where serialno={$parameter[0]} ";
		mysql_query($query, $connection);
		$option="getAllRecs"; 
		$table="matchestable";
	}

	if($option == "goalsUpdate"){
		$param = explode("][", $param);
		$serialnos=$param[0];
		$regnos=$param[1];
		$players=$param[2];
		$clubs=$param[3];
		$seasons=$param[4];
		$leaguenames=$param[5];
		$goaltimes=$param[6];
		$week=$param[7];
		$matchnos=$param[8];
		$activitys=$param[9];
		$option=$param[10];
		
		if($option=="save"){
			$query = "insert into goalstable (regnumber, playername, clubname, season, leaguename, goaltime, weeks, matchno, activity) values ('{$regnos}', '{$players}', '{$clubs}', '{$seasons}', '{$leaguenames}', '{$goaltimes}', {$week}, {$matchnos}, '{$activitys}') ";
		}

		if($option=="update"){
			$query = "update goalstable set regnumber='{$regnos}', playername='{$players}', clubname='{$clubs}', season='{$seasons}', leaguename='{$leaguenames}', goaltime='{$goaltimes}', weeks={$week}, matchno={$matchnos}, activity='{$activitys}'  where serialno={$serialnos} ";
		}
		if($option=="delete"){
			$query = "delete from goalstable where serialno={$serialnos} ";
		}
		mysql_query($query, $connection);
		$param2 = explode("][", $param2);
		$official=$param2[0];
		$spectator=$param2[1];
		$report=$param2[2];
		$commissioners=$param2[3];
		$report2=$param2[4];

		$query = "select count(*) as goals from goalstable where season='{$seasons}' and leaguename='{$leaguenames}'  and matchno={$matchnos} and weeks={$week} and clubname='{$clubs}' and activity='Goal' ";
		$result = mysql_query($query, $connection);
		$score=0;
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
			$score=$row[0];
		}
		
		$query = "select * from matchestable where season='{$seasons}' and leaguename='{$leaguenames}'  and matchno={$matchnos} and weeks={$week} ";
		$result = mysql_query($query, $connection);
		$thehost="";
		$thevisit="";
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
			$thehost=$row[1];
			$thevisit=$row[2];
		}
		if($clubs==$thehost){
			$query = "update matchestable set matchofficial='{$official}', officialreport='{$report}', commissioner='{$commissioners}', commissionerreport='{$report2}', spectators={$spectator}, hostscore={$score}, playflag='Yes' where season='{$seasons}' and leaguename='{$leaguenames}'  and matchno={$matchnos} and weeks={$week} ";
		}else{
			$query = "update matchestable set matchofficial='{$official}', officialreport='{$report}', commissioner='{$commissioners}', commissionerreport='{$report2}', spectators={$spectator}, visitorscore={$score}, playflag='Yes' where season='{$seasons}' and leaguename='{$leaguenames}'  and matchno={$matchnos} and weeks={$week} ";
		}
		mysql_query($query, $connection);

		$option="getAllRecs"; 
		$table="goalstable";
	}

	if($option == "getAllRecs"  || $option=="getRecordlist"  || $option=="getARecord"){
		$query = "SELECT * FROM {$table} ";
		if(($table=="clubstable" || $table=="clubstableB") && $option == "getAllRecs") {
			$query = "SELECT a.*, b.leaguename, c.season FROM clubstable a, leaguetype b, seasonstable c ";

			$query .= " where a.clubname<>'' ";

			if($seasons != "")
				$query .= " and a.season='{$seasons}' "; 

			if($leaguenames != "")
				$query .= " and a.leaguename='{$leaguenames}' "; 
		
			$query .= " and a.leaguename=b.serialno and a.season=c.serialno "; 
			if($access=="") $access = "clubname";

			$query .= " order by ".$access;
			//if($_COOKIE['sortorder']=="DESC"){
			//	setcookie("sortorder", "ASC", false);
			//}else{
			//	setcookie("sortorder", "DESC", false);
			//}
			if($menuoption=="DESC"){
				$query .= " ASC";
			}else{
				$query .= " ".$_COOKIE['sortorder'];
			}
		}

		if(($table=="playerstable" || $table=="playerstableB") && $option == "getAllRecs") {
			$query = "SELECT * FROM playerstable ";

			$query .= " where playername<>'' ";

			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
		
			if($seasons != "")
				$query .= " and season='{$seasons}' "; 

			if($clubnames != "")
				$query .= " and clubname='{$clubnames}' "; 
		
			if($access=="") $access = "regnumber";

			$query .= " order by ".$access;
			//if($_COOKIE['sortorder']=="DESC" || $menuoption=="DESC"){
			//	setcookie("sortorder", "ASC", false);
			//}else{
			//	setcookie("sortorder", "DESC", false);
			//}
			if($menuoption=="DESC"){
				$query .= " ASC";
			}else{
				$query .= " ".$_COOKIE['sortorder'];
			}
//echo $query;
		}

		if($table=="fixturestable" && $option == "getAllRecs") {
			$query = "SELECT *, ";
			
			$query .= "(select clubname from clubstable where host=serialno) as hostname, ";

			$query .= "(select clubname from clubstable where visitor=serialno) as visitorname FROM fixturestable ";

			$query .= " where host<>'' ";

			if($seasons != "")
				$query .= " and season='{$seasons}' "; 

			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
		
			if($week != "")
				$query .= " and weeks={$week} "; 
		
			if($access=="") $access = "weeks";

			$query .= " order by ".$access;
			//if($_COOKIE['sortorder']=="DESC"){
			//	setcookie("sortorder", "ASC", false);
			//}else{
			//	setcookie("sortorder", "DESC", false);
			//}
			if($menuoption=="DESC"){
				$query .= " ASC";
			}else{
				$query .= " ".$_COOKIE['sortorder'].", matchno";
			}
			
//echo $query;
		}

		if($table=="matchestable" && $option == "getAllRecs") {
			$query = "SELECT *, ";
			
			$query .= "(select clubname from clubstable where host=serialno) as hostname, ";

			$query .= "(select clubname from clubstable where visitor=serialno) as visitorname FROM matchestable ";

			$query .= " where host<>'' ";

			if($seasons != "")
				$query .= " and season='{$seasons}' "; 

			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
		
			if($week != "")
				$query .= " and weeks={$week} "; 
		
			if($access=="") $access = "weeks";

			$query .= " order by ".$access;
			//if($_COOKIE['sortorder']=="DESC"){
			//	setcookie("sortorder", "ASC", false);
			//}else{
			//	setcookie("sortorder", "DESC", false);
			//}
			if($menuoption=="DESC"){
				$query .= " ASC";
			}else{
				$query .= " ".$_COOKIE['sortorder'].", matchno";
			}
			
		}

		if($table=="goalstable" && $option == "getAllRecs") {
			$query = "SELECT * FROM goalstable ";

			$query .= " where playername<>'' ";

			if($seasons != "")
				$query .= " and season='{$seasons}' "; 

			if($leaguenames != "")
				$query .= " and leaguename='{$leaguenames}' "; 
		
			if($week != "")
				$query .= " and weeks={$week} "; 
		
			if($matchnos != "")
				$query .= " and matchno={$matchnos} "; 
		

			$query .= " order by leaguename, season, weeks, matchno, clubname, goaltime";
		}


		if($table=="seasonstable" && $option == "getAllRecs") {
			$query = "SELECT a.*, b.leaguename FROM seasonstable a, leaguetype b ";
			$query .= " where a.leaguename = b.serialno order by a.season desc";
		}

		if($table=="leaguetype" && $option == "getAllRecs") {
			$query .= " order by leaguename desc";
		}

		if($option=="getRecordlist"){
			if(substr($currentobject, 0, 6)=="season"){
				$table = "seasonstable";
				$query = "SELECT DISTINCT season, serialno FROM {$table} order by season desc";
			}
			if(substr($currentobject, 0, 4)=="week"){
				$query = "SELECT DISTINCT weeks,weeks FROM {$table} where weeks <>0 ";
				if($seasons != "") $query .= " and season='{$seasons}' "; 
				//if($week != "") $query .= " and weeks='{$week}' "; 
				if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
				$query .= " order by weeks";
			}

			if(substr($currentobject, 0, 10)=="leaguename"){
				$table = "leaguetype";
				$query = "SELECT DISTINCT leaguename, serialno FROM {$table} order by leaguename desc";
			}
			if(substr($currentobject, 0, 8)=="clubname"){
				$table = "clubstable";
				$query = "SELECT DISTINCT clubname, serialno FROM {$table} where clubname <>'' ";
				if($seasons != "") $query .= " and season='{$seasons}' "; 
				if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
				$query .= " order by clubname";
//echo $query;				
			}
			if(substr($currentobject, 0, 10)=="playername")
				$query = "SELECT DISTINCT playername, serialno FROM {$table} order by playername";
			if(substr($currentobject, 0, 9)=="regnumber"){
				$query = "SELECT DISTINCT playername, regnumber, playername FROM {$table} where playername<>''  ";
				if($clubnames != "") $query .= " and clubname='{$clubnames}' "; 
				if($leaguenames != "") $query .= " and leaguename='{$leaguenames}' "; 
				if($seasons != "") $query .= " and season='{$seasons}' ";
				$query .= " order by playername";
			}
			
			if($table=="regularstudents")
				$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where active='Yes' order by regNumber, firstName";
			if($table=="regularstudents" && substr($currentobject, 0, 5)=="matno")
				$query = "SELECT serialno, regNumber, lastName, firstName FROM {$table} where studentlevel='{$studentlevels}' and active='Yes' order by regNumber, lastName";
			if($table=="regularstudents" && substr($currentobject, 0, 9)=="matricno4")
				$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where  facultycode='{$facultycodes}'  and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and entryyear='{$entryyears}'  and active='Yes' order by regNumber, firstName";
			if(substr($currentobject, 0, 9)=="entryyear")
			//	$query = "SELECT DISTINCT entryyear, entryyear FROM {$table} order by entryyear";
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription";
		}

		if($option == "getARecord") $query = "SELECT * FROM {$table} where serialno='{$serialnos}'";
		if($option == "getARecord" && $table=="matchestable") $query = "SELECT * FROM {$table} where season='{$seasons}' and leaguename='{$leaguenames}' and matchno={$matchnos} and weeks={$week} ";
		if($option == "getARecord" && $table=="seasonstable") $query = "SELECT a.*, b.leaguename FROM seasonstable a, leaguetype b where a.leaguename = b.serialno and a.serialno='{$serialnos}'";
		$resp=$option;
//echo $query;
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$resp="";
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				foreach($row as $i => $value){
			        if ($option=="getAllRecs" || $option=="getRecordlist") {
		                $resp .= $value."_~_";
	                } else {
						$resp .= "getARecord" . $value;
					}
				}
				if ($option=="getAllRecs" || $option=="getRecordlist") $resp .= $option;
			}
			if ($option=="getAllRecs") $resp = $table . $option . $resp;
			if ($option=="getARecord") $resp = $table . $resp . $option;
        }else{
			if ($option=="getAllRecs") $resp = $table . $option;
		}
		echo $resp;
    }

	if($option == "addRecord"){
		$parameters = explode("][", $param);
		if($table=="seasonstable") 
			$query = "SELECT * FROM {$table} where season ='{$parameters[1]}'";
		if($table=="leaguetype") 
			$query = "SELECT * FROM {$table} where leaguename ='{$parameters[1]}'";
		if($table=="clubstable") 
			$query = "SELECT * FROM {$table} where season ='{$parameters[6]}' and clubname ='{$parameters[1]}'";
		if($table=="playerstable") 
			$query = "SELECT * FROM {$table} where season ='{$parameters[5]}' and regnumber ='{$parameters[1]}'";
		
		$result = mysql_query($query, $connection);

		if(mysql_num_rows($result) == 0){
			$query = "select max(serialno) as id from {$table}";
			$result = mysql_query($query, $connection);
			$row = mysql_fetch_array($result);
			extract ($row);
			$serialnos = intval($id)+1;

			$query = "INSERT INTO {$table} (serialno) VALUES ('{$serialnos}')";
			$result = mysql_query($query, $connection);

			$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
			$result = mysql_query($query, $connection);

			if(mysql_num_rows($result) > 0){
				$record="";
				$count=0;
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					foreach($row as $i => $value){
						$meta = mysql_fetch_field($result, $i);
						if($count > 0){
							$record .= $meta->name . "='".$parameters[$count++]."', ";
						}else{
							$count++;
						}
					}
				}
				$record = substr($record, 0, strlen($record)-2);
				$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
			}

			echo $table."inserted";
		}else {
			echo "recordexists";
		}
	}

	if($option == "updateRecord"){
		$parameters = explode("][", $param);
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		//if($table=="seasonstable") 
		//	$query = "SELECT * FROM {$table} where season ='{$parameters[2]}'";
		//if($table=="leaguetype") 
		//	$query = "SELECT * FROM {$table} where leaguename ='{$parameters[1]}'";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			if($table=="seasonstable") 
				$query = "SELECT * FROM fixturestable where season ='{$parameters[2]}'";
			if($table=="leaguetype") 
				$query = "SELECT * FROM fixturestable where leaguename ='{$parameters[1]}'";
			if($table=="clubstable") 
				$query = "SELECT * FROM fixturestable where season ='{$parameters[6]}' and (host ='{$parameters[1]}' or guest ='{$parameters[1]}')";
			//if($table=="playerstable") 
			//	$query = "SELECT * FROM goalstable where season ='{$parameters[5]}' and regnumber ='{$parameters[1]}' ";

			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0 || $table=="playerstable"){
				$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
				$record="";
				$count=0;
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					foreach($row as $i => $value){
						$meta = mysql_fetch_field($result, $i);
						if($count > 0){
							$record .= $meta->name . "='".$parameters[$count++]."', ";
						}else{
							$count++;
						}
					}
				}
				$record = substr($record, 0, strlen($record)-2);
				$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
				echo $table."updated";
			}else{
				echo $table."recordused";
			}

		} else {
			echo "recordnotexist";
		}
	}

	if($option == "deleteRecord"){
		$parameters = explode("][", $param);
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		//if($table=="seasonstable") 
		//	$query = "SELECT * FROM {$table} where season ='{$parameters[2]}'";
		//if($table=="leaguetype") 
		//	$query = "SELECT * FROM {$table} where leaguename ='{$parameters[1]}'";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			if($table=="seasonstable") 
				$query = "SELECT * FROM fixturestable where season ='{$parameters[2]}'";
			if($table=="leaguetype") 
				$query = "SELECT * FROM fixturestable where leaguename ='{$parameters[1]}'";
			if($table=="clubstable") 
				$query = "SELECT * FROM fixturestable where season ='{$parameters[6]}' and (host ='{$parameters[1]}' or visitor ='{$parameters[1]}')";
			if($table=="playerstable") 
				$query = "SELECT * FROM goalstable where season ='{$parameters[5]}' and regnumber ='{$parameters[1]}' ";

			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "DELETE FROM {$table} where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
				echo $table."deleted";
			}else{
				echo $table."recordused";
			}
		} else {
			echo "recordnotexist";
		}
	}

?>
