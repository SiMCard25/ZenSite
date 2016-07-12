<?php
session_start();
ob_start();

$CSSdir="./Footy/CSS/";
$imgdir="./Footy/images/";
$incdir="../FootyBits/includes/";
$qrydir="../FootyBits/queries/";

include($incdir.'functions.php');

require_once($incdir.'Footy_logon.inc');

include($incdir.'setdefaults.php');

include($incdir.'header.inc');
// print "<body background=\"".$imgdir."Footybg.gif\">\n";
print "<body>\n";

print "<div id=\"toppanel\">\n";
print "<FONT face=tahoma size=-1>\n";

print "<table class=\"TopTable\">\n";
echo "<tr><th valign=top><a href=\"http://www.pretronix.co.uk/index.php\">Back to Index Page<a>\n";
print "<br /><br />\n";
echo "Best viewed using:\n";
print "<br />\n";
echo "<a href=\"http://en.www.mozilla.com/en/firefox/\"><img src=\"".$imgdir."firefox.gif\" alt=\"Firefox\" /></a>\n";

if (5==$view) {
	echo "<th><h1>All Competitions</h1>\n";
}
else {
	echo "<th align=right><img src=\"".$imgdir.$CompLogo[$comp]."\">\n";
}

print "<th align=left><h1>Season ".$SeasonName[$season]."</h1>\n";

print "<th align=center><form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."&view=91\" method=\"post\">\n";

print "<table border=0 cellspacing=0 cellpadding=2>\n";
print "<tr><td align=center>";

if ($_SESSION['FootyUD'] AND 1==$_SESSION['FootyUD']) {
	print "Updates Allowed\n";
	print "<input type=\"hidden\" name=\"LO\" value=\"TRUE\" />\n";
	print "<tr><td align=center><input type=submit Value=\"Logout\">\n";
}
else {
	print "Updates Disabled\n";
	print "<tr><td align=center>Password: <input type=\"password\" name=\"PW\" size=10 maxlength=8 />\n";
	print "<input type=\"hidden\" name=\"LO\" value=\"FALSE\" />\n";
	print "<tr><td align=center><input type=submit Value=\"Check Update Password\">\n";
}

echo "</table>\n";

echo "</form>\n";

echo "</table>\n";
print "</div>\n"; // close toppanel

print "<br />\n";

print "<div class=\"PageBody\">\n";

//  print "<table class=\"PageBody\">\n";
//  echo "<TR><TD width=\"15%\" valign=top align=center>\n";
  print "<div class=\"SelectorCol\">\n";

    include($incdir.'seasonsel.php');
    print "<hr>\n";
    include($incdir.'compmenu.php');
    print "<hr>\n";

    // print "<!-- \$GLOBALS array has the following:\n";
    // foreach ($GLOBALS as $k => $v) {
    // 	print "Key: ".$k." has value: ".$v."\n";
    // }
    // print "-->\n";

    include($incdir.'viewmenu.php');

  print "</div>\n"; // close SelectorCol
  
  print "<div class=\"InfoPanel\">\n";

//    print "<td align=center width=\"85%\" valign=top>\n";
  
    switch ($view) {
      case 1:  include($incdir.'leaguetable.php');
              break;
      case 2:  include($incdir.'formtables.php');
              break;
      case 3:  include($incdir.'teamdetail.php');
              break;
      case 4:  include($incdir.'awaitedresults.php');
              break;
      case 5:  include($incdir.'predictions.php');
              break;
      case 90: include($incdir.'applyresults.php');
              break;
      case 91: include($incdir.'checkpw.php');
              break;
      case 92: include($incdir.'editgame.php');
              break;
      case 93: include($incdir.'applyedit.php');
              break;
      default: include($incdir.'fixres.php');
              break;
    }

  print "</div>\n"; // close InfoPanel
//  echo "</TABLE>\n";
print "</div>\n"; // close PageBody

include($incdir.'footer.inc');

ob_end_flush();

?>
