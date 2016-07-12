<?php

// print "<!-- GameID = ".$gameid." -->\n";
// print "<!-- SeasonID = ".$season." -->\n";
// print "<!-- PlayerID = ".$PID." -->\n";

$sql="
  DELETE FROM player_game
  WHERE SeasonID=".$season."
    AND GameID=".$gameid."
    AND PlayerID=".$PID
  ;

$delpg=mysql_query ($sql);

if (mysql_error()) {
  show_sql_error($sql ,mysql_error(),__FILE__);
  $DelOK=FALSE;
}
else {
  $DelOK=TRUE;
}

?>