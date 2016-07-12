<?php

// print "<!-- \$_POST Array:\n";
// foreach ($_POST AS $k => $v) {
// 	print "Key: ".$k." has value: ".$v.".\n";
// }
// print "-->\n";

print "<h2>";

if ("TRUE"==$_POST['LO']) {
	$_SESSION['FootyUD']=0;
	print "Successfully Logged Out - Updates Disabled.";
}
else {
	if ($_POST['PW']!=$password) {
		$_SESSION['FootyUD']=0;
		print "Invalid Password Supplied - Updates Disabled.";
	}
	else {
		$_SESSION['FootyUD']=1;
		print "Password Accepted - Updates Enabled.";
	}
}

print "</h2><br />";

print "<form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."\" method=\"post\">\n";
print "<input type=submit Value=\"OK\">\n";
print "</form>\n";

?>