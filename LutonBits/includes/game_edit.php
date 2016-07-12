<?php


print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<form action=\"".$_SESSION['LTFCRef']."\" method=\"post\">\n";
print "<input type=\"hidden\" name=\"EGD\" value=\"TRUE\" />\n";
print "<th colspan=5>Edit Game Detail\n";

print "<tr><th>Competition<th>Rnd<th>Rep<th>Game Date<th>Length\n";

print "<!-- Competition List --> \n";
print "<tr>";
print "<td><select name=\"optCmp\">";
while ($cl = mysql_fetch_assoc($cmplist)) {
  print "<option value=".$cl['CID'];
  if ($cl['CID']==$row1['CID']) {
    print " selected=\"selected\"";
  }
  print ">".$cl['CFN']."</option>";
}
print "</select>\n";

print "<td><input  type=\"text\" name=\"txtCRd\" value=\"".$row1['CRd']."\" size=4 maxlength=4>";
print "\n";

print "<td><input  type=\"text\" name=\"txtCRI\" value=\"".$row1['CRI']."\" size=1 maxlength=1>";
print "\n";

print "<td><input  type=\"text\" name=\"txtGDt\" value=".$row1['UGD']." size=10 maxlength=10> - \n";

print "<td><input  type=\"text\" name=\"txtGMn\" value=".$row1['GMn']." size=3 maxlength=3>\n";

print "<tr><th>Opposition<th>Venue<th>Kit (Shirt-Shorts)<th colspan=2>FT Score (F-A)\n";

print "<!-- Opposition List --> \n";
print "<tr>";
print "<td><select name=\"optOpp\">";
while ($ol = mysql_fetch_assoc($opplist)) {
  print "<option value=".$ol['OID'];
  if ($ol['OID']==$row1['OID']) {
    print " selected=\"selected\"";
  }
  print ">".$ol['OFN']."</option>";
}
print "</select>\n";

print "<!-- Venue List --> \n";
print "<td><select name=\"optVen\">";
print "<option value=\"H\"".("H"==$row1['Ven'] ? " selected=\"selected\"" : "").">Home</option>";
print "<option value=\"A\"".("A"==$row1['Ven'] ? " selected=\"selected\"" : "").">Away</option>";
print "<option value=\"N\"".("N"==$row1['Ven'] ? " selected=\"selected\"" : "").">Neutral</option>";
print "</select>\n";

print "<!-- Kit List --> \n";
print "<td><select name=\"optKit\" class=\"icon-menu\">";
while ($kl = mysql_fetch_assoc($kitlist)) {
  print "<option style=\"background-image:url(".$imgdir.$kl['KitPic']."); \"value=".$kl['KID'];
  if ($kl['KID']==$row1['KID']) {
    print " selected=\"selected\"";
  }
  print ">".$kl['KFN']."</option>";
}
print "</select>\n";

print "<td colspan=2>";
print "<input type=\"text\" name=\"txtFTF\" value=".$row1['FT_GF']." size=2 maxlength=2>\n";
print "<input type=\"text\" name=\"txtFTA\" value=".$row1['FT_GA']." size=2 maxlength=2>\n";
print "</table>\n";

if (90<$row1['GMn']) {
  print "<table border=0 cellspacing=1 cellpadding=3>\n";
  print "<tr><th>ET Score (F-A)<th>Pens (F-A)\n";
  
  print "<tr><td>";
  print "<input type=\"text\" name=\"txtETF\" value=".$row1['ET_GF']." size=2 maxlength=2>\n";
  print "<input type=\"text\" name=\"txtETA\" value=".$row1['ET_GA']." size=2 maxlength=2>\n";
  
  print "<td>";
  print "<input type=\"text\" name=\"txtPnF\" value=".$row1['Pn_GF']." size=2 maxlength=2>\n";
  print "<input type=\"text\" name=\"txtPnA\" value=".$row1['Pn_GA']." size=2 maxlength=2>\n";
  
  print "</table>\n";
}

print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<tr><th colspan=11>Goals Timings\n";

print "<tr><th>For:";
print "<td><input type=\"text\" name=\"txtGF01\" value='".$row1['GF01']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF02\" value='".$row1['GF02']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF03\" value='".$row1['GF03']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF04\" value='".$row1['GF04']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF05\" value='".$row1['GF05']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF06\" value='".$row1['GF06']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF07\" value='".$row1['GF07']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF08\" value='".$row1['GF08']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF09\" value='".$row1['GF09']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGF10\" value='".$row1['GF10']."' size=3 maxlength=3>\n";
  
print "<tr><th>Against:";
print "<td><input type=\"text\" name=\"txtGA01\" value='".$row1['GA01']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA02\" value='".$row1['GA02']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA03\" value='".$row1['GA03']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA04\" value='".$row1['GA04']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA05\" value='".$row1['GA05']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA06\" value='".$row1['GA06']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA07\" value='".$row1['GA07']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA08\" value='".$row1['GA08']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA09\" value='".$row1['GA09']."' size=3 maxlength=3>\n";
print "<td><input type=\"text\" name=\"txtGA10\" value='".$row1['GA10']."' size=3 maxlength=3>\n";
  
print "</table>\n";


print "<table border=0 cellspacing=1 cellpadding=3>\n";
print "<tr><td align=center colspan=3><input type=submit name =\"UpdateGame\" value=\"Apply Update to Game\">\n";
print "</form>\n";

print "<form action=\"".$_SESSION['LTFCRef']."\" method=\"post\">\n";
print "<input type=\"hidden\" name=\"DG\" value=\"TRUE\" />\n";
print "<td align=center colspan=3><input type=submit name =\"DeleteGame\" value=\"Delete Game\">\n";
print "</form>\n";

print "</table>\n";

print "<hr>\n";

?>