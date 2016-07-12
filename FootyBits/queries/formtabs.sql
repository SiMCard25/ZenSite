<?php
$sql = "
SELECT
 TID
,TSN
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
FROM
 ( SELECT 
    tm.TeamID          AS TID
   ,tm.ShortName       AS TSN
   ,GRs.GoalsFor       AS GlF
   ,GRs.GoalsAgainst   AS GlA
   ,GRs.Won            AS Won
   ,GRs.Drawn          AS Drn
   ,GRs.Lost           AS Lst
   ,GRs.GamePoints     AS GPt
   ,GRs.GoalDifference AS GDf
   ,IF (@tno=GRs.TeamID
       ,@gn:=@gn+1
       ,@gn:=1+least(0 ,@tno:=GRs.TeamID)
       )               AS GRk
   FROM
    HomeResults         GRs
      INNER JOIN
    team_season         tsn
        ON  tsn.TeamID        = GRs.TeamID
        AND tsn.SeasonStart   = ".$season."
        AND tsn.CompetitionID = ".$comp."
      INNER JOIN
    team                tm
        ON  tm.TeamID = GRs.TeamID
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
      CROSS JOIN
    (SELECT (@tno := 0)) TNo
   ORDER BY GRs.TeamID ,GRs.GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY TID ,TSN
ORDER BY Pts DESC ,GDf DESC ,GlF DESC ,TSN 
"
;

$hf = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
SELECT
 TID
,TSN
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
FROM
 ( SELECT 
    tm.TeamID          AS TID
   ,tm.ShortName       AS TSN
   ,GRs.GoalsFor       AS GlF
   ,GRs.GoalsAgainst   AS GlA
   ,GRs.Won            AS Won
   ,GRs.Drawn          AS Drn
   ,GRs.Lost           AS Lst
   ,GRs.GamePoints     AS GPt
   ,GRs.GoalDifference AS GDf
   ,IF (@tno=GRs.TeamID
       ,@gn:=@gn+1
       ,@gn:=1+least(0 ,@tno:=GRs.TeamID)
       )               AS GRk
   FROM
    AwayResults          GRs
      INNER JOIN
    team_season         tsn
        ON  tsn.TeamID        = GRs.TeamID
        AND tsn.SeasonStart   = ".$season."
        AND tsn.CompetitionID = ".$comp."
      INNER JOIN
    team                tm
        ON  tm.TeamID = GRs.TeamID
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
      CROSS JOIN
    (SELECT (@tno := 0)) TNo
   ORDER BY GRs.TeamID ,GRs.GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY TID ,TSN
ORDER BY Pts DESC ,GDf DESC ,GlF DESC ,TSN 
"
;

$af = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
SELECT
 TID
,TSN
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
FROM
 ( SELECT 
    tm.TeamID          AS TID
   ,tm.ShortName       AS TSN
   ,GRs.GoalsFor       AS GlF
   ,GRs.GoalsAgainst   AS GlA
   ,GRs.Won            AS Won
   ,GRs.Drawn          AS Drn
   ,GRs.Lost           AS Lst
   ,GRs.GamePoints     AS GPt
   ,GRs.GoalDifference AS GDf
   ,IF (@tno=GRs.TeamID
       ,@gn:=@gn+1
       ,@gn:=1+least(0 ,@tno:=GRs.TeamID)
       )               AS GRk
   FROM
    GameResult          GRs
      INNER JOIN
    team_season         tsn
        ON  tsn.TeamID        = GRs.TeamID
        AND tsn.SeasonStart   = ".$season."
        AND tsn.CompetitionID = ".$comp."
      INNER JOIN
    team                tm
        ON  tm.TeamID = GRs.TeamID
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
      CROSS JOIN
    (SELECT (@tno := 0)) TNo
   ORDER BY GRs.TeamID ,GRs.GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY TID ,TSN
ORDER BY Pts DESC ,GDf DESC ,GlF DESC ,TSN 
"
;

$of = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}
?>