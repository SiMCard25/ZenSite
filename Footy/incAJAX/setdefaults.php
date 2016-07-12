<?php

// if no season set, use 2006
if ((isset($_GET['season'])) && (is_numeric($_GET['season']))) {
	$season = $_GET['season'];
}
else {
    $season = date("Y") - (7>date("n") ? 1 : 0);
}

// if no comp set, use Premiership
if ((isset($_GET['comp'])) && (is_numeric($_GET['comp']))) {
	$comp = $_GET['comp'];
}
else {
	$comp = 0;
}

// if no view set, use Fix / Res
if ((isset($_GET['view'])) && (is_numeric($_GET['view']))) {
	$view = $_GET['view'];
}
else {
	$view = 0;
}

// if no teamid set, use 0
if ((isset($_GET['teamid'])) && (is_numeric($_GET['teamid']))) {
	$teamid = $_GET['teamid'];
}
else {
	$teamid = 0;
}

// if no gameid set, use 0
if ((isset($_GET['gameid'])) && (is_numeric($_GET['gameid']))) {
	$gameid = $_GET['gameid'];
}
else {
	$gameid = 0;
}

// set the referrer info
$referrer=(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF']);

$WinCol="Green";
$NDrawCol="BurlyWood";
$SDrawCol="Chocolate";
$LoseCol="DarkRed";
$DateCol="DimGray";
$TodayCol="DarkOrange";
$SoonCol="DarkCyan";
$LateCol="DarkSalmon";
$SameTeamCol="Navy";

include ($qrydir.'init.sql');

if (5==$view) {
	$pagetitle = "All Competitions - ".$SeasonName[$season]." - Predictions";
}
else {
	$pagetitle=$CompFullName[$comp]." - ".$SeasonName[$season]." - ";
	switch ($view) {
		case 1:  $pagetitle .= "League Table";
             break;
    case 2:  $pagetitle .= "Form Tables";
             break;
    case 3:  $pagetitle .= "Team Detail";
             break;
    case 4:  $pagetitle .= "Awaited Results";
             break;
    case 90: $pagetitle .= "Apply Results";
             break;
    case 91: $pagetitle .= "Password Check";
             break;
    case 92: $pagetitle .= "Edit Result";
             break;
    default: $pagetitle .= "Fixtures / Results";
             break;
  }
}

$month=(5==date("n") ? "Mayy" : substr(date("F"),0,4));
$password = $month.date("Y");

?>