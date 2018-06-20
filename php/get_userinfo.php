<?php
	session_start ();
	
	$userinfo	= array ('USERID'=>$_SESSION ['USERID'],
			   	 'EMAIL'=>$_SESSION ['EMAIL'],
			   	 'FNAME'=>$_SESSION ['FNAME'],
			   	 'LNAME'=>$_SESSION ['LNAME']);
	echo '[';
	echo json_encode ($userinfo);
	echo ']';
	
	exit ();
?>
