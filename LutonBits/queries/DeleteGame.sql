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

// Update game, player_game and game_goals tables game numbers after game to be deleted
$sql= "UPDATE game
      SET GameID = GameID + 100
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$ug = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "UPDATE player_game
      SET GameID = GameID + 100
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$upg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "UPDATE game_goals
      SET GameID = GameID + 100
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$ugg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// delete game details (assume current season)
$sql= "DELETE FROM game
        WHERE GameID = ".$gameid."
             AND SeasonID = ".$season."
      "
;

$dg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "DELETE FROM player_game
        WHERE GameID = ".$gameid."
             AND SeasonID = ".$season."
      "
;

$dpg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "DELETE FROM game_goals
        WHERE GameID = ".$gameid."
             AND SeasonID = ".$season."
      "
;

$dgg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Reorder game, player_game and game_goals tables game numbers
$sql= "UPDATE game
      SET GameID = GameID - 101
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$ug = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "UPDATE player_game
      SET GameID = GameID - 101
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$upg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "UPDATE game_goals
      SET GameID = GameID - 101
      WHERE GameID > ".$gameid."
      AND SeasonID = ".$season."
      "
;

$ugg = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>