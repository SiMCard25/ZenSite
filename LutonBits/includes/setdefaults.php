<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/* Get details from $_GET array.                                                                     */
/* playerid goes to $playerid (default 999 = squad overview)                                         */
/* gameid   goes to $gameid                                                                          */
/* season   goes to $season (default current year)                                                   */
/* view Descriptions (goes to $view)                                                                 */
/* =================                                                                                 */
/*  1 Player / Squad view (default)
/*  2 Game View                                                                                      */
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/// if no player set, use 999
if ((isset($_GET['playerid'])) && (is_numeric($_GET['playerid']))) {
  $playerid = $_GET['playerid'];
	}
else {
	$playerid = 999;
	}

// if no season set, use current season
if ((isset($_GET['season'])) && (is_numeric($_GET['season']))) {
	$season = $_GET['season'];
}
else {
    $season = date("Y") - (7>date("n") ? 1 : 0);
}

// if no view set, use Team Overview
if ((isset($_GET['view'])) && (is_numeric($_GET['view']))) {
	$view = $_GET['view'];
}
else {
	$view = 1;
}

// if no sort order set, use Squad Number
if ((isset($_GET['so'])) && (is_numeric($_GET['so']))) {
	$sortorder = $_GET['so'];
}
else {
	$sortorder = 0;
}

// if no gameid set, use 0
if ((isset($_GET['gameid'])) && (is_numeric($_GET['gameid']))) {
	$gameid = $_GET['gameid'];
}
else {
	$gameid = -1;
}

// set the referrer info
$referrer=(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF']);

//$WinCol="Green";
//$NDrawCol="BurlyWood";
//$SDrawCol="Chocolate";
//$LoseCol="DarkRed";
//$DateCol="DimGray";
//$TodayCol="DarkOrange";
//$SoonCol="DarkCyan";
//$LateCol="DarkSalmon";
//$SameTeamCol="Navy";

include ($qrydir.'init.sql');

$pagetitle="Luton Town Data - ".$SeasonShortName[$season]." - ";
switch ($view) {
  case 2:  $pagetitle .= "Game Detail";
           break;
  case 90: $pagetitle .= "Password Verification";
           break;
  case 91: $pagetitle .= "New Player";
           break;
  case 92: $pagetitle .= "Edit Player";
           break;
  case 93: $pagetitle .= "New Game";
           break;
  case 94: $pagetitle .= "Edit Game";
           break;
	default: $pagetitle .= (999==$playerid ? "Squad Overview" : "Player Detail");
           break;
}

$month=(5==date("n") ? "Mayy" : substr(date("F"),0,4));
$pw = $month.date("Y");

?>