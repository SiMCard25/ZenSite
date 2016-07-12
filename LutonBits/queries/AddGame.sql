<?php

// Get new game number
$sql= "SELECT MIN(GameID) AS NGID
      FROM game
      WHERE GameDate >= '".$NGD."'
      "
;

$gd = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

while ($ng = mysql_fetch_assoc($gd)) {
  	$ngno = $ng['NGID'];
  }

// Update game table game numbers after new game
$sql= "UPDATE game
      SET GameID = GameID + 101
      WHERE GameDate >= '".$NGD."'
      "
;

$ug = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Insert new game details (assume current season)
$sql= "INSERT INTO game VALUES (
       ".$ngno."
      ,".$season."
      ,'".$NGD."'
      ,99
      ,NULL
      ,0
      ,0
      ,90
      ,'N'
      ,0
      ,NULL
      ,NULL
      ,NULL
      ,NULL
      ,NULL
      ,NULL
      )
      "
;

$ig = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$gameid=$ngno;

// Update game table game numbers after new game
$sql= "UPDATE game
      SET GameID = GameID - 100
      WHERE GameID > 100
      "
;

$ug = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>