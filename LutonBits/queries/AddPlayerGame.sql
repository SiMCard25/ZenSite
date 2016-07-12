<?php

// print "<!-- GameID = ".$gameid." -->\n";
// print "<!-- SeasonID = ".$season." -->\n";
// print "<!-- PlayerID = ".$PID." -->\n";

$sql="
  INSERT INTO player_game VALUES 
  (".$gameid."
  ,".$season."
  ,".$PID."
  ,".($EPG_On==$EPG_Off ? 'NULL' : $EPG_On)."
  ,".($EPG_On==$EPG_Off ? 'NULL' : $EPG_Off)."
  ,".$EPG_Pos."
  ,".$EPG_Gls."
  ,".$EPG_YC."
  ,".$EPG_RC."
  )"
  ;

$inspg=mysql_query ($sql);

if (mysql_error()) {
  show_sql_error($sql ,mysql_error(),__FILE__);
  $UpdOK=FALSE;
}
else {
  $UpdOK=TRUE;
}

?>