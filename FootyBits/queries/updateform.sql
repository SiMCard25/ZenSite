<?php

$sql = "DELETE FROM current_form";

$if = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

$sql = "
INSERT INTO current_form
SELECT
 HF.TID AS TID
,HF.Frm AS HFrm
,HF.GPw AS HGPw
,HF.LkF AS HLkF
,AF.Frm AS AFrm
,AF.GPw AS AGPw
,AF.LkF AS ALkF
,OF.Frm AS OFrm
,OF.GPw AS OGPw
,OF.LkF AS OLkF
FROM
 ( SELECT
    TID      AS TID
   ,SUM(  (Won *  2 * (7-GRk))
        + (Lst * -2 * (7-GRk))
       )     AS Frm
   ,SUM(GlF * (7-GRk)) AS GPw
   ,SUM(GlA * (7-GRk)) AS LkF
   FROM
    ( SELECT 
       TeamID         AS TID
      ,GoalsFor       AS GlF
      ,GoalsAgainst   AS GlA
      ,Won            AS Won
      ,Drawn          AS Drn
      ,Lost           AS Lst
      ,IF (@ti=TeamID 
          ,@gn:=@gn+1
          ,@gn:=1+least(0 ,@ti:=TeamID)
          )           AS GRk
      FROM
       HomeResults         RLT
         CROSS JOIN
       (SELECT (@gn := 0)) GNo
         CROSS JOIN
       (SELECT (@ti := 0)) Tms
      ORDER BY TeamID ,GameDate DESC
    ) HG
   WHERE GRk <= 6
   GROUP BY TID
 ) HF
   INNER JOIN
 ( SELECT
    TID      AS TID
   ,SUM(  (Won *  2 * (7-GRk))
        + (Lst * -2 * (7-GRk))
       )     AS Frm
   ,SUM(GlF * (7-GRk)) AS GPw
   ,SUM(GlA * (7-GRk)) AS LkF
   FROM
    ( SELECT 
       TeamID         AS TID
      ,GoalsFor       AS GlF
      ,GoalsAgainst   AS GlA
      ,Won            AS Won
      ,Drawn          AS Drn
      ,Lost           AS Lst
      ,IF (@ti=TeamID 
          ,@gn:=@gn+1
          ,@gn:=1+least(0 ,@ti:=TeamID)
          )           AS GRk
      FROM
       AwayResults         RLT
         CROSS JOIN
       (SELECT (@gn := 0)) GNo
         CROSS JOIN
       (SELECT (@ti := 0)) Tms
      ORDER BY TeamID ,GameDate DESC
    ) AG
   WHERE GRk <= 6
   GROUP BY TID
 ) AF
     ON  AF.TID = HF.TID
   INNER JOIN
 ( SELECT
    TID      AS TID
   ,SUM(  (Won *  2 * (7-GRk))
        + (Lst * -2 * (7-GRk))
       )     AS Frm
   ,SUM(GlF * (7-GRk)) AS GPw
   ,SUM(GlA * (7-GRk)) AS LkF
   FROM
    ( SELECT 
       TeamID         AS TID
      ,GoalsFor       AS GlF
      ,GoalsAgainst   AS GlA
      ,Won            AS Won
      ,Drawn          AS Drn
      ,Lost           AS Lst
      ,IF (@ti=TeamID 
          ,@gn:=@gn+1
          ,@gn:=1+least(0 ,@ti:=TeamID)
          )           AS GRk
      FROM
       GameResult          RLT
         CROSS JOIN
       (SELECT (@gn := 0)) GNo
         CROSS JOIN
       (SELECT (@ti := 0)) Tms
      ORDER BY TeamID ,GameDate DESC
    ) OG
   WHERE GRk <= 6
   GROUP BY TID
 ) OF
     ON  OF.TID = HF.TID
"
;

$if = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>