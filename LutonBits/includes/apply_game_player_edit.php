<?php

require($qrydir."GameDetail.sql");

mysql_data_seek($plrlist ,0);
while ($pl = mysql_fetch_assoc($plrlist)) {
	$PID=$pl['PID'];
print "<!-- Processing Player: ".$PID." -->\n";
	require($qrydir."DeletePlayerGame.sql");

	$EPG_Pos = $_POST["optPPs".$PID];
print "<!-- Position: ".$EPG_Pos." -->\n";
	if (0<$EPG_Pos) {
    // Get all $_POST data
		$EPG_On=$_POST["txtOnMin".$PID];
		$EPG_Off=$_POST["txtOffMin".$PID];
		$EPG_Gls=$_POST["txtGoals".$PID];
		$EPG_YC=$_POST["txtYC".$PID];
		$EPG_RC=$_POST["txtRC".$PID];

print "<!-- On Minute: ".$EPG_On." -->\n";
print "<!-- Off Minute: ".$EPG_Off." -->\n";
print "<!-- Goals: ".$EPG_Gls." -->\n";
print "<!-- Yellow Cards: ".$EPG_YC." -->\n";
print "<!-- Red Cards: ".$EPG_RC." -->\n";
		
		// Vet those puppies
		$Vet_OK=TRUE;
		print "<script language=javascript>\n";
		
		// print "<!-- \$EPG_On = ".$EPG_On." -->\n";
		if (!is_numeric($EPG_On)) {
		  $Vet_OK=FALSE;
		  print "alert(\"Invalid On Minute: ".$EPG_On." for Player ID: ".$PID."\");\n";
		}

		// print "<!-- \$EPG_Off = ".$EPG_Off." -->\n";
		if (!is_numeric($EPG_Off)) {
		  $Vet_OK=FALSE;
		  print "alert(\"Invalid Off Minute: ".$EPG_Off." for Player ID: ".$PID."\");\n";
		}

		// print "<!-- \$EPG_Gls = ".$EPG_Gls." -->\n";
		if (!is_numeric($EPG_Gls)) {
		  $Vet_OK=FALSE;
		  print "alert(\"Invalid Goals: ".$EPG_Gls." for Player ID: ".$PID."\");\n";
		}

		// print "<!-- \$EPG_YC = ".$EPG_YC." -->\n";
		if (!is_numeric($EPG_YC)) {
		  $Vet_OK=FALSE;
		  print "alert(\"Invalid Yellow Cards: ".$EPG_YC." for Player ID: ".$PID."\");\n";
		}

		// print "<!-- \$EPG_RC = ".$EPG_RC." -->\n";
		if (!is_numeric($EPG_RC)) {
		  $Vet_OK=FALSE;
		  print "alert(\"Invalid Red Cards: ".$EPG_RC." for Player ID: ".$PID."\");\n";
		}

		if ($Vet_OK) {
print "<!-- Going to query file -->\n";
		  require($qrydir."AddPlayerGame.sql");
		  if (!$UpdOK) {
		    print "alert(\"Data OK - Update Failed for Player ID: ".$PID."\\nSee Source for Details\");\n";
		  }
		}
		else {
		  print "alert(\"Data Invalid\\nUpdate Not Applied for Player ID: ".$PID."\");\n";
		}

		print "</script>\n";

	}
}

?>