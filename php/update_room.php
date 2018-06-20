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
	$price='';

	$desc		= '';
	$cid		= '';
	$flag		= '';
	
	$DB_conn	= '';
	$DB_SQL		= '';
	$DB_ResultSet	= '';
	$DB_SQL1		= '';
	$DB_ResultSet1	= '';
	
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
			$price	= '';
		}
		
		if (isset ($_POST ['price']))
		{
			if (strlen ($_POST ['price']) > 0)
			{
				$price	= $_POST ['price'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$price	= '';
			}
		}
		else
		{
			$price	= '';
		}
		
		
		if (isset ($_POST ['flag']))
		{
			if (strlen ($_POST ['flag']) > 0)
			{
				$flag	= $_POST ['flag'];
				
				$iIsSessionValid	= $iIsSessionValid + 1;
			}
			else
			{
				$flag	= '';
			}
		}
		else
		{
			$flag	= '';
		}
		
		// Establish DB Connectivity
		$DB_conn	= new mysqli ('localhost', 'root','root', 'crs',3307);
		
		if ($iIsSessionValid >= 12)
		{
			//echo "hello World";
			if ($flag == 'update')
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
			    //echo "" . $DB_SQL1;	
				$DB_SQL		= 'UPDATE DESCRIPTION SET FEATURES="' . $features . '", GEOGRAPHY="' . $geography . 
						  '", RECREATION="' . $recreation . '", FACILITIES="' . $facilities . '" where desc_id=' . (int)$desc;
				
				$DB_ResultSet	= $DB_conn->query ($DB_SQL);
				//echo "" . $DB_SQL;
				
				$DB_SQL		= 'UPDATE CAMPING_SITE SET NAME="' . $camp_name . '", STREET="' . $street_name . 
						  '", CITY="' . $city . '", STATES="' . $state . '", MAX_SLOTS=' . (int)$maxslots . ', PRICE=' . (int)$price .
						  ', IMAGE_PATH="' . $image_path . '" WHERE CAMPING_ID=' . (int)$cid . 
						  ' AND DESC_ID=' . (int)$desc;
				//echo "" . $DB_SQL;
				
								
				$DB_ResultSet	= $DB_conn->query ($DB_SQL);

				
				
				$_SESSION ['STATE']		= $state;
				$_SESSION ['CAMP_NAME']		= $name;
				$_SESSION ['CITY']		= $city;
				$_SESSION ['RECREATION']	 = $recreation;
			}
		}
		
		if ($flag == 'delete')
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
			    
				$deletefl='0';
				$DB_SQL		= 'UPDATE CAMPING_SITE SET DELETEFL=' . (int)$deletefl .' WHERE CAMPING_ID=' . (int)$cid . ' AND DESC_ID=' . (int)$desc;
				$DB_ResultSet	= $DB_conn->query ($DB_SQL);
				
			$_SESSION ['STATE']		= $state;
			$_SESSION ['CAMP_NAME']		= $name;
			$_SESSION ['CITY']		= $city;
			$_SESSION ['RECREATION']	 = $recreation;
		}
	}
	
	// Close DB connectivity
	$DB_conn->close ();
	
	echo 'http://localhost:9998/Pro/edit_rooms.html';
	
	exit ();
?>
