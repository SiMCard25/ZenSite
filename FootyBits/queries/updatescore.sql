<?php

/* Apply the input score */
$query = "
          UPDATE game
          SET
           Team1Goals = ".$v."
          ,Team2Goals = ".$ag[$k]."
          WHERE GameID = ".$k."
            AND SeasonStart = ".$season."
         "
;

$ur = mysql_query ($query);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>