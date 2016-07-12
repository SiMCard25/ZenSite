<?php
$sql="
SELECT
 GRs.TeamID                                AS TID
,GRs.GameDate                              AS FGD
,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
,GRs.Venue                                 AS Ven
,GRs.OppositionID                          AS OID
,GRs.OppositionName                        AS ONm
,GRs.GoalsFor                              AS GlF
,GRs.GoalsAgainst                          AS GlA
,CASE WHEN GRs.Won  = 1 THEN 'W'
      WHEN GRs.Lost = 1 THEN 'L'
      ELSE ( CASE WHEN GRs.GoalsFor = 0
                  THEN 'N'
                  ELSE 'D'
             END
           )
 END                                       AS Res
,(@ap:=@ap + GRs.GamePoints)               AS Pts
FROM
 GameResult GRs
   CROSS JOIN
 ( SELECT (@ap:=PointAdjustment)
   FROM   team_season
   WHERE  TeamID=".$teamid."
     AND  SeasonStart=".$season."
 ) X
WHERE
    GRs.TeamID=".$teamid."
AND GRs.SeasonStart=".$season."
ORDER BY GRs.GameDate ,GRs.OppositionName
"
;

$reslist=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT
 SSt                              AS SSt
,GID                              AS GID
,TID                              AS TID
,GDt                              AS FGD
,DATE_FORMAT(GDt ,'%a, %d %b %y') AS GDt
,Ven                              AS Ven
,OID                              AS OID
,OFN                              AS OFN
,TVFm                             AS TVFm
,TVGP                             AS TVGP
,TVLF                             AS TVLF
,TOFm                             AS TOFm
,TOGP                             AS TOGP
,TOLF                             AS TOLF
,OVFm                             AS OVFm
,OVGP                             AS OVGP
,OVLF                             AS OVLF
,OOFm                             AS OOFm
,OOGP                             AS OOGP
,OOLF                             AS OOLF
FROM FormFix
WHERE
    TID=".$teamid."
AND SSt=".$season."
ORDER BY FGD ,OFN
"
;

$fixlist=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '1B'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    HomeResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Best Result */
    GRs.GamePoints     DESC
   ,GRs.GoalDifference DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '2W'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    HomeResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Worst Result */
    GRs.GamePoints
   ,GRs.GoalDifference
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '3A'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    HomeResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Largest Aggregate */
    (GRs.GoalsFor + GRs.GoalsAgainst) DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
ORDER BY VRs
"
;

$hrec=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '1B'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    AwayResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Best Result */
    GRs.GamePoints     DESC
   ,GRs.GoalDifference DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '2W'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    AwayResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Worst Result */
    GRs.GamePoints
   ,GRs.GoalDifference
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,'<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '3A'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    AwayResults GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Largest Aggregate */
    (GRs.GoalsFor + GRs.GoalsAgainst) DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
ORDER BY VRs
"
;

$arec=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,' (' ,Ven ,')<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '1B'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,CAST (GRs.Venue AS CHAR(1))               AS Ven
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    GameResult  GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Best Result */
    GRs.GamePoints     DESC
   ,GRs.GoalDifference DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,' (' ,Ven ,')<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '2W'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,CAST (GRs.Venue AS CHAR(1))               AS Ven
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    GameResult  GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Worst Result */
    GRs.GamePoints
   ,GRs.GoalDifference
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
UNION
SELECT VRs ,CONCAT(GlF ,'-' ,GlA ,' vs ' ,OFN ,' (' ,Ven ,')<td>' ,GDt) AS ResText
FROM
 ( SELECT 
    '3A'                                      AS VRs
   ,DATE_FORMAT(GRs.GameDate ,'%a, %d %b %y') AS GDt
   ,CAST (GRs.Venue AS CHAR(1))               AS Ven
   ,GRs.GoalsFor                              AS GlF
   ,GRs.GoalsAgainst                          AS GlA
   ,TEA.FullName                              AS OFN
   ,TEA.ShortName                             AS OSN
   ,(@gr:=@gr+1)                              AS GRk
   FROM
    GameResult  GRs
      INNER JOIN
    team        TEA
        ON  TEA.TeamID = GRs.OppositionID
      CROSS JOIN
    ( SELECT (@gr:=0)) GOr
   WHERE GRs.TeamID      = ".$teamid."
   AND   GRs.SeasonStart = ".$season."
   ORDER BY
   /* Largest Aggregate */
    (GRs.GoalsFor + GRs.GoalsAgainst) DESC
   ,GRs.GameDate
 ) DT
WHERE DT.GRk = 1
ORDER BY VRs
"
;

$orec=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql="
      SELECT
       tm1.TeamID          AS TID
      ,tm1.FullName        AS TFN
      ,tm1.ShortName       AS TSN
      ,tm1.Tag             AS TTg
      ,tm1.LogoName        AS LNm
      ,tm1.LogoLink        AS LLk
      ,tm1.Colour1         AS Cl1
      ,tm1.Colour2         AS Cl2
      ,tm1.Colour3         AS Cl3
      ,tsn.CompetitionID   AS CID
      ,cmp.FullName        AS CFN
      ,cmp.ShortName       AS CSN
      ,cmp.Tag             AS CTg
      ,tsn.PointAdjustment AS PAj
      FROM
       team        tm1
         INNER JOIN
       team_season tsn
           ON  tsn.TeamID      = tm1.TeamID
           AND tsn.SeasonStart = ".$season."
         INNER JOIN
       competition cmp
           ON  cmp.CompetitionID = tsn.CompetitionID
      WHERE tm1.TeamID=".$teamid."
     "
;

$td=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
SELECT
  MAX( CASE WHEN TPos = Tp1             THEN PPG ELSE 0 END ) AS T1
 ,MAX( CASE WHEN TPos = Tp2             THEN PPG ELSE 0 END ) AS T2
 ,MAX( CASE WHEN TPos = (TCt - Bm1 - 1) THEN PPG ELSE 0 END ) AS B1
FROM
(
        SELECT
         DT1.TID             AS TID
        ,DT1.TPld            AS TPld
        ,DT1.TPts + DT1.PAdj AS TPts
        ,TPts / TPld         AS PPG
        ,DT1.TCt             AS TCt
        ,DT1.Tp1             AS Tp1
        ,DT1.Tp2             AS Tp2
        ,DT1.Bm1             AS Bm1
        ,@tp := @tp +1       AS TPos
        FROM
         ( SELECT
            GRs.TeamID               AS TID
           ,Tms.TCt                  AS TCt
           ,cmp.Top1                 AS Tp1
           ,cmp.Top2                 AS Tp2
           ,cmp.Bottom1              AS Bm1
           ,COUNT(*)                 AS TPld
           ,SUM(GRs.GoalsFor      )  AS TGF
           ,SUM(GRs.GamePoints    )  AS TPts
           ,SUM(GRs.GoalDifference)  AS TDif
           ,SUM(TSn.PointAdjustment) AS PAdj
           FROM
            GameResult  GRs
              INNER JOIN
            team_season TSn
                ON  TSn.SeasonStart = GRs.SeasonStart
                AND TSn.TeamID      = GRs.TeamID
              INNER JOIN
            competition cmp
                ON  cmp.CompetitionID = TSn.CompetitionID
                AND ".$season."   BETWEEN cmp.StartSeason
                                      AND cmp.EndSeason
              CROSS JOIN
            ( SELECT COUNT(*) AS TCt
              FROM   team_season
              WHERE
                  SeasonStart   = ".$season."
              AND CompetitionID = ".$comp."
            ) Tms
           WHERE
                TSn.CompetitionID = ".$comp."
            AND GRs.SeasonStart   = ".$season."
           GROUP BY TID, TCt, Tp1 ,Tp2 ,Bm1
        ) DT1
          CROSS JOIN
       ( SELECT (@tp := 0) ) TPs
      ORDER BY TPts DESC ,TDif DESC ,TGF DESC ,TID
 ) DT11
 "
;

$ttb = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>