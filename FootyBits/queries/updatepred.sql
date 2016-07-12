<?php

// DELETE predictions
$sql="
      DELETE FROM prediction
     "
;

$df = mysql_query ($sql);

echo "<!-- DELETE Predictions\n".mysql_error()."\n-->\n";

// INSERT Predictions
foreach ($restext as $k=>$v) {
	$sql="INSERT INTO prediction VALUES (".$k." ,'".$v."' ,'".$scoretext[$k]."' ,".$predPC[$k].");";
	$iq = mysql_query ($sql);
	echo "<!-- INSERT Prediction for game:".$k."\n".mysql_error()."\n-->\n";
}

?>