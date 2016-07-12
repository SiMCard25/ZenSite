<?php
/* Get this season's basic player details */
$sql="
      SELECT
       psq.SquadNumber                             AS SNo
      ,CONCAT(plr.FirstName ,' ' ,plr.Surname)     AS PNm
      ,CONCAT(psq.SquadNumber ,plr.Surname,'.jpg') AS PID
      FROM
       player       plr
         INNER JOIN
       player_squad psq
           ON  psq.PlayerID = plr.PlayerID
      WHERE
          plr.PlayerID = ".$playerid."
      AND psq.SeasonID = ".$season."
     "
;
    
$pldet = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Now get this season's player totals by competition */
$sql="
    SELECT
     CID 
    ,CSN
    ,SUM(FGm) AS FGm
    ,SUM(SGm) AS SGm
    ,SUM(Won) AS Won
    ,SUM(Drn) AS Drn
    ,SUM(Lst) AS Lst
    ,SUM(MPl) AS MPl
    ,SUM(PGl) AS PGl
    ,SUM(CSh) AS CSh
    ,SUM(YCd) AS YCd
    ,SUM(RCD) AS RCd
    ,SUM(TGF) AS TGF
    ,SUM(TGA) AS TGA
    ,SUM(  Min_Pts 
         + Gl_Pts
         + GF_Pts
         + GA_Pts
         + CS_Pts
         + Res_Pts
         + YCPts
         + RCPts
        )     AS PPt
    FROM Player_Game_Detail
    WHERE
        PID = ".$playerid."
    AND SID = ".$season."
    GROUP BY CID ,CSN
    ORDER BY CID
"
;

$pltot = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the full list of basic player details */
$sql="
      SELECT
       psq.SquadNumber                             AS SNo
      ,CONCAT(plr.FirstName ,' ' ,plr.Surname)     AS PNm
      ,CONCAT(psq.SquadNumber ,plr.Surname,'.jpg') AS PID
      FROM
       player       plr
         INNER JOIN
       player_squad psq
           ON  psq.PlayerID = plr.PlayerID
      WHERE
          plr.PlayerID = ".$playerid."
     "
;
    
$plAll = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Now get the player all time totals by competition */
$sql="
    SELECT
     CID 
    ,CSN
    ,SUM(FGm) AS FGm
    ,SUM(SGm) AS SGm
    ,SUM(Won) AS Won
    ,SUM(Drn) AS Drn
    ,SUM(Lst) AS Lst
    ,SUM(MPl) AS MPl
    ,SUM(PGl) AS PGl
    ,SUM(CSh) AS CSh
    ,SUM(YCd) AS YCd
    ,SUM(RCD) AS RCd
    ,SUM(TGF) AS TGF
    ,SUM(TGA) AS TGA
    ,SUM(  Min_Pts 
         + Gl_Pts
         + GF_Pts
         + GA_Pts
         + CS_Pts
         + Res_Pts
         + YCPts
         + RCPts
        )     AS PPt
    FROM Player_Game_Detail
    WHERE
        PID = ".$playerid."
    GROUP BY CID ,CSN
    ORDER BY CID
"
;

$plAllTime = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>