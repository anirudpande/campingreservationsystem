<?php
	session_start ();
	
	$state	= '';
	$city		= '';
	$camp_name	= '';
	
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
		
		if (isset ($_POST ['camp_name']))
		{
			if (strlen ($_POST ['camp_name']) > 0)
			{
				$camp_name	= $_POST ['camp_name'];
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
		
		if ($state != '' and $city != '' and $camp_name != '')
		{
			$_SESSION ['STATE']	= $state;
			$_SESSION ['CITY']	= $city;
			$_SESSION ['CAMP_NAME']	= $camp_name;
			
			echo 'http://localhost:9998/Pro/book_room.html';
		}
		else
		{
			// Unset the variables if set
			session_unset ($_SESSION ['STATE']);
			session_unset ($_SESSION ['CITY']);
			session_unset ($_SESSION ['CAMP_NAME']);
			
			echo 'http://localhost:9998/Pro/main.html';
		}
	}
	
	exit ();
?>
