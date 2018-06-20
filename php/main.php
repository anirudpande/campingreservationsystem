<?php
	session_start ();
	
	$state		= '';
	$city		= '';
	$name		= '';
	$all		= '';
	
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
		if (isset ($_POST ['state']))
		{
			if (strlen ($_POST ['state']) > 0)
			{
				$state = $_POST ['state'];
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
		
		if (isset ($_POST ['city']))
		{
			if (strlen ($_POST ['city']) > 0)
			{
				$city	= $_POST ['city'];
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
		
		if (isset ($_POST ['name']))
		{
			if (strlen ($_POST ['name']) > 0)
			{
				$name	= $_POST ['name'];
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
		
		if (isset ($_POST ['all']))
		{
			if (strlen ($_POST ['all']) > 0)
			{
				$all	= $_POST ['all'];
			}
			else
			{
				$all	= '';
			}
		}
		else
		{
			$all	= '';
		}
		
		// Establish DB Connectivity
		$DB_conn	= new mysqli ('localhost', 'root','root', 'CRS', 3307);
		if ($state != '')
		{
			$DB_SQL		= 'SELECT IMAGE_PATH,NAME,states,city,FEATURES,GEOGRAPHY,RECREATION FROM CAMPING_SITE c, description d WHERE c.deletefl= 1 and c.DESC_ID = d.DESC_ID and c.states LIKE '.
					  '"%' . $state . '%"' . ' ORDER BY c.states, NAME';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
		}
		else if ($city != '')
		{
			$DB_SQL		= 'SELECT IMAGE_PATH,NAME,states,city,FEATURES,GEOGRAPHY,RECREATION FROM CAMPING_SITE c, description d WHERE c.deletefl= 1 and c.DESC_ID = d.DESC_ID and c.city LIKE '.
					  '"%' . $city . '%"' . ' ORDER BY c.states, NAME';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
		}
		else if ($name != '')
		{
			$DB_SQL		= 'SELECT IMAGE_PATH,NAME,states,city,FEATURES,GEOGRAPHY,RECREATION FROM CAMPING_SITE c, description d WHERE c.deletefl= 1 and c.DESC_ID = d.DESC_ID and c.NAME LIKE '.
					  '"%' . $name . '%"' . ' ORDER BY c.states, c.NAME';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
		}
		else if ($all != '')
		{
			// Display all entries from the table
			$DB_SQL		= 'SELECT IMAGE_PATH,NAME,states,city,FEATURES,GEOGRAPHY,RECREATION FROM CAMPING_SITE c, description d WHERE c.deletefl= 1 and c.DESC_ID = d.DESC_ID and  (c.states LIKE ' .
					  '"%' . $all . '%"' . ' OR c.NAME LIKE ' . '"%' . $all . '%"' . ' OR d.RECREATION LIKE ' .
					  '"%' . $all . '%"' . ' OR c.city LIKE ' . '"%' . $all . '%"' .
					  ' ) ORDER BY c.states, NAME';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
		}
		else
		{
			// Display all entries from the table
			$DB_SQL		= 'SELECT IMAGE_PATH,NAME,states,city,FEATURES,GEOGRAPHY,RECREATION FROM CAMPING_SITE c, description d WHERE c.deletefl = 1 and c.DESC_ID = d.DESC_ID  ' .
					  'ORDER BY c.states, NAME';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			echo '[';
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++) 
			{
				echo ($iCtr>0 ? ',':'').json_encode (mysqli_fetch_object ($DB_ResultSet));
			}
			echo ']';
		}
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
