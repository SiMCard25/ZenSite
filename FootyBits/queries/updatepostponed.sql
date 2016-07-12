<?php

$NewDate = ($season + 1).'-06-01';

/* Apply the input score */
$query = "
          UPDATE game
          SET    GameDate = '".$NewDate."'
          WHERE  GameID = ".$k."
            AND  SeasonStart   = ".$season."

         "
;

$ur = mysql_query ($query);

echo "<!-- Update Postponed Query\n".mysql_error()."\n-->\n";

?>