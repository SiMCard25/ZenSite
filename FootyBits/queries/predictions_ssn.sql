<?php
// This script does the predictions for the rest of the season.
// do predictions in SQL
$sql = "DELETE FROM prediction";

$pl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
INSERT INTO prediction
(SSt ,GID ,FGD ,GDt ,CID ,CFN ,HID ,HSN ,HFN ,AID ,ASN ,AFN ,Res ,PPc ,HGP ,AGP ,PRk ,ORk)
SELECT
 SSt
,GID
,FGD
,GDt
,CID
,CFN
,HID
,HSN
,HFN
,AID
,ASN
,AFN
,Res
,PPc
,HGP
,AGP
,IF (@ci=CID
    ,IF (@rr=Res
        ,@pr:=@pr+1
        ,@pr:=1 + least(0 ,@rr:=Res)
        )
    ,@pr:=1 + least(0 ,@ci:=CID)
    ) AS PRk
,ORk
FROM
 ( SELECT
    SSt AS SSt
   ,GID AS GID
   ,FGD AS FGD
   ,GDt AS GDt
   ,CID AS CID
   ,CFN AS CFN
   ,HID AS HID
   ,HSN AS HSN
   ,HFN AS HFN
   ,AID AS AID
   ,ASN AS ASN
   ,AFN AS AFN
   ,Res AS Res
   ,PPc AS PPc
   ,CASE Res
        WHEN 'HW' THEN ( CASE WHEN HGl = 0
                              THEN 1
                              ELSE HGl
                         END
                       )
        WHEN 'AW' THEN ( CASE WHEN AGl = 0 
                              THEN 1
                              WHEN HGl >= AGl 
                              THEN AGl-1
                              ELSE HGl
                         END
                       )
        WHEN 'ND' THEN 0
        WHEN 'SD' THEN ( CASE WHEN HGl = 0
                              THEN 1
                              ELSE HGl
                         END
                       )
    END AS HGP
   ,CASE Res
        WHEN 'AW' THEN ( CASE WHEN HGl = 0
                              THEN 1
                              ELSE HGl
                         END
                       )
        WHEN 'HW' THEN ( CASE WHEN HGl = 0 
                              THEN 1
                              WHEN AGl >= HGl
                              THEN HGl-1
                              ELSE AGl
                         END
                       )
        WHEN 'ND' THEN 0
        WHEN 'SD' THEN ( CASE WHEN HGl = 0
                              THEN 1
                              ELSE HGl
                         END
                       )
    END AS AGP
   ,(@or:=@or+1) AS ORk
   FROM
    ( SELECT
       SSt AS SSt
      ,GID AS GID
      ,FGD AS FGD
      ,GDt AS GDt
      ,CID AS CID
      ,CTg AS CTg
      ,CSN AS CSN
      ,CFN AS CFN
      ,HID AS HID
      ,HSN AS HSN
      ,HFN AS HFN
      ,AID AS AID
      ,ASN AS ASN
      ,AFN AS AFN
      ,CASE WHEN FSc >=  25 THEN 'HW'
            WHEN FSc <= -25 THEN 'AW'
            ELSE ( CASE WHEN HGs > 2
                        THEN 'SD'
                        ELSE 'ND'
                   END
                 )
       END AS Res
      ,CASE WHEN ABS(FSc) <= 25
            THEN ( 100 - (ABS(FSc) * 4))
            ELSE LEAST(100 ,ABS(FSc) - 25)
       END AS PPc
      ,CAST(((HGs / 3) + 0.5) AS UNSIGNED) AS HGl
      ,CAST(((AGs / 3) + 0.5) AS UNSIGNED) AS AGl
      FROM
       ( SELECT
          SSt                           AS SSt
         ,GID                           AS GID
         ,FGD                           AS FGD
         ,GDt                           AS GDt
         ,CID                           AS CID
         ,CTg                           AS CTg
         ,CSN                           AS CSN
         ,CFN                           AS CFN
         ,HID                           AS HID
         ,HSN                           AS HSN
         ,HFN                           AS HFN
         ,AID                           AS AID
         ,ASN                           AS ASN
         ,AFN                           AS AFN
         ,(HFm*2) + HOF - (AFm*2) - AOF AS FSc
         ,CAST(((((HGP*2) + HOG + (ALF*2) + AOL) / 60) + 0.5) AS UNSIGNED) AS HGs
         ,CAST(((((AGP*2) + AOG + (HLF*2) + HOL) / 60) + 0.5) AS UNSIGNED) AS AGs
         FROM Unplayed_Games
         WHERE SSt=".$season."
           AND CID=".$comp."
       ) FSc
    ) Prd
      CROSS JOIN
    ( SELECT (@or:=0) ) OA
    ORDER BY PPc DESC ,FGD ,HID
 ) AllDone
   CROSS JOIN
 ( SELECT (@ci:=0) ) CI
   CROSS JOIN
 ( SELECT (@rr:='X') ) RR
   CROSS JOIN
 ( SELECT (@pr:=0) ) PR
ORDER BY CID ,Res ,PPc DESC ,FGD ,HID
"
;

$pl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "DROP TABLE temp_all_points"
;

$cr = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "
         CREATE TEMPORARY TABLE temp_all_points
         (CID SMALLINT UNSIGNED NOT NULL
         ,TID SMALLINT UNSIGNED NOT NULL
         ,TSN VARCHAR(15)
         ,PTp CHAR(1)
         ,Pts SMALLINT
         ,PRIMARY KEY (TID, PTp)
         ) ENGINE=MEMORY
        "
;

$cr = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
INSERT INTO temp_all_points (CID ,TID ,TSN ,PTp ,Pts)
SELECT
 TSn.CompetitionID   AS CID
,GRs.TeamID          AS TID
,Tm1.ShortName       AS TSN
,'P'                 AS PTp
,SUM(GRs.GamePoints) AS Pts
FROM
 GameResult  GRs
   INNER JOIN
 team_season TSn
     ON  TSn.SeasonStart = GRs.SeasonStart
     AND TSn.TeamID      = GRs.TeamID
   INNER JOIN
 team        Tm1
     ON  Tm1.TeamID = TSn.TeamID
WHERE
    TSn.CompetitionID = ".$comp."
AND GRs.SeasonStart   = ".$season."
GROUP BY TSn.CompetitionID ,GRs.TeamID ,Tm1.ShortName ,PTp
"
;

$pp = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
INSERT INTO temp_all_points (CID ,TID ,TSN ,PTp ,Pts)
SELECT
 TSn.CompetitionID   AS CID
,TSn.TeamID          AS TID
,Tm1.ShortName       AS TSN
,'D'                 AS PTp
,TSn.PointAdjustment AS Pts
FROM
 team_season TSn
   INNER JOIN
 team        Tm1
     ON  Tm1.TeamID = TSn.TeamID
WHERE
    TSn.CompetitionID = ".$comp."
AND TSn.SeasonStart   = ".$season."
GROUP BY TSn.CompetitionID ,TSn.TeamID ,Tm1.ShortName ,PTp
"
;

$pp = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
INSERT INTO temp_all_points (CID ,TID ,TSN ,PTp ,Pts)
SELECT
 CID AS CID
,HID AS TID
,HSN AS TSN
,'H' AS PTp
,SUM(CASE Res WHEN 'HW' THEN 3 WHEN 'AW' THEN 0 ELSE 1 END) AS Pts
FROM prediction
WHERE CID = ".$comp."
GROUP BY CID ,TID ,TSN ,PTp
"
;

$pp = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
INSERT INTO temp_all_points (CID ,TID ,TSN ,PTp ,Pts)
SELECT
 CID AS CID
,AID AS TID
,ASN AS TSN
,'A' AS PTp
,SUM(CASE Res WHEN 'AW' THEN 3 WHEN 'HW' THEN 0 ELSE 1 END) AS Pts
FROM prediction
WHERE CID = ".$comp."
GROUP BY CID ,TID ,TSN ,PTp
"
;

$pp = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT TID ,TSN ,SUM(Pts) AS Pts ,SUM(CASE PTp WHEN 'A' THEN Pts WHEN 'H' THEN Pts ELSE 0 END) AS Delta
FROM   temp_all_points
GROUP BY TID ,TSN
ORDER BY Pts DESC ,TSN
"
;

$pl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql= "DROP TABLE temp_all_points"
;

$cr = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>