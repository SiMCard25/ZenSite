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

// INSERT into temp_dates table
$sql = "INSERT INTO temp_dates VALUES (NOW() ,ADDDATE(NOW() ,INTERVAL 7 DAY))
       "
;

$iq = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* get the team list */
$sql = "
          SELECT
           gam.Team1ID    AS TID
          ,tm1.FullName   AS TFN
          ,tm1.ShortName  AS TSN
          ,tm1.Tag        AS TTg
          FROM
           game gam
             INNER JOIN
           team tm1
               ON  tm1.TeamID = gam.Team1ID
          WHERE gam.CompetitionID = ".$comp."
            AND gam.SeasonStart   = ".$season."
          GROUP BY TID ,TFN ,TSN ,TTG
          ORDER BY TFN
         "
;

$tmlist = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* get the game details */
$sql = "
          SELECT
           gam.GameID       AS GID
          ,gam.GameDate     AS GDt
          ,gam.Team1ID      AS T1I
          ,tm1.FullName     AS T1F
          ,tm1.ShortName    AS T1S
          ,tm1.Tag          AS T1T
          ,gam.Team1Goals   AS T1G
          ,gam.Team2ID      AS T2I
          ,tm2.FullName     AS T2F
          ,tm2.ShortName    AS T2S
          ,tm2.Tag          AS T2T
          ,gam.Team2Goals   AS T2G
          ,CASE WHEN gam.Team1Goals IS NULL
                THEN DATE_FORMAT(gam.GameDate ,'%e/%c')
                ELSE CONCAT(gam.Team1Goals ,' - ' ,gam.Team2Goals)
           END              AS FxR
          ,CASE WHEN gam.Team1Goals IS NULL
                THEN ( CASE WHEN gam.GameDate < tdt.DateToday
                            THEN 'resLate'
                            WHEN gam.GameDate = tdt.DateToday
                            THEN 'resToday'
                            WHEN gam.GameDate < tdt.DatePlus7
                            THEN 'resSoon'
                            ELSE 'resDate'
                       END
                     )
                ELSE ( CASE WHEN gam.Team1Goals > gam.Team2Goals THEN 'resW'
                            WHEN gam.Team1Goals < gam.Team2Goals THEN 'resL'
                            ELSE ( CASE WHEN gam.Team1Goals = 0
                                        THEN 'resN'
                                        ELSE 'resD'
                                   END
                                 )
                       END
                     )
           END              AS CCl
          FROM
           game       gam
             INNER JOIN
           team       tm1
               ON  tm1.TeamID = gam.Team1ID
             INNER JOIN
           team       tm2
               ON  tm2.TeamID = gam.Team2ID
             CROSS JOIN
           temp_dates tdt
          WHERE gam.CompetitionID = ".$comp."
            AND gam.SeasonStart   = ".$season."
          ORDER BY T1F ,T2F
         "
;

$gmdets = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>