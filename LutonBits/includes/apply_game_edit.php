<?php

$Vet_OK=TRUE;

// Get all $_POST data
$EGD_Cmp = $_POST['optCmp'];
$EGD_CRd = $_POST['txtCRd'];
$EGD_CRI = $_POST['txtCRI'];
$EGD_GDt = $_POST['txtGDt'];
$EGD_GMn = $_POST['txtGMn'];
$EGD_Opp = $_POST['optOpp'];
$EGD_Ven = $_POST['optVen'];
$EGD_Kit = $_POST['optKit'];
$EGD_FTF = $_POST['txtFTF'];
$EGD_FTA = $_POST['txtFTA'];
if (90<$EGD_GMn) {
	$EGD_ETF = $_POST['txtETF'];
	$EGD_ETA = $_POST['txtETA'];
	$EGD_PnF = $_POST['txtPnF'];
	$EGD_PnA = $_POST['txtPnA'];
}

$EGD_GF01 = $_POST['txtGF01'];
$EGD_GF02 = $_POST['txtGF02'];
$EGD_GF03 = $_POST['txtGF03'];
$EGD_GF04 = $_POST['txtGF04'];
$EGD_GF05 = $_POST['txtGF05'];
$EGD_GF06 = $_POST['txtGF06'];
$EGD_GF07 = $_POST['txtGF07'];
$EGD_GF08 = $_POST['txtGF08'];
$EGD_GF09 = $_POST['txtGF09'];
$EGD_GF10 = $_POST['txtGF10'];

$EGD_GA01 = $_POST['txtGA01'];
$EGD_GA02 = $_POST['txtGA02'];
$EGD_GA03 = $_POST['txtGA03'];
$EGD_GA04 = $_POST['txtGA04'];
$EGD_GA05 = $_POST['txtGA05'];
$EGD_GA06 = $_POST['txtGA06'];
$EGD_GA07 = $_POST['txtGA07'];
$EGD_GA08 = $_POST['txtGA08'];
$EGD_GA09 = $_POST['txtGA09'];
$EGD_GA10 = $_POST['txtGA10'];

// vet the data and feed back
print "<script language=javascript>\n";

// Replay Indicator should be 0 or 1
// print "<!-- \$EGD_CRI = ".$EGD_CRI." -->\n";
if (0!=$EGD_CRI AND 1!=$EGD_CRI) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Replay Indicator Value supplied: ".$EGD_CRI."\");\n";
}

// Check supplied Game Date
// print "<!-- \$EGD_GDt = ".$EGD_GDt." -->\n";
$GDy = substr($EGD_GDt,strrpos($EGD_GDt,"-")+1,2);
$GMt = substr($EGD_GDt,strpos($EGD_GDt,"-")+1,2);
$GYr = substr($EGD_GDt,0 ,4);
// print "<!-- \$GDy = ".$GDy." -->\n";
// print "<!-- \$GMt = ".$GMt." -->\n";
// print "<!-- \$GYr = ".$GYr." -->\n";

if (!checkdate($GMt ,$GDy ,$GYr)) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Game Date supplied: ".$EGD_GDt."\");\n";
}

// Check Game Minutes is numeric
// print "<!-- \$EGD_GMn = ".$EGD_GMn." -->\n";
if (!is_numeric($EGD_GMn)) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Game Length: ".$EGD_GMn."\");\n";
}

// Check goals are numeric or '-' (converted to NULL in SQL)
// print "<!-- \$EGD_FTF = ".$EGD_FTF." -->\n";
if ("-"!=$EGD_FTF AND !is_numeric($EGD_FTF)) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Full-Time Goals For: ".$EGD_FTF."\");\n";
}

// print "<!-- \$EGD_FTA = ".$EGD_FTA." -->\n";
if ("-"!=$EGD_FTA AND !is_numeric($EGD_FTA)) {
  $Vet_OK=FALSE;
  print "alert(\"Invalid Full-Time Goals Against: ".$EGD_FTA."\");\n";
}

if (90<$row1['GMn']) {
	// print "<!-- \$EGD_ETF = ".$EGD_ETF." -->\n";
	if ("-"!=$EGD_ETF AND !is_numeric($EGD_ETF)) {
		$Vet_OK=FALSE;
		print "alert(\"Invalid Extra Time Goals For: ".$EGD_ETF."\");\n";
	}

  // print "<!-- \$EGD_ETA = ".$EGD_ETA." -->\n";
  if ("-"!=$EGD_ETA AND !is_numeric($EGD_ETA)) {
    $Vet_OK=FALSE;
    print "alert(\"Invalid Extra Time Goals Against: ".$EGD_ETA."\");\n";
  }
  
  // print "<!-- \$EGD_PnF = ".$EGD_PnF." -->\n";
  if ("-"!=$EGD_PnF AND !is_numeric($EGD_PnF)) {
    $Vet_OK=FALSE;
    print "alert(\"Invalid Penalties For: ".$EGD_PnF."\");\n";
  }
  
  // print "<!-- \$EGD_PnA = ".$EGD_PnA." -->\n";
  if ("-"!=$EGD_PnA AND !is_numeric($EGD_PnA)) {
    $Vet_OK=FALSE;
    print "alert(\"Invalid Penalties Against: ".$EGD_PnA."\");\n";
  }
}

// Goal timings - sod individual messages!
$All_GT=TRUE;
$All_GT=(GT_OK($EGD_GF01) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF02) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF03) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF04) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF05) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF06) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF07) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF08) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF09) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GF10) ? $All_GT : FALSE);

$All_GT=(GT_OK($EGD_GA01) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA02) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA03) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA04) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA05) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA06) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA07) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA08) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA09) ? $All_GT : FALSE);
$All_GT=(GT_OK($EGD_GA10) ? $All_GT : FALSE);

if (!$All_GT) {
	$Vet_OK=FALSE;
	print "alert(\"Invalid Goal Timing (somewhere..!)\");\n";
}

$Vet_OK=($All_GT ? $Vet_OK : FALSE);

if ($Vet_OK) {
  require_once($qrydir."ApplyGameUpdate.sql");
  if ($UpdOK) {
//    print "alert(\"Data OK\\nUpdate Applied\");\n";
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