<?php
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

print "<div class=\"CompMenu\">\n";
  print "<h4>Competition</h4>\n";
  $cno=0;
  while ($row = mysql_fetch_assoc($complist)) {
    print "<div class=\"CompItem\" align=center><a href=\"".$_SERVER['PHP_SELF']."?season=".$season."&comp=".$row['CID']."&view=".$view."\">";
// don't ask - this is really bloody annoying. Images have been disabled as I'm naughty. Hmmmm...
//    print "<img src=\"".$imgdir.$row['PFX']."_".$CompTag[$row['CID']]."_menu_".($cno==$comp ? "selected" : "normal").".gif\"";
//    print " alt=\"";
    print $row['CFN'];
    print "</a>\n";
    print "</div>\n"; // close CompItem
    $cno++;
  }
print "</div>\n"; // close CompMenu
?>
