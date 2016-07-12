<?php

// Get all game details before today
$sql="
      SELECT
       GameDate   AS GDt
      ,Team1ID    AS T1I
      ,Team1Goals AS T1G
      ,Team2ID    AS T2I
      ,Team2Goals AS T2G
      FROM game
      WHERE Team1Goals IS NOT NULL
      ORDER BY GameDate DESC,Team1ID
     "
;

$gd = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Get all remaining fixtures
$sql = ' SELECT'
        . ' GameID AS GID'
        . ' ,Team1ID AS T1I'
        . ' ,Team2ID AS T2I'
        . ' FROM'
        . ' game'
        . ' WHERE Team1Goals IS NULL'
        . '   AND SeasonStart='.$season.''
        . ' ';
        
$rf = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>