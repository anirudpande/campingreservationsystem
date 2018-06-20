<?php
	session_start ();
	
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
				$iUserID	= 1;
			}
		}
		
		if (isset ($_POST ['password']))
		{
			if (strlen ($_POST ['password']) > 0)
			{
				$iPassword	= 1;
			}
		}
		
		if ($iUserID == 1 && $iPassword == 1)
		{
			$DB_conn	= new mysqli ($DB_server, $DB_userid, $DB_password, $DB_name,3307);
			
			$DB_SQL		= 'SELECT * FROM USERS WHERE USERID='.'"'.$_POST ['userid'].'"'.'AND PASSWORD='.'"'.
					   md5 ($_POST ['password']).'"';
			
			$DB_ResultSet	= $DB_conn->query ($DB_SQL);
			
			while ($row = $DB_ResultSet->fetch_assoc ())
			{
				$_SESSION ['FNAME']	= $row ['FNAME'];
				$_SESSION ['LNAME']	= $row ['LNAME'];
				$_SESSION ['EMAIL']	= $row ['EMAIL'];
				
				$iIsValid	= $iIsValid + 1;
			}
			
			// Save the DB related information for welcome.php
			$_SESSION ['DB_SERVER']		= $DB_server;
			$_SESSION ['DB_USERID']		= $DB_userid;
			$_SESSION ['DB_PASSWORD']	= $DB_password;
			$_SESSION ['DB_NAME']		= $DB_name;
			
			$_SESSION ['USERID']	= $_POST ['userid'];
			
			// Close DB connectivity
			$DB_conn->close ();
		}
		else
		{
			$iIsValid	= 0;
		}
		
	}
	
	if ($iIsValid >= 1)
	{
		header ('Location:http://localhost:9998/Pro/main.html');
	}
	else
	{
		session_destroy ();
		
		echo "<script>
		      alert ('Cannot Login. Credentials Incorrect.');
		      document.location='http://localhost:9998/Pro/login.html';
		      </script>";
	}
	
	exit ();

?>
