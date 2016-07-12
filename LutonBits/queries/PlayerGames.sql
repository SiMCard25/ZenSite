<?php
$sql="
      SELECT
       PGD.PID                               AS PID
      ,PGD.GID                               AS GID
      ,DATE_FORMAT(gam.GameDate ,'%a')       AS GDy
      ,DATE_FORMAT(gam.GameDate ,'%d %b %y') AS GDt
      ,gam.GameMins                          AS GmL
      ,opp.ShortName                         AS Opp
      ,CASE WHEN gam.Round <> ''
              THEN CONCAT(cmp.Tag 
                         ,'('
                         ,gam.Round
                         ,CASE WHEN gam.ReplayInd = 1 THEN ' R' ELSE '' END
                         ,')'
                         )
              ELSE cmp.Tag
         END                                 AS Cmp
      ,gam.Venue                             AS Ven
      ,CASE WHEN gam.GameDate > curdate()
            THEN '-'
            WHEN gam.Pn_GF IS NOT NULL
            THEN ( CASE WHEN gam.Pn_GF > gam.Pn_GA
                                    THEN CONCAT('p',gam.FT_GF+gam.ET_GF,'e',gam.FT_GA+gam.ET_GA)
                                     ELSE CONCAT(gam.FT_GF+gam.ET_GF,'e',gam.FT_GA+gam.ET_GA,'p')
                         END
                      )
           WHEN gam.GameMins > 90
           THEN CONCAT(gam.FT_GF+gam.ET_GF,'e',gam.FT_GA+gam.ET_GA)
           ELSE CONCAT(gam.FT_GF,'-',gam.FT_GA)
       END                                   AS Scr
      ,CASE WHEN PGD.Won = 1 THEN 'LimeGreen'
            WHEN PGD.Lst = 1 THEN 'Red'
            WHEN PGD.TGF > 0 THEN 'Yellow'
            ELSE 'Wheat'
       END                                   AS RsC
      ,pos.Tag                               AS SPn
      ,PGD.MPl                               AS MPl
      ,PGD.PGl                               AS PGl
      ,PGD.YCd                               AS YCd
      ,PGD.RCd                               AS RCd
      ,PGD.TGF                               AS TGF
      ,PGD.TGA                               AS TGA
      ,PGD.Min_Pts + PGD.Gl_Pts + PGD.GF_Pts + PGD.GA_Pts + PGD.CS_Pts + PGD.Res_Pts + PGD.YCPts + PGD.RCPts
                                             AS PPt
      FROM
       Player_Game_Detail PGD
         INNER JOIN
       player_game        pgm
           ON  pgm.GameID   = PGD.GID
           AND pgm.SeasonID = PGD.SID
           AND pgm.PlayerID = PGD.PID
         INNER JOIN
       game        gam
           ON  gam.GameID   = PGD.GID
           AND gam.SeasonID = PGD.SID
         INNER JOIN
       position    pos
           ON  pos.PositionID= pgm.PositionID
         LEFT JOIN
       game_goals  ggl
           ON  ggl.GameID   = PGD.GID
           AND ggl.SeasonID = PGD.SID
         INNER JOIN
       opposition  opp
           ON  opp.OppositionID= gam.OppositionID
         INNER JOIN
       competition cmp
           ON  cmp.CompetitionID= gam.CompetitionID
      WHERE
          PGD.PID = ".$playerid."
      AND PGD.SID = ".$season."
     ORDER BY gam.GameDate
"
;

$plgam = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>