<!--
//*********************************************************************
// PHP5 Document
//
// Description: 
// Programmer : lenbo
// History    : 20121101 - Release.
//              20130725 - To add comments and change function name.
//**********************************************************************
-->

<?php	
	$dbHost = "localhost";
	$dbUser = "";
	$dbPwd  = "";
	$dbName = "";
  
	$dbConn = mysql_connect ( $dbHost, $dbUser, $dbPwd ) or die ( "[ERR] Fail to connect with MySQL." );
	mysql_query ( "SET NAMES utf8" );
	mysql_select_db ( $dbName, $dbConn ) or die ( "[ERR] Fail to select database." );
?>