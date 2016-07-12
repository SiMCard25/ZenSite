<?php

print "<hr>\n";

if (1!=$_SESSION['FootyUD']) {
	print "<h2>Updates Not Enabled</h2><br />";
}
else {
//	print "<!-- Extracted \$_POST details:\n";
//	foreach ($_POST as $k => $v) {
//		print "Key: ".$k." = ".$v."\n";
//	}
	extract($_POST ,EXTR_OVERWRITE);
//	print "\$EDt = ".$EDt."\n";
//	print "\$EG1 = ".$EG1."\n";
//	print "\$EG2 = ".$EG2."\n";
//	print "\$GID = ".$GID."\n";
//	print "-->\n";

// tidy up any crap
	$EG1 = ('/'==$EG1||''==$EG1 ? 'NULL' :$EG1);
	$EG2 = ('/'==$EG2||''==$EG2 ? 'NULL' :$EG2);
//	print "\$EDt = ".$EDt."\n";
//	print "\$EG1 = ".$EG1."\n";
//	print "\$EG2 = ".$EG2."\n";
//	print "\$GID = ".$GID."\n";
//	print "-->\n";
	

	include($qrydir.'applyedit.sql');
	if (mysql_error()) {
		print "<h2>Update Failed</h2>\n";
	}
	else {
		print "<h2>Game ".$GID." details set to:</h2><hr>\n";
		print "<h4>Game Date  = ".$EDt."<br />\n";
		print "Home Goals = ".$EG1."<br />\n";
		print "Away Goals = ".$EG2."<br />\n";
		print "</h4><hr>\n";
	}
}

print "<form action=\"".$_SESSION['FootyEditRef']."\" method=\"post\">\n";
print "<input type=submit Value=\"OK\">\n";
print "</form>\n";

unset($_SESSION['FootyEditRef']);

?>