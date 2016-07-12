<?php

$sql="
        SELECT
         tm1.TeamID          AS TID
        ,tm1.FullName        AS TFN
        ,tm1.ShortName       AS TSN
        ,tm1.Tag             AS TTg
        ,tsn.PointAdjustment AS PAj
        FROM team tm1
        INNER JOIN team_season tsn
        ON tsn.TeamID = tm1.TeamID
        WHERE tsn.CompetitionID =".$comp."
          AND tsn.SeasonStart   = ".$season."
        ORDER BY TFN
       "
;

$result = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>