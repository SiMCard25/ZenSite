<?php

print "<fieldset><legend align=center><font color=White>Select Season</font></legend>";
print "\n";

print "<form action=\"dummy\" method=\"post\">";
print "\n";

print "<select name=\"seasonsel\" size=\"1\" onChange=\"jump(this.form)\">";
print "\n";

foreach($SeasonFullName as $k => $v) {
  print "<option ".($season==$k ? " selected " : "")." value=\"".$_SERVER['PHP_SELF']."?season=".$k."&playerid=".$playerid."&gameid=".$gameid."&view=".$view."\">".$v."</option>";
  print "\n";
}
print "</select>";
print "\n";
print "</form>";
print "\n";
print "</fieldset>";
print "\n";

?>