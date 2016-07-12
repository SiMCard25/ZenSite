<?php

$sql = "
SELECT
 '3O'      AS Ven
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
,SUM(  (Won *  2 * (7-GRk))
     + (Lst * -2 * (7-GRk))
    )     AS Frm
,SUM(GlF * (7-GRk)) AS GPw
,SUM(GlA * (7-GRk)) AS LkF
FROM
 ( SELECT 
    GoalsFor       AS GlF
   ,GoalsAgainst   AS GlA
   ,Won            AS Won
   ,Drawn          AS Drn
   ,Lost           AS Lst
   ,GamePoints     AS GPt
   ,GoalDifference AS GDf
   ,(@gn:=@gn+1)   AS GRk
   FROM
    GameResult          RLT
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
   WHERE TeamID = ".$teamid."
   ORDER BY GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY Ven
UNION
SELECT
 '1H'      AS Ven
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
,SUM(  (Won *  2 * (7-GRk))
     + (Lst * -2 * (7-GRk))
    )     AS Frm
,SUM(GlF * (7-GRk)) AS GPw
,SUM(GlA * (7-GRk)) AS LkF
FROM
 ( SELECT 
    GoalsFor       AS GlF
   ,GoalsAgainst   AS GlA
   ,Won            AS Won
   ,Drawn          AS Drn
   ,Lost           AS Lst
   ,GamePoints     AS GPt
   ,GoalDifference AS GDf
   ,(@gn:=@gn+1)   AS GRk
   FROM
    HomeResults         RLT
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
   WHERE TeamID = ".$teamid."
   ORDER BY GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY Ven
UNION
SELECT
 '2A'      AS Ven
,SUM(Won) AS Won
,SUM(Drn) AS Drn
,SUM(Lst) AS Lst
,SUM(GlF) AS GlF
,SUM(GlA) AS GlA
,SUM(GDf) AS GDf
,SUM(GPt) AS Pts
,SUM(  (Won *  2 * (7-GRk))
     + (Lst * -2 * (7-GRk))
    )     AS Frm
,SUM(GlF * (7-GRk)) AS GPw
,SUM(GlA * (7-GRk)) AS LkF
FROM
 ( SELECT 
    GoalsFor       AS GlF
   ,GoalsAgainst   AS GlA
   ,Won            AS Won
   ,Drawn          AS Drn
   ,Lost           AS Lst
   ,GamePoints     AS GPt
   ,GoalDifference AS GDf
   ,(@gn:=@gn+1)   AS GRk
   FROM
    AwayResults         RLT
      CROSS JOIN
    (SELECT (@gn := 0)) GNo
   WHERE TeamID = ".$teamid."
   ORDER BY GameDate DESC
 ) OG
WHERE GRk <= 6
GROUP BY Ven
ORDER BY Ven
"
;

$tf = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>