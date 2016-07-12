<?php
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
           SeasonID  AS SID
          ,FullName  AS SFN
          ,ShortName AS SSN
          FROM season
          ORDER BY SID
         "
;

$seasonlist= mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

while ($sl=mysql_fetch_assoc($seasonlist)) {
  $SeasonFullName[$sl['SID']]=$sl['SFN'];
  $SeasonShortName[$sl['SID']]=$sl['SSN'];
  }

// get the competition list
$sql = "
          SELECT
           CompetitionID AS CID
          ,FullName      AS CFN
          ,ShortName     AS CSN
          ,Tag           AS CTg
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
  }

mysql_data_seek($complist ,0);

?>