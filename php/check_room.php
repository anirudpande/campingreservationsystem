<?php
	session_start ();
	
	$DB_conn	= '';
	$DB_SQL		= '';
	$DB_ResultSet	= '';
	
	$iIsSessionValid	= 0;
	
	if (isset ($_SESSION ['USERID']) && strlen ($_SESSION ['USERID']) > 0)
	{
		if (isset ($_SESSION ['DB_NAME']) && strlen ($_SESSION ['DB_NAME']) > 0)
		{
			$iIsSessionValid	= 1;
		}
		else
		{
			$iIsSessionValid	= 0;
		}
	}
	else
	{
		$iIsSessionValid	= 0;
	}
	
	if ($iIsSessionValid == 0)
	{
		session_destroy ();
		
		echo 'http://localhost:9998/Pro/login.html';
		
		exit ();
	}
	
	if (isset ($_POST ['sStartDateTime']) && strlen ($_POST ['sStartDateTime']) > 0)
	{
		$iIsSessionValid = 1;
	}
	else
	{
		$iIsSessionValid = 0;
	}
	
	if (isset ($_POST ['sEndDateTime']) && strlen ($_POST ['sEndDateTime']) > 0)
	{
		$iIsSessionValid = 1;
	}
	else
	{
		$iIsSessionValid = 0;
	}
	
	// Establish DB Connectivity
	$DB_conn	= new mysqli ('localhost', 'root','root', 'CRS', 3307);
		
	if ($_SERVER ['REQUEST_METHOD']	== 'POST' && $iIsSessionValid == 1)
	{
		//get campid
		$DB_SQL1	='SELECT CAMPING_ID, MAX_SLOTS FROM CAMPING_SITE where STATES= "' .  $_SESSION ['STATE'] . '" AND NAME= "' . $_SESSION ['CAMP_NAME'] . '" AND CITY="' . $_SESSION ['CITY'] .'"';
		
		//echo $DB_SQL1;
		$DB_ResultSet1	= $DB_conn->query ($DB_SQL1);
		if ($DB_ResultSet1->num_rows > 0)
		{
			while ($row = $DB_ResultSet1->fetch_assoc ())
			{
				$cid    = $row ['CAMPING_ID'];
				$maxslots = $row['MAX_SLOTS'];
			}
		}
		
		//check if there are slots available for the time period
		$startTime = strtotime($_POST ['sStartDateTime']);
		$endTime = strtotime($_POST ['sEndDateTime']);
		$maxslotsaloc = 0;
		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			$thisDate = date( 'Y-m-d H:i:s', $i );
			$DB_SQL	= ' SELECT max(slots_booked) FROM RESERVED_SLOTS WHERE camping_id = '.$cid.' AND '.
				  "'".$thisDate."' BETWEEN START_DATETIME AND END_DATETIME";
			$DB_ResultSet   = $DB_conn->query ($DB_SQL);
			if ($DB_ResultSet->num_rows > 0)
			{
				while ($row = $DB_ResultSet->fetch_array(MYSQLI_BOTH))
				{
					$slotsbooked = $row[0];
				}
			}
			if($slotsbooked>$maxslotsaloc)
			{
				$maxslotsaloc = $slotsbooked;
			}
		}		
		$slots_ava = $maxslots - $maxslotsaloc;
		if($slots_ava >= $_POST['slots'])
		{
			echo 0;
		}
		else
		{
			echo 1;
		}
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
