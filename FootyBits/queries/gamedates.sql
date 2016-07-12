<?php

/* Get all game dates and teams */
$sql="
      SELECT
       GameDate AS GDt
      ,Team1ID  AS T1ID
      ,Team2ID  AS T2ID
      FROM game
      WHERE
          CompetitionID =  ".$comp."
      AND SeasonStart   = ".$season."
      AND GameDate      <= NOW()
      ORDER BY GameDate DESC,Team1ID
     "
;

$gd = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>