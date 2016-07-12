<?php

function show_sql_error($SQL ,$SQLError ,$SQLFile) {
	print "<!-- SQL Error in: ".$SQLFile.":\n";
	print "SQL  : ".$SQL."\n";
	print "Error: ".$SQLError."\n";
	print "-->\n";
}

function GT_OK ($Timing) {
	return (''==$Timing OR is_numeric($Timing) ? TRUE : FALSE);
}

function find_game ($ArrayToSort ,$SortOrder="A") {

  if ("A"==$SortOrder) { asort($ArrayToSort); }
  else { arsort($ArrayToSort); }

  $i=0;
  foreach ($ArrayToSort as $k => $v) {
  	$g=($i==0 ? $k : $g);
  	$i++;
  }
  
  return $g;

}

function playerPicAnc ($PlayerIdentifier ,$PictureID ,$ColumnSpan ,$season ,$played=TRUE ,$Cards=0) {
  $Ret ="<td colspan=".$ColumnSpan." align=center";
  $Ret.=($Cards>0 ? ($Cards>1 ? " bgcolor=\"Red\"" : " bgcolor=\"Yellow\"") : "");
  $Ret.=">";
  $Ret.="<a href=\"LTFC.php?view=1&playerid=";
  $Ret.=$PlayerIdentifier;
  $Ret.="&season=".$season."\">";
  $Ret.="<img SRC=\"";
  $Ret.=$PictureID;
  $Ret.="\", HEIGHT=50 ,WIDTH=50\" border=";
  $Ret.=($played ? "3" : "1");
  $Ret.="><a>";

  return $Ret;
}

function playerAnc ($PlayerIdentifier ,$PlayerSurname) {
  $Ret = "<a href=\"LTFC.php?view=1&playerid=";
  $Ret.=$PlayerIdentifier;
  $Ret.="&season=".$season."\">";
  $Ret.=$Playersurname;
  $Ret.="<a>";

  return $Ret;
}

?>