<?php

if (1!=$_SESSION['FootyUD']) {
	echo "<h2>Updates Not Enabled</h2><br />";
}
else {
	echo "<font color=Silver>\n";
	foreach ($_POST as $k => $v) {
		if ($k!='PW') {
			$g=substr($k ,2);
			$gt=substr($k ,0 ,1);
			switch ($gt) {
				case "A":  $ag[$g]=$v;
				           break;
				case "H":  $hg[$g]=$v;
				           break;
				case "P":  $pg[$g]='P';
				           break;
			}
		}
	}

	foreach ($hg as $k => $v) {
		if (is_numeric($v) && is_numeric($ag[$k])) {
			include($qrydir.'updatescore.sql');
			echo "Game ".$k." Score: ".$v." - ".$ag[$k]." applied.<br />\n";
		}
		else {
			echo "Game ".$k." Score: ".$v." - ".$ag[$k]." <b>not</b> applied (non-numeric score).<br />\n";
		}
	}

	if ($pg) {
		foreach ($pg as $k => $v) {
			include($qrydir.'updatepostponed.sql');
			echo "Game ".$k." set as <b>postponed</b>.<br />\n";
		}
	}

	// The $vs variable determines the relative significance of venue form vs overall form
	$vs=1;
	// The $sr variable determines GA figure to be 'better than' to get stopping power points
	$sr=3;

	include($qrydir.'allpred.sql');

	// Set up the Game Date arrays for each team
	// $od = overall date, $hd = home date, $ad = away date
	while ($r=mysql_fetch_assoc($gd)) {
		// Get the relevant values out of the current row
		$t1=$r['T1I'];
		$t2=$r['T2I'];
		$dt=$r['GDt'];
		// Increment counters for the teams
		$ht[$t1]++;
		$at[$t2]++;
		$ot[$t1]++;
		$ot[$t2]++;
		// if it's one of the last 6, put the date in an array
		$hd[$t1]=($ht[$t1]<=6 ? $dt : $hd[$t1]);
		$ad[$t2]=($at[$t2]<=6 ? $dt : $ad[$t2]);
		$od[$t1]=($ot[$t1]<=6 ? $dt : $od[$t1]);
		$od[$t2]=($ot[$t2]<=6 ? $dt : $od[$t2]);
	}

	// Sort by key (into team id order)
	ksort($hd);
	ksort($ad);
	ksort($od);

	// Reset the query and counters
	mysql_data_seek($gd ,0);
	foreach ($ht as $k => $v) {
		$ot[$k]=0;
		$ht[$k]=0;
		$at[$k]=0;
	}

	// Add up the form values for each team
	// $ofv = Overall Form Value, $hfv = Home Form Value, $afv = Away Form Value
	// $ogp = Overall Goal Power, $hgp = Home Goal Power, $agp = Away Goal Power
	// $osp = Overall Stopping Power, $hsp = Home Stopping Power, $asp = Away Stopping Power
	while ($r=mysql_fetch_assoc($gd)) {
		// Get the relevant values out of the current row
		$dt=$r['GDt'];
		$t1=$r['T1I'];
		$g1=$r['T1G'];
		$t2=$r['T2I'];
		$g2=$r['T2G'];
		// Result value
		$rv=($g1>$g2 ? 1 : ($g1<$g2 ? -1 : 0));
		// Home team
		if ($ht[$t1]<=6) {
			//Set up game significance
			$sig=(7-$ht[$t1]);
			// Add values NB: Venue significance IS used here.
			$hfv[$t1]=$hfv[$t1]+($rv * $sig * $vs);
			$hgp[$t1]=$hgp[$t1]+($g1 * $sig * $vs);
			$hsp[$t1]=$hsp[$t1]+(($sr-$g2) * $sig * $vs);
			// Increment the home counter
			$ht[$t1]++;
		}
		// Overall for home team
		if ($ot[$t1]<=6) {
			//Set up game significance
			$sig=(7-$ot[$t1]);
			// Add values NB: Venue significance NOT used here.
			$ofv[$t1]=$ofv[$t1]+($rv * $sig);
			$ogp[$t1]=$ogp[$t1]+($g1 * $sig);
			$osp[$t1]=$osp[$t1]+(($sr-$g2) * $sig);
			// Increment the overall counter
			$ot[$t1]++;
		}

		// Away team
		if ($at[$t2]<=6) {
			//Set up game significance
			$sig=(7-$at[$t2]);
			// Add values NB: Venue significance IS used here.
			$afv[$t2]=$afv[$t2]+($rv * $sig * $vs * (-1));
			$agp[$t2]=$agp[$t2]+($g2 * $sig * $vs);
			$asp[$t2]=$asp[$t2]+(($sr-$g1) * $sig * $vs);
			// Increment the away counter
			$at[$t2]++;
		}
		// Overall for away team
		if ($ot[$t2]<=6) {
			//Set up game significance
			$sig=(7-$ot[$t2]);
			// Add values NB: Venue significance NOT used here.
			$ofv[$t2]=$ofv[$t2]+($rv * $sig * (-1));
			$ogp[$t2]=$ogp[$t2]+($g1 * $sig);
			$osp[$t2]=$osp[$t2]+(($sr-$g1) * $sig);
			// Increment the overall counter
			$ot[$t2]++;
		}
	}

	while ($r=mysql_fetch_assoc($rf)) {

		$gm=$r['GID'];
		$t1=$r['T1I'];
		$t2=$r['T2I'];

		$GP1=$hgp[$t1] + $ogp[$t1];
		$SP1=$hsp[$t1] + $osp[$t1];
		$GP2=$agp[$t2] + $ogp[$t2];
		$SP2=$asp[$t2] + $osp[$t2];

		$FV1=$hfv[$t1] + $ofv[$t1] + (($GP1+$SP1) / 5);
		$FV2=$afv[$t2] + $ofv[$t2] + (($GP2+$SP2) / 5);

		$predscore[$gm]=$FV1-$FV2;

		if ($predscore[$gm]>10) {
			$restext[$gm]="HW";
			$predPC[$gm]=$predscore[$gm] * 2;
			$scoretext[$gm]=round((($GP1-$SP2)<1 ? 0 : ($GP1-$SP2)/15))." - ".round((($GP2-$SP1)<1 ? 0 : ($GP2-$SP1)/15));
		}
		elseif ($predscore[$gm]<(-10)) {
			$restext[$gm]="AW";
			$predPC[$gm]=abs($predscore[$gm]) * 2;
			$scoretext[$gm]=round((($GP1-$SP2)<1 ? 0 : ($GP1-$SP2)/15))." - ".round((($GP2-$SP1)<1 ? 0 : ($GP2-$SP1)/15));
		}
		else {
			$predPC[$gm]=(10-abs($predscore[$gm])) * 10;
			$scoretext[$gm]=round((($GP1-$SP2)<1 ? 0 : ($GP1-$SP2)/15))." - ".round((($GP2-$SP1)<1 ? 0 : ($GP2-$SP1)/15));
			$restext[$gm]=("0 - 0"==$scoretext[$gm] ? "ND" : "SD");
		}

	}

	include($qrydir.'updatepred.sql');
}

echo "</font>";
echo "<form action=\"".$_SERVER['PHP_SELF']."?comp=".$comp."&view=4\" method=\"post\">\n";
echo "<input type=submit Value=\"OK\">\n";
echo "</form>\n";


?>