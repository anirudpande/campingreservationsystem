<?php
	session_start ();
	
	$state	= '';
	$city		= '';
	$name		= '';
	
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
	
	if ($_SERVER ['REQUEST_METHOD']	== 'POST')
	{
		if (isset ($_SESSION ['STATE']))
		{
			if (strlen ($_SESSION ['STATE']) > 0)
			{
				$state = $_SESSION ['STATE'];
			}
			else
			{
				$state	= '';
			}
		}
		else
		{
			$state	= '';
		}
		
		if (isset ($_SESSION ['CITY']))
		{
			if (strlen ($_SESSION ['CITY']) > 0)
			{
				$city	= $_SESSION ['CITY'];
			}
			else
			{
				$city	= '';
			}
		}
		else
		{
			$city	= '';
		}
		
		if (isset ($_SESSION ['CAMP_NAME']))
		{
			if (strlen ($_SESSION ['CAMP_NAME']) > 0)
			{
				$name	= $_SESSION ['CAMP_NAME'];
			}
			else
			{
				$name	= '';
			}
		}
		else
		{
			$name	= '';
		}
		
		// Establish DB Connectivity
		$DB_conn	= new mysqli ('localhost', 'root','root', 'CRS', 3307);
		
		if ($state != '' && $city != '' && $name != '')
		{
			$DB_SQL		= 'SELECT IMAGE_PATH, NAME, features,GEOGRAPHY,RECREATION,FACILITIES, STATES, CITY,PRICE FROM camping_site c, description d WHERE c.desc_id = d.desc_id AND c.STATES= "' .  $state . '" AND c.NAME= "' . $name . '" AND c.CITY="' . $city.'"';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
			//console.log($DB_SQL);
			//echo $DB_SQL;
		}
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
