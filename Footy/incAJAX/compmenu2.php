<?php
include($incdir.'menucolors.php');

echo "<fieldset><legend align=center><font color=White>Select Season</font></legend>\n";

echo "<form action=\"dummy\" method=\"post\">\n";
echo "<select name=\"choice\" size=\"1\" onChange=\"jump(this.form)\">\n";
foreach($SeasonName as $k => $v) {
  echo "<option ".($season==$k ? " selected " : "")." value=\"".$_SERVER['PHP_SELF']."?season=".$k."&view=".$view."&comp=".$comp."&teamid=".$teamid."\">".$v."</option>\n";
}
echo "</select>\n";
echo "</form>\n";
echo "</fieldset>\n";

echo "<hr>\n";

$lm="'<center><h1>Loading ";
switch ($view) {
  case 1:  $if='leaguetable';
           $lm.="League Table";
           break;
  case 2:  $if='formtables';
           $lm.="Form Tables";
           break;
  case 3:  $if='teamdetail';
           $lm.="Team Detail";
           break;
  case 4:  $if='awaitedresults';
           $lm.="Awaited Results";
           break;
  case 5:  $if='predictions';
           $lm.="Predictions";
           break;
  case 90: $if='applyresults';
           $lm.="Result Application";
           break;
  case 91: $if='checkpw';
           $lm.="Password Check";
           break;
  case 92: $if='editgame';
           break;
  case 93: $if='applyedit';
           $lm.="Edit Application";
           break;
  default: $if='fixres';
           $lm.="Fixtures and Results";
           break;
}
$lm.="...</h1></center>'";

print "<table border=0 cellspacing=0 cellpadding=0><tr>\n";
print "<th><img src=\"".$imgdir."comp_menu_header.gif\" alt=\"Competition\">\n";
$cno=0;
print "<div id=\"compcont\">\n";
while ($row = mysql_fetch_assoc($complist)) {
//  print "<tr><td><a href=\"".$_SERVER['PHP_SELF']."?season=".$season."&comp=".$row['CID']."&view=".$view."\">";
//  print "<img src=\"".$imgdir.$CompTag[$row['CID']]."_menu_".($cno==$comp ? "selected" : "normal").".gif\"";
//  print " alt=\"".$row['CFN']."\"></a>\n";
  print "<tr><td><div id=\"divbutton\" ";
  print " onClick=\"callAHAH('./Footy/incAJAX/".$if."2.php?season=".$season."&comp=".$row['CID']."'";
  print " ,'infopanel',".$lm.")\">\n";
  print "<img src=\"".$imgdir.$CompTag[$row['CID']]."_menu_".($cno==$comp ? "selected" : "normal").".gif\"";
  print " alt=\"".$row['CFN']."\">\n";
  print "</div>\n";
  $cno++;
}
print "</div>\n";
print "</table>\n";

?>
