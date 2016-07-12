<?php

// do predictions in SQL
$sql = "DELETE FROM prediction";

$pl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
INSERT INTO prediction
(SSt ,GID ,FGD ,GDt ,CID ,CFN ,HID ,HSN ,AID ,ASN ,Res ,PPc ,HGP ,AGP ,PRk ,ORk)
SELECT
 SSt
,GID
,FGD
,GDt
,CID
,CFN
,HID
,HSN
,AID
,ASN
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
   ,AID AS AID
   ,ASN AS ASN
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
         FROM Next_7_Days_Games
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

$sql="SELECT * FROM prediction
ORDER BY CID ,FGD ,HSN
"
;

$pl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT 
 FGD
,GDt
,CID
,CFN
,HID
,HSN
,AID
,ASN
,Res
,PPc
,HGP
,AGP
FROM
 ( SELECT
    P1.FGD AS FGD
   ,P1.GDt AS GDt
   ,P1.CID AS CID
   ,P1.CFN AS CFN
   ,P1.HID AS HID
   ,P1.HSN AS HSN
   ,P1.AID AS AID
   ,P1.ASN AS ASN
   ,P1.Res AS Res
   ,P1.PPc AS PPc
   ,P1.HGP AS HGP
   ,P1.AGP AS AGP
   ,P1.PRk AS PRk
   ,P1.ORk AS ORk
   ,IF ( @ci=P1.CID
        ,IF ( @rs=P1.Res
             ,@rr:=@rr+1
             ,@rr:=1+least(0 ,@rs:=Res)
            )
        ,@rr:=1+least(0 ,@ci:=CID ,@rs:=Res)
       ) AS RRk
   FROM
    prediction P1
      CROSS JOIN
    ( SELECT (@ci:=0) ) CI
      CROSS JOIN
    ( SELECT (@rs:=0) ) RS
      CROSS JOIN
    ( SELECT (@rr:=0) ) RR
   ORDER BY P1.CID ,P1.Res ,P1.PPc DESC
 ) RRk
WHERE RRk=1
ORDER BY CID ,Res
"
;

$rl = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Get Best bets by Result and Division
$sql="
SELECT * FROM prediction
WHERE PRk = 1
ORDER BY CID ,(CASE Res WHEN 'HW' THEN 1 WHEN 'AW' THEN 2 WHEN 'SD' THEN 3 ELSE 9 END)
"
;

$br = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Get Union Jack Predictions
// Reorder predictions into grid position
$sql="
SELECT 
 CASE ORk
     WHEN 1 THEN 5
     WHEN 2 THEN 1
     WHEN 3 THEN 9
     WHEN 4 THEN 3
     WHEN 5 THEN 7
     WHEN 6 THEN 2
     WHEN 7 THEN 8
     WHEN 8 THEN 4
     WHEN 9 THEN 6
 END AS Pos
,HID
,HSN
,Res
,PPc
FROM prediction
WHERE ORk <= 9
ORDER BY Pos
"
;

$uj = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

// Get Top 7 Predictions
$sql="
SELECT 
 HID
,HSN
,Res
,PPc
FROM prediction
WHERE ORk <= 7
ORDER BY ORk
"
;

$t7 = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>