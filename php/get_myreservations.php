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
	
	// Establish DB Connectivity
	$DB_conn	= new mysqli ($_SESSION ['DB_SERVER'], $_SESSION ['DB_USERID'], $_SESSION ['DB_PASSWORD'], $_SESSION ['DB_NAME'],3307);
		
	if ($_SERVER ['REQUEST_METHOD']	== 'POST' && $iIsSessionValid == 1)
	{
		$DB_SQL	= 'SELECT  RESERVATION_ID,NAME, START_DATETIME, END_DATETIME, SLOTS_BOOKED FROM RESERVED_SLOTS r,CAMPING_SITE c WHERE USERID="'
 . $_SESSION ['USERID'] . '" and c.CAMPING_ID=r.CAMPING_ID' ;
 //. 'ORDER BY RESERVATION_ID, CAMPING_ID, START_DATETIME';
		//var_dump ($DB_SQL);
		
		$DB_ResultSet   = $DB_conn->query ($DB_SQL);
		
		echo '[';
		for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
		{
			echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
		}
		echo ']';
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
