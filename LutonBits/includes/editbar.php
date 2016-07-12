<?php

$_SESSION['LTFCRef'] = $_SERVER['PHP_SELF']."?view=".$view."&playerid=".$playerid."&gameid=".$gameid."&season=".$season;

$barmsg = "<td>";

if ($_POST['LO']) {
  $_SESSION['LTFCPW'] = 0;
  $barmsg .= "<b>Logged Out</b>\n";
}

if (isset($_POST['PW'])) {
  $barmsg .= "<b>Password ";
  if ($_POST['PW']!=$pw) {
    $_SESSION['LTFCPW']=0;
    $barmsg .= "Incorrect";
  }
  else {
    $_SESSION['LTFCPW']=1;
    $barmsg .= "Accepted";
  }
  $barmsg .= "</b>\n";
}

print "<td align=right>";
print "\n";
print "<table border=0 cellspacing=1 cellpadding=3>";
print "\n";

if ($_SESSION['LTFCPW'] AND 1==$_SESSION['LTFCPW']) {
  print "<form action=\"".$_SESSION['LTFCRef']."\" method=\"post\">";
  print "\n";
  print "<input type=\"hidden\" name=\"AG\" value=\"TRUE\" />\n";
//  print "<td><input type=submit name =\"AP\" value=\"Add Player\">";
  print "<td><input type=submit name =\"AddGame\" value=\"Add Game Date:\">";
  print "<td align=center><input type=\"text\" name=\"NGD\" size=12 maxlength=10 value=\"YYYY-MM-DD\" />\n";
  print $barmsg;
  print "</form>";
  print "\n";
  print "<td class=GS><b>Updates Enabled</b>\n";
}
else {
  print "<td>";
  print "<td>";
  print $barmsg;
  print "<td class=RC><b>Updates Disabled</b>\n";
}

print "<form action=\"".$_SESSION['LTFCRef']."\" method=\"post\">";
print "\n";
if ($_SESSION['LTFCPW'] AND 1==$_SESSION['LTFCPW']) {
	print "<input type=\"hidden\" name=\"LO\" value=\"TRUE\" />\n";
	print "<td><input type=submit name =\"whereto\" value=\"Logout\">";
	print "\n";
}
else {
  print "<td align=center><input type=\"password\" name=\"PW\" size=10 maxlength=8 />\n";
	print "<td align=center><input type=submit name =\"whereto\" value=\"Login\">";
	print "\n";
}
print "</form>";
print "\n";

print "</table>";
print "\n";

?>