<?php
	$iUserID	= 0;
	$iPassword	= 0;
	$iIsValid	= 0;
	
	/* Change the following parameters to match with your environment */
	/* START */
	$DB_server	= 'localhost';
	$DB_name	= 'CRS';
	$DB_userid	= 'root';
	$DB_password	= 'root';
	/* END */
	
	$DB_conn	= '';
	$DB_SQL		= '';
	$DB_ResultSet	= '';
	
	if ($_SERVER ['REQUEST_METHOD']	== 'POST')
	{
		if (isset ($_POST ['userid']))
		{
			if (strlen ($_POST ['userid']) > 0)
			{
				$iIsValid = $iIsValid + 1;
			}
		}
		
		if (isset ($_POST ['password']))
		{
			if (strlen ($_POST ['password']) > 0)
			{
				$iIsValid = $iIsValid + 1;
			}
		}
		
		if (isset ($_POST ['firstname']))
		{
			if (strlen ($_POST ['firstname']) > 0)
			{
				$iIsValid = $iIsValid + 1;
			}
		}
		
		if (isset ($_POST ['lastname']))
		{
			if (strlen ($_POST ['lastname']) > 0)
			{
				$iIsValid = $iIsValid + 1;
			}
		}
		
		if (isset ($_POST ['email']))
		{
			if (strlen ($_POST ['email']) > 0)
			{
				$iIsValid = $iIsValid + 1;
			}
		}
		
		$DB_conn	= new mysqli ($DB_server, $DB_userid, $DB_password, $DB_name, 3307);
		
		if ($iIsValid == 5)
		{
			$iIsValid	= 0;
			
			$DB_SQL		= 'SELECT * FROM USERS WHERE USERID="' . $_POST ['userid'] . '" or email ="'.$_POST['email'].'"';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			for ($iCtr = 0; $iCtr < mysqli_num_rows ($DB_ResultSet); $iCtr++)
			{
				$iIsValid	= $iIsValid + 1;
			}
			
			if ($iIsValid == 0)
			{
				$DB_SQL		= 'INSERT INTO USERS VALUES ("' . $_POST ['userid'] . '", "' .
							md5 ($_POST ['password']) . '", "' .
							$_POST ['email'] . '", "' .
							$_POST ['firstname'] . '", "' .
							$_POST ['lastname'] . '")';
				
				$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			}
			else
			{
				$iIsValid = -1;
			}
		}
		
		// Close DB connectivity
		$DB_conn->close ();
	}
	
	if ($iIsValid == -1)
	{
		echo "<script>
		      alert ('UserID/Email already exists. Cannot register. Select different UserID/Email');
		      document.location='http://localhost:9998/Pro/login.html';
		      </script>";
	}
	else
	{
		session_destroy ();
		
                header ('Location:http://localhost:9998/Pro/login.html');
	}
	
	exit ();
?>
