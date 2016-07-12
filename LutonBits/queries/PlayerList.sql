<?php
$sql =  "SELECT
          plr.PlayerID                            AS PID
         ,psq.SquadNumber                         AS SNo
         ,CONCAT(plr.FirstName ,' ' ,plr.Surname) AS FlN
         ,plr.Surname                             AS SNm
         FROM
          player       plr
            INNER JOIN
          player_squad psq
              ON  psq.PlayerID = plr.PlayerID
         WHERE psq.SeasonID = ".$season."
         ORDER BY SNo ,PID
"
;	
	          
$result = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>