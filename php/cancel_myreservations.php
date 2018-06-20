<?php
	session_start ();
	
	$DB_conn	= '';
	$DB_SQL		= '';
	$DB_ResultSet	= '';
	$DB_SQL1		= '';
	$DB_ResultSet1	= '';
	$cid=0;
	
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
	
	// Establish DB Connectivity
	$DB_conn	= new mysqli ($_SESSION ['DB_SERVER'], $_SESSION ['DB_USERID'], $_SESSION ['DB_PASSWORD'], $_SESSION ['DB_NAME'],3307);
		
	if ($_SERVER ['REQUEST_METHOD']	== 'POST' && $iIsSessionValid == 1)
	{
		$DB_SQL1	='SELECT CAMPING_ID FROM CAMPING_SITE where NAME= "' .  $_POST ['sBuilding'] . '"'; 
		
		//echo $DB_SQL1;
		$DB_ResultSet1	= $DB_conn->query ($DB_SQL1);
		if ($DB_ResultSet1->num_rows > 0)
		{
			while ($row = $DB_ResultSet1->fetch_assoc ())
			{
				$cid    = $row ['CAMPING_ID'];
				
			}
		}
		
		$DB_SQL		= 'DELETE FROM RESERVED_SLOTS WHERE RESERVATION_ID='. (int) $_POST ['sRoomName'] . ' AND ' .
				  'CAMPING_ID=' . (int)$cid . ' AND START_DATETIME="' . $_POST ['sFloor'] . '" AND ' .
				  'END_DATETIME="' . $_POST ['sStartDateTime'] .'" AND SLOTS_BOOKED=' . (int)$_POST ['sEndDateTime'] .' AND ' .
				  'USERID="' . $_SESSION ['USERID'] . '"';
		
		var_dump ($DB_SQL);
		
		$DB_ResultSet   = $DB_conn->query ($DB_SQL);
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
