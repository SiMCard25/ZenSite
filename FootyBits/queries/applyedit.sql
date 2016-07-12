<?php

/* Apply the edited game data */
$sql = "
          UPDATE game
          SET
           GameDate   = '".$EDt."'
          ,Team1Goals = ".$EG1."
          ,Team2Goals = ".$EG2."
          WHERE GameID = ".$GID."
            AND SeasonStart = ".$season."
         "
;

$ur = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>