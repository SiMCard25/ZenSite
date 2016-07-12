<?php
/* Get the basic game details */
$sql="
      SELECT
       gam.GameID                            AS GID
      ,gam.GameDate                          AS UGD
      ,DATE_FORMAT(gam.GameDate ,'%W')       AS GDy
      ,DATE_FORMAT(gam.GameDate ,'%D %M %Y') AS GDt
      ,DATE_FORMAT(gam.GameDate ,'%Y%m%d')   AS GDC
      ,gam.GameMins                          AS GMn
      ,gam.KitID                                   AS KID
      ,CASE gam.KitID
            WHEN  0 THEN 'KitWW.gif'
            WHEN  1 THEN 'KitWB.gif'
            WHEN  2 THEN 'KitWO.gif'
            WHEN  3 THEN 'KitBW.gif'
            WHEN  4 THEN 'KitBB.gif'
            WHEN  5 THEN 'KitBB.gif'
            WHEN  6 THEN 'KitOW.gif'
            WHEN  7 THEN 'KitOB.gif'
            WHEN  8 THEN 'KitOO.gif'
            WHEN  9 THEN 'KitBW.gif'
            WHEN 10 THEN 'KitBO.gif'
            WHEN 11 THEN 'KitBP.gif'
        END                                      AS KitPic
      ,opp.OppositionID                    AS OID
      ,opp.FullName                          AS Opp
      ,CONCAT(REPLACE(opp.FullName ,' ' ,''),'.gif') AS PIC
      ,CASE WHEN gam.Round <> ''
            THEN CONCAT(cmp.FullName
                       ,' (Round '
                       ,gam.Round
                       ,CASE WHEN gam.ReplayInd = 1 THEN ' Replay' ELSE '' END
                       ,')'
                       )
            ELSE cmp.FullName
       END                                   AS Cmp
      ,cmp.CompetitionID            AS CID
      ,cmp.FullName                   AS CFN
      ,gam.Round                       AS CRd
      ,gam.ReplayInd                  AS CRI
      ,gam.Venue                       AS Ven
      ,CASE WHEN gam.FT_GF IS NULL
            THEN '-'
            ELSE CONCAT(gam.FT_GF,' - ',gam.FT_GA)
       END                                   AS FT_Scr
      ,CASE WHEN gam.ET_GF IS NULL
            THEN ''
            ELSE CONCAT(gam.ET_GF,' - ',gam.ET_GA)
       END                                   AS ET_Scr
      ,CASE WHEN gam.Pn_GF IS NULL
            THEN ''
            ELSE CONCAT(gam.Pn_GF,' - ',gam.Pn_GA)
       END                                   AS Pn_Scr
      ,CASE WHEN gam.FT_GF IS NULL THEN '-' ELSE gam.FT_GF END AS FT_GF
      ,CASE WHEN gam.FT_GA IS NULL THEN '-' ELSE gam.FT_GA END AS FT_GA
      ,CASE WHEN gam.ET_GF IS NULL THEN '-' ELSE gam.ET_GF END AS ET_GF
      ,CASE WHEN gam.ET_GA IS NULL THEN '-' ELSE gam.ET_GA END AS ET_GA
      ,CASE WHEN gam.Pn_GF IS NULL THEN '-' ELSE gam.Pn_GF END AS Pn_GF
      ,CASE WHEN gam.Pn_GA IS NULL THEN '-' ELSE gam.Pn_GA END AS Pn_GA
      ,CASE WHEN ggl.GF01  IS NULL THEN '' ELSE  ggl.GF01  END AS GF01
      ,CASE WHEN ggl.GF02  IS NULL THEN '' ELSE  ggl.GF02  END AS GF02
      ,CASE WHEN ggl.GF03  IS NULL THEN '' ELSE  ggl.GF03  END AS GF03
      ,CASE WHEN ggl.GF04  IS NULL THEN '' ELSE  ggl.GF04  END AS GF04
      ,CASE WHEN ggl.GF05  IS NULL THEN '' ELSE  ggl.GF05  END AS GF05
      ,CASE WHEN ggl.GF06  IS NULL THEN '' ELSE  ggl.GF06  END AS GF06
      ,CASE WHEN ggl.GF07  IS NULL THEN '' ELSE  ggl.GF07  END AS GF07
      ,CASE WHEN ggl.GF08  IS NULL THEN '' ELSE  ggl.GF08  END AS GF08
      ,CASE WHEN ggl.GF09  IS NULL THEN '' ELSE  ggl.GF09  END AS GF09
      ,CASE WHEN ggl.GF10  IS NULL THEN '' ELSE  ggl.GF10  END AS GF10
      ,CASE WHEN ggl.GA01  IS NULL THEN '' ELSE  ggl.GA01  END AS GA01
      ,CASE WHEN ggl.GA02  IS NULL THEN '' ELSE  ggl.GA02  END AS GA02
      ,CASE WHEN ggl.GA03  IS NULL THEN '' ELSE  ggl.GA03  END AS GA03
      ,CASE WHEN ggl.GA04  IS NULL THEN '' ELSE  ggl.GA04  END AS GA04
      ,CASE WHEN ggl.GA05  IS NULL THEN '' ELSE  ggl.GA05  END AS GA05
      ,CASE WHEN ggl.GA06  IS NULL THEN '' ELSE  ggl.GA06  END AS GA06
      ,CASE WHEN ggl.GA07  IS NULL THEN '' ELSE  ggl.GA07  END AS GA07
      ,CASE WHEN ggl.GA08  IS NULL THEN '' ELSE  ggl.GA08  END AS GA08
      ,CASE WHEN ggl.GA09  IS NULL THEN '' ELSE  ggl.GA09  END AS GA09
      ,CASE WHEN ggl.GA10  IS NULL THEN '' ELSE  ggl.GA10  END AS GA10
      FROM
       game        gam
         INNER JOIN
       opposition  opp
           ON  opp.OppositionID = gam.OppositionID
         INNER JOIN
       competition cmp
           ON  cmp.CompetitionID = gam.CompetitionID
         LEFT JOIN
       game_goals  ggl
           ON  ggl.GameID   = gam.GameID
           AND ggl.SeasonID = gam.SeasonID
      WHERE gam.GameID   = ".$gameid."
        AND gam.SeasonID = ".$season."
    "
;
    
$gmdet = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Now get the player game details */
$sql="
      SELECT
       pos.PositionID                          AS PID
      ,pos.PositionType                        AS PTp
      ,pos.Tag                                 AS PTg
      ,plr.PlayerID                            AS PlID
      ,psq.SquadNumber                         AS SNo
      ,CONCAT(plr.FirstName ,' ' ,plr.Surname) AS PNm
      ,gam.GameMins                            AS GMn
      ,pgm.OnMin                               AS OnM
      ,pgm.OffMin                              AS OfM
      ,PGD.MPl                                 AS PMn 
      ,PGD.PGl                                 AS PGl
      ,PGD.YCd                                 AS YCd
      ,PGD.RCd                                 AS RCd
      ,PGD.Min_Pts + PGD.Gl_Pts + PGD.GF_Pts + PGD.GA_Pts + PGD.CS_Pts + PGD.Res_Pts + PGD.YCPts + PGD.RCPts AS PPt
      ,CASE WHEN pos.PositionID =  1 THEN 'GK'
            WHEN pos.PositionID <  6 THEN 'DF'
            WHEN pos.PositionID < 15 THEN 'MF'
            WHEN pos.PositionID < 20 THEN 'FW'
            ELSE ( CASE WHEN pgm.OnMin > 0 THEN 'PS'
                        ELSE 'NS'
                   END
                 )
       END AS PClass
      ,CASE WHEN pos.PositionID =  1 THEN 'LightGreen'
            WHEN pos.PositionID <  6 THEN 'GoldenRod'
            WHEN pos.PositionID < 15 THEN 'SandyBrown'
            WHEN pos.PositionID < 20 THEN 'Tan'
            ELSE ( CASE WHEN pgm.OnMin > 0 THEN 'Gainsboro'
                        ELSE 'Silver'
                   END
                 )
       END AS BGCol
      FROM
       game         gam
         INNER JOIN
       player_game  pgm
           ON  pgm.GameID   = gam.GameID
           AND pgm.SeasonID = gam.SeasonID
         INNER JOIN
       player       plr
           ON  plr.PlayerID = pgm.PlayerID
         INNER JOIN
       player_squad psq
           ON  psq.PlayerID = pgm.PlayerID
           AND psq.SeasonID = gam.SeasonID
         INNER JOIN
       position     pos
           ON  pos.PositionID = pgm.PositionID
         INNER JOIN
       Player_Game_Detail PGD
           ON  PGD.PID = pgm.PlayerID
           AND PGD.SID = gam.SeasonID
           AND PGD.GID = gam.GameID
      WHERE gam.GameID   = ".$gameid."
        AND gam.SeasonID = ".$season."
     ORDER BY PID ,SNo
"
;

$plgam = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get position counts */
$sql="
      SELECT
       pos.PositionType AS PTp
      ,COUNT(*)         AS PCt
      FROM
       player_game pgm
        INNER JOIN
       position    pos
          ON  pos.PositionID = pgm.PositionID
      WHERE pgm.GameID   = ".$gameid."
        AND pgm.SeasonID = ".$season."
      GROUP BY PTp
      ORDER BY PCt DESC ,pos.PositionID
     "
;
        
$posct = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Now get just the positional details (not subs) */
$sql="
      SELECT
       pos.PositionID                          AS PID
      ,pos.PositionType                        AS PTp
      ,plr.PlayerID                            AS PlID
      ,CONCAT(psq.SquadNumber ,plr.Surname,'.jpg') AS PicID
      ,psq.SquadNumber                         AS SNo
      ,plr.Surname                             AS PSn
      ,gam.GameMins                            AS GMn
      ,pgm.OffMin                              AS OfM
      ,pgm.YellowCards                         AS YCd
      ,pgm.RedCards                            AS RCd
      FROM
       game        gam
         INNER JOIN
       player_game pgm
           ON  pgm.GameID = gam.GameID
           AND pgm.SeasonID = gam.SeasonID
         INNER JOIN
       player      plr
           ON  plr.PlayerID = pgm.PlayerID
         INNER JOIN
       player_squad psq
           ON  psq.PlayerID = pgm.PlayerID
           AND psq.SeasonID = gam.SeasonID
         INNER JOIN
       position    pos
           ON  pos.PositionID = pgm.PositionID
      WHERE gam.GameID     = ".$gameid."
        AND gam.SeasonID   = ".$season."
        AND pos.PositionID <> 20
     ORDER BY PID ,SNo
"
;

$posdet = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Now get just the positional details (subs only) */
$sql="
      SELECT
       psq.SquadNumber AS SNo
      ,plr.Surname     AS PSn
      ,plr.PlayerID    AS PlID
      ,CONCAT(psq.SquadNumber ,plr.Surname,'.jpg') AS PicID
      ,CASE WHEN pgm.OnMin IS NULL THEN 0 ELSE pgm.OnMin END       AS OnM
      ,pgm.YellowCards                         AS YCd
      ,pgm.RedCards                            AS RCd
      FROM
       game        gam
         INNER JOIN
       player_game pgm
           ON  pgm.GameID = gam.GameID
           AND pgm.SeasonID = gam.SeasonID
         INNER JOIN
       player      plr
           ON  plr.PlayerID = pgm.PlayerID
         INNER JOIN
       player_squad psq
           ON  psq.PlayerID = pgm.PlayerID
           AND psq.SeasonID = gam.SeasonID
      WHERE gam.GameID     = ".$gameid."
        AND gam.SeasonID   = ".$season."
        AND pgm.PositionID =  20
     ORDER BY SNo
"
;

$subdet = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* The next few queries are only used if editing is enabled */
if ($_SESSION['LTFCPW'] AND 1==$_SESSION['LTFCPW']) {

  /* Player List */
  $sql="
        SELECT
         plr.PlayerID                 AS PID
        ,psq.SquadNumber              AS SqN
        ,CONCAT(plr.FirstName ,' ' ,plr.Surname) AS PFN
        ,CASE WHEN pgm.PositionID  IS NULL THEN   0 ELSE pgm.PositionID  END AS PosID
        ,CASE WHEN pgm.OnMin       IS NULL THEN   0 ELSE pgm.OnMin       END AS OnMin
        ,CASE WHEN pgm.OffMin      IS NULL THEN   0 ELSE pgm.OffMin      END AS OffMin
        ,CASE WHEN pgm.Goals       IS NULL THEN   0 ELSE pgm.Goals       END AS Goals
        ,CASE WHEN pgm.YellowCards IS NULL THEN   0 ELSE pgm.YellowCards END AS YCard
        ,CASE WHEN pgm.RedCards    IS NULL THEN   0 ELSE pgm.RedCards    END AS RCard
        ,CASE WHEN pgm.PositionID  IS NULL THEN 100 ELSE pgm.PositionID  END AS Disp_Order
        FROM
          player              plr
            INNER JOIN
          player_squad psq
              ON  psq.PlayerID = plr.PlayerID
            LEFT JOIN
          player_game pgm
              ON  pgm.PlayerID = plr.PlayerID
              AND pgm.SeasonID = psq.SeasonID
              AND pgm.GameID = ".$gameid."
        WHERE psq.SeasonID   = ".$season."
       ORDER BY Disp_Order ,SqN ,PID
  "
  ;

  $plrlist = mysql_query ($sql);

  if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

  /* Kit List */

  $sql="
        SELECT
         KitID AS KID
        ,CONCAT(ShirtColour ,'-' ,ShortsColour) AS KFN
        ,CASE KitID
            WHEN  0 THEN 'KitWW.gif'
            WHEN  1 THEN 'KitWB.gif'
            WHEN  2 THEN 'KitWO.gif'
            WHEN  3 THEN 'KitBW.gif'
            WHEN  4 THEN 'KitBB.gif'
            WHEN  5 THEN 'KitBB.gif'
            WHEN  6 THEN 'KitOW.gif'
            WHEN  7 THEN 'KitOB.gif'
            WHEN  8 THEN 'KitOO.gif'
            WHEN  9 THEN 'KitBW.gif'
            WHEN 10 THEN 'KitBO.gif'
            WHEN 11 THEN 'KitBP.gif'
        END AS KitPic
        FROM kit
        WHERE ".$season." BETWEEN SeasonStart AND SeasonEnd
        ORDER BY KID
    "
  ;
    
  $kitlist = mysql_query ($sql);

  if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

  /* Opposition List */

  $sql="
        SELECT
         OppositionID AS OID
        ,FullName       AS OFN
        FROM opposition
        ORDER BY OFN
    "
  ;
    
  $opplist = mysql_query ($sql);

  if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

  /* Competition List */
  $sql="
        SELECT
         CompetitionID AS CID
        ,FullName        AS CFN
      FROM competition
      ORDER BY CID
    "
  ;

  $cmplist = mysql_query ($sql);

  if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

  /* Position List */
  $sql="
      SELECT
       PositionID      AS PID
      ,PositionType AS PTp
      ,FullName       AS PFN
      FROM position
      ORDER BY PID
    "
  ;

  $poslist = mysql_query ($sql);

  if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

}

?>