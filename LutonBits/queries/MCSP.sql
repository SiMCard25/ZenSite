<?php
/* Get the Most Common Starting Position for an id'ed player this season */
$sql="
        SELECT
         pos.FullName  AS FNm
        ,pos.Tag       AS Tag
        ,COUNT(*)      AS PCt
        FROM
         player_game pgm
           INNER JOIN
         position    pos
             ON  pos.PositionID = pgm.PositionID
        WHERE PlayerID     = ".$playerid."
          AND pgm.SeasonID = ".$season."
        GROUP BY FNm ,Tag
        ORDER BY PCt DESC ,FNm ,Tag
       "
;
    
$MCSP = mysql_query ($sql);
    
if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the Most Common Starting Position for an id'ed player ever */
$sql="
        SELECT
         pos.FullName  AS FNm
        ,pos.Tag       AS Tag
        ,COUNT(*)      AS PCt
        FROM
         player_game pgm
           INNER JOIN
         position    pos
             ON  pos.PositionID = pgm.PositionID
        WHERE PlayerID     = ".$playerid."
        GROUP BY FNm ,Tag
        ORDER BY PCt DESC ,FNm ,Tag
       "
;
    
$MCSPAllTime = mysql_query ($sql);
    
if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>