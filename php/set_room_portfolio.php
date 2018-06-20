<?php
	session_start ();
	
	$camp_name='';
	$street_name='';
	$city='';
	$state='';
	$image_path='';
	$maxslots='';
	$features='';
	$geography='';
	$recreation='';
	$facilities='';

	$desc		= '';
	
	$DB_conn	= '';
	$DB_SQL		= '';
	$DB_ResultSet	= '';
	$DB_SQL1		= '';
	$DB_ResultSet1	= '';
	$DB_SQL2		= '';
	$DB_ResultSet2	= '';
	
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
	
	$iIsSessionValid	= 0;
	
	if ($_SERVER ['REQUEST_METHOD']	== 'POST')
	{
		if (isset ($_POST ['camp']))
		{
			if (strlen ($_POST ['camp']) > 0)
			{
				$camp_name = $_POST ['camp'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$camp_name	= '';
			}
		}
		else
		{
			$camp_name	= '';
		}
		
		if (isset ($_POST ['street']))
		{
			if (strlen ($_POST ['street']) > 0)
			{
				$street_name	= $_POST ['street'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$street_name	= '';
			}
		}
		else
		{
			$street_name	= '';
		}
		
		if (isset ($_POST ['city']))
		{
			if (strlen ($_POST ['city']) > 0)
			{
				$city	= $_POST ['city'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
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
		
		if (isset ($_POST ['state']))
		{
			if (strlen ($_POST ['state']) > 0)
			{
				$state	= $_POST ['state'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
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
		
		if (isset ($_POST ['slots']))
		{
			if (strlen ($_POST ['slots']) > 0)
			{
				$slots	= $_POST ['slots'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$slots	= '';
			}
		}
		else
		{
			$slots	= '';
		}
		
		if (isset ($_POST ['image_path']))
		{
			if (strlen ($_POST ['image_path']) > 0)
			{
				$image_path	= $_POST ['image_path'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$image_path	= '';
			}
		}
		else
		{
			$image_path	= '';
		}
		
		if (isset ($_POST ['maxslots']))
		{
			if (strlen ($_POST ['maxslots']) > 0)
			{
				$maxslots	= $_POST ['maxslots'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$maxslots	= '';
			}
		}
		else
		{
			$maxslots	= '';
		}
		
		if (isset ($_POST ['features']))
		{
			if (strlen ($_POST ['features']) > 0)
			{
				$features	= $_POST ['features'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$features	= '';
			}
		}
		else
		{
			$features	= '';
		}
		
		if (isset ($_POST ['geography']))
		{
			if (strlen ($_POST ['geography']) > 0)
			{
				$geography	= $_POST ['geography'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$geography	= '';
			}
		}
		else
		{
			$recreation	= '';
		}
		
		if (isset ($_POST ['recreation']))
		{
			if (strlen ($_POST ['recreation']) > 0)
			{
				$recreation	= $_POST ['recreation'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$recreation	= '';
			}
		}
		else
		{
			$recreation	= '';
		}
		
		if (isset ($_POST ['facilities']))
		{
			if (strlen ($_POST ['facilities']) > 0)
			{
				$facilities	= $_POST ['facilities'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$facilities	= '';
			}
		}
		else
		{
			$facilities	= '';
		}
		
		// Establish DB Connectivity
		//$DB_conn	= new mysqli ($_SESSION ['DB_SERVER'], $_SESSION ['DB_USERID'], $_SESSION ['DB_PASSWORD'], $_SESSION ['DB_NAME'],3307);
		$DB_conn	= new mysqli ('localhost', 'root','root', 'CRS', 3307);
		
		
		if ($iIsSessionValid >= 10)
		{
			
			$DB_SQL		= 'INSERT INTO description (FEATURES, GEOGRAPHY, RECREATION, FACILITIES) VALUES ("' . $features . '", "' .
					  $geography . '", "' . $recreation . '", "' . $facilities . '")';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);

			
			
			$DB_SQL1	="SELECT MAX(DESC_ID) FROM DESCRIPTION";
			$DB_ResultSet1	= $DB_conn->query ($DB_SQL1);
			if ($DB_ResultSet1->num_rows > 0)
			{
				while ($row = $DB_ResultSet1->fetch_assoc ())
				{
					$desc	= $row ['MAX(DESC_ID)'];
				}
				
				
			}
			
			$deletefl='1';
			
			$DB_SQL2		= 'INSERT INTO camping_site(NAME,DESC_ID,STREET,CITY,STATES,IMAGE_PATH,MAX_SLOTS,DELETEFL) VALUES ("' . $camp_name . '", ' . (int)$desc . ', "' .
					  $street_name . '", "' . $city . '", "' . $state . '", "' . $image_path . '", ' . (int)$maxslots . ',' . (int)$deletefl  . ')';
					  
			$DB_ResultSet2	= $DB_conn->query ($DB_SQL2);
			
			echo 'http://localhost:9998/Pro/edit_rooms.html';
		}
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	exit ();
?>
