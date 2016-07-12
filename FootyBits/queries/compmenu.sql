<?php
// get the seasons list
$sql = "
          SELECT
           SeasonStart AS SSt
          ,SeasonStart + 1 AS SEn
          FROM game
          GROUP BY SSt ,SEn
          ORDER BY SSt DESC
         "
;

$seasonlist= mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

while ($sl=mysql_fetch_assoc($seasonlist)) {
  $SeasonName[$sl['SSt']]=$sl['SSt']."-".$sl['SEn']%100;
  }

// get the competition list
$sql = "
          SELECT
           CompetitionID AS CID
          ,FullName      AS CFN
          ,ShortName     AS CSN
          ,Tag           AS CTg
          ,LogoName      AS CLN
          FROM competition
          ORDER BY CID
         "
;

$complist= mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

while ($cr=mysql_fetch_assoc($complist)) {
  $CompFullName[$cr['CID']]=$cr['CFN'];
  $CompShortName[$cr['CID']]=$cr['CSN'];
  $CompTag[$cr['CID']]=$cr['CTg'];
  $CompLogo[$cr['CID']]=$cr['CLN'];
  }

mysql_data_seek($complist ,0);

// Get the current competition's details
$sql="
        SELECT
         CompetitionID AS CID
        ,FullName      AS CFN
        ,ShortName     AS CSN
        ,LogoName      AS CLN
        ,Tag           AS CTg
        ,Top1          AS Tp1
        ,Top2          AS Tp2
        ,Bottom1       AS Btm
        FROM competition
        WHERE CompetitionID = ".$comp
;

$cnres = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$cnames = mysql_fetch_assoc($cnres);

?>