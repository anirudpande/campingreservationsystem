<?php
	session_start ();
	
	$name	= '';
	$states	= '';
	$recreation		= '';
	$city	= '';
	
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
		if (isset ($_POST ['name']))
		{
			if (strlen ($_POST ['name']) > 0)
			{
				$name = $_POST ['name'];
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
		
		
		
		if (isset ($_POST ['states']))
		{
			if (strlen ($_POST ['states']) > 0)
			{
				$states	= $_POST ['states'];
			}
			else
			{
				$states	= '';
			}
		}
		else
		{
			$states	= '';
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
		
		if (isset ($_POST ['recreation']))
		{
			if (strlen ($_POST ['recreation']) > 0)
			{
				$recreation	= $_POST ['recreation'];
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
		
		if ($name != '' and $states != '')
		{
			
			$_SESSION ['CAMP_NAME']		 = $name;
			$_SESSION ['STATE']		     = $states;
			$_SESSION ['CITY']			 = $city;
			$_SESSION ['RECREATION']	 = $recreation;
			
			echo 'http://localhost:9998/Pro/update_room_info.html';
		}
		else
		{
			
			// Unset the variables if set
			session_unset ($_SESSION ['CAMP_NAME']);
			session_unset ($_SESSION ['STATE']);
			session_unset ($_SESSION ['CITY']);
			session_unset ($_SESSION ['RECREATION']);
			
			echo 'http://localhost:9998/Pro/main.html';
		}
	}
	
	exit ();
?>
