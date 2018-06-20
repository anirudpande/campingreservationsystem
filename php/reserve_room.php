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
		$DB_SQL1	='SELECT CAMPING_ID,DESC_ID FROM CAMPING_SITE where STATES= "' .  $_SESSION ['STATE'] . '" AND NAME= "' . $_SESSION ['CAMP_NAME'] . '" AND CITY="' . $_SESSION ['CITY'] .'"';
				$DB_ResultSet1	= $DB_conn->query ($DB_SQL1);
			if ($DB_ResultSet1->num_rows > 0)
			{
				while ($row = $DB_ResultSet1->fetch_assoc ())
				{
					$desc	= $row ['DESC_ID'];
					$cid    = $row ['CAMPING_ID'];
				}
			}
		
		$DB_SQL		= 'INSERT INTO RESERVED_SLOTS (`CAMPING_ID`, `START_DATETIME`, `END_DATETIME`, `USERID`, `SLOTS_BOOKED`) VALUES ('
						. $cid . ', '. "'".$_POST ['sStartDateTime'] ."'". ',' ."'". $_POST ['sEndDateTime'] ."'". ','."'".
						$_SESSION ['USERID'] ."'". ','. $_POST ['slots']. ')';			

		$DB_ResultSet   = $DB_conn->query ($DB_SQL);
		
	}
	
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
