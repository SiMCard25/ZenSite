<?php

$Vet_OK=TRUE;

// Get $_POST data (New Game Date)
$NGD = $_POST['NGD'];

// vet the data and feed back
print "<script language=javascript>\n";

// Check supplied Game Date
// print "<!-- \$NGD = ".$NGD." -->\n";
$GDy = substr($NGD,strrpos($NGD,"-")+1,2);
$GMt = substr($NGD,strpos($NGD,"-")+1,2);
$GYr = substr($NGD,0 ,4);
// print "<!-- \$GDy = ".$GDy." -->\n";
// print "<!-- \$GMt = ".$GMt." -->\n";
// print "<!-- \$GYr = ".$GYr." -->\n";

if (!checkdate($GMt ,$GDy ,$GYr)) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Game Date supplied: ".$NGDt."\");\n";
}

if ($Vet_OK) {
  require_once($qrydir."AddGame.sql");
  if ($UpdOK) {
    print "alert(\"Data OK\\nUpdate Applied\");\n";
  }
  else {
    print "alert(\"Data OK - Update Failed\\nSee Source for Details\");\n";
  }
}
else {
  print "alert(\"Data Invalid\\nUpdate Not Applied\");\n";
}

print "</script>\n";

?>