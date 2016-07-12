<?php
// Drop temp_pw table if it exists
$sql= "DROP TABLE temp_pw"
;

$dt = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// CREATE temp_pw table
$sql = "
        CREATE TEMPORARY TABLE temp_pw
        (PW        CHAR(6) NOT NULL
        ,PRIMARY KEY (PW)
        ) ENGINE=MEMORY
         "
;

$ct = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// INSERT temp_pw table
$sql = "
        INSERT INTO temp_pw (PW)
        SELECT DATE_FORMAT(NOW() ,'%y%m%d')
         "
;

$iq = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Drop temp_dates table if it exists
$sql= "DROP TABLE temp_dates"
;

$cq = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// CREATE temp_dates table
$sql = "
        CREATE TEMPORARY TABLE temp_dates
        (DateToday DATE NOT NULL
        ,DatePlus7 DATE NOT NULL
        ,PRIMARY KEY (DateToday)
        ) ENGINE=MEMORY
         "
;

$cq = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// INSERT temp_dates table
$sql = "
        INSERT INTO temp_dates
        SELECT
         NOW()
        ,ADDDATE(NOW() ,INTERVAL 7 DAY)
         "
;

$iq = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// get the seasons list
$sql = "
          SELECT
           SeasonStart AS SSt
          ,SeasonStart + 1 AS SEn
          FROM game
          GROUP BY SSt ,SEn
          ORDER BY SSt
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
          ,LogoLink      AS CLL
          ,LogoName      AS CLN
          ,Prefix        AS PFX
          FROM competition
          WHERE ".$season." BETWEEN StartSeason AND EndSeason
          ORDER BY CID
         "
;

$complist=mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

while ($cr=mysql_fetch_assoc($complist)) {
  $CompFullName[$cr['CID']]=$cr['CFN'];
  $CompShortName[$cr['CID']]=$cr['CSN'];
  $CompTag[$cr['CID']]=$cr['CTg'];
//  $CompLogo[$cr['CID']]=$cr['CLN'];
  $CompLogo[$cr['CID']]=$cr['CLL'];
  $CompPrefix[$cr['CID']]=$cr['PFX'];
  $CompStartSeason[$cr['CID']]=$cr['SSN'];
  $CompEndSeason[$cr['CID']]=$cr['ESN'];
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
        ,Prefix        AS Pfx
        FROM competition
        WHERE
            CompetitionID = ".$comp."
        AND ".$season." BETWEEN StartSeason AND EndSeason"
;

$cnres = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$cnames = mysql_fetch_assoc($cnres);

?>