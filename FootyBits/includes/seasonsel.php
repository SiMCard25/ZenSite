<?php
include($incdir.'menucolors.php');

echo "<div class=\"CompMenu\">\n";

echo "<fieldset><legend align=center>Select Season</legend>\n";

echo "<form align=center action=\"dummy\" method=\"post\">\n";
echo "<select name=\"choice\" size=\"1\" onChange=\"jump(this.form)\">\n";
foreach($SeasonName as $k => $v) {
  echo "<option ".($season==$k ? " selected " : "")." value=\"".$_SERVER['PHP_SELF']."?season=".$k."&view=".$view."&comp=".$comp."&teamid=".$teamid."\">".$v."</option>\n";
}
echo "</select>\n";
echo "</form>\n";
echo "</fieldset>\n";

echo "</div>\n";

?>
