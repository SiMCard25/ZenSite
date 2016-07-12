<?php

/* Get the squad totals selected season*/
$sql="
        SELECT
         999                             AS PID
        ,SUM(CASE WHEN GameDate <= curdate() THEN 1 ELSE 0 END) AS FGm
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       > (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Won
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       = (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Drn
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       < (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Lst
        ,SUM(CASE WHEN GameDate < curdate() THEN GameMins ELSE 0 END) AS MPl
        ,SUM(FT_GF + COALESCE(ET_GF ,0)) AS PGl
        ,SUM(CASE WHEN FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0) = 0
                  THEN 1
                  ELSE 0
             END
            )                        AS CSh
        ,SUM(FT_GF + COALESCE(ET_GF ,0)) AS TGF
        ,SUM(FT_GA + COALESCE(ET_GA ,0)) AS TGA
        FROM game
        WHERE SeasonID=".$season."
        GROUP BY PID
"
;

$sqtot = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the squad totals since 2006*/
$sql="
        SELECT
         999                             AS PID
        ,SUM(CASE WHEN GameDate <= curdate() THEN 1 ELSE 0 END) AS FGm
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       > (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Won
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       = (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Drn
        ,SUM(CASE WHEN (FT_GF + COALESCE(ET_GF ,0) +  COALESCE(Pn_GF ,0))
                       < (FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0))
                  THEN 1
                  ELSE 0
             END
            )                        AS Lst
        ,SUM(CASE WHEN GameDate <= curdate() THEN GameMins ELSE 0 END) AS MPl
        ,SUM(FT_GF + COALESCE(ET_GF ,0)) AS PGl
        ,SUM(CASE WHEN FT_GA + COALESCE(ET_GA ,0) +  COALESCE(Pn_GA ,0) = 0
                  THEN 1
                  ELSE 0
             END
            )                        AS CSh
        ,SUM(FT_GF + COALESCE(ET_GF ,0)) AS TGF
        ,SUM(FT_GA + COALESCE(ET_GA ,0)) AS TGA
        FROM game
        GROUP BY PID
"
;

$sqAllTime = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the card totals selected season */
$sql = "
        SELECT
         SUM(YellowCards) AS YCd
        ,SUM(RedCards   ) AS RCd
        FROM player_game
        WHERE SeasonID=".$season."
      "
;

$cdtot = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the card totals since 2006 */
$sql = "
        SELECT
         SUM(YellowCards) AS YCd
        ,SUM(RedCards   ) AS RCd
        FROM player_game
      "
;

$cdAllTime = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* get the requested sort order string */
switch ($sortorder) {
  case 1:  $reqso="PSNm ,PFNm ";         /* Surname, Forename              */
           break;
  case 2:  $reqso="SNo ,PID ";           /* MCSP - for now same as default */
           break;
  case 3:  $reqso="FGm DESC ,SGm DESC "; /* Games played                   */
           break;
  case 4:  $reqso="MPl DESC ";           /* Minutes played                 */
           break;
  case 5:  $reqso="Won DESC ";           /* Games Won                      */
           break;
  case 6:  $reqso="Drn DESC ";           /* Games Drawn                    */
           break;
  case 7:  $reqso="Lst DESC ";           /* Games Lost                     */
           break;
  case 8:  $reqso="PGl DESC ";           /* Goals scored by player         */
           break;
  case 9:  $reqso="TGF DESC ";           /* Team Goals Scored              */
           break;
  case 10: $reqso="TGA DESC ";           /* Team Goals Conceded            */
           break;
  case 11: $reqso="CSh DESC ";           /* Clean Sheets                   */
           break;
  case 12: $reqso="YCd DESC ";           /* Yellow Cards                   */
           break;
  case 13: $reqso="RCd DESC ";           /* Red Cards                      */
           break;
  case 14: $reqso="PPt DESC ";           /* Player Points                  */
           break;
  default: $reqso="SNo ,PID  ";          /* default to Squad Number        */
           break;
}

/* Get the player totals for selected season */
$sql="
     SELECT
      PGD.PID                                 AS PID
     ,psq.SquadNumber                         AS SNo
     ,plr.FirstName                           AS PFNm
     ,plr.Surname                             AS PSNm
     ,CONCAT(plr.FirstName ,' ' ,plr.Surname) AS PNm
     ,SUM(PGD.FGm)                            AS FGm
     ,SUM(PGD.SGm)                            AS SGm
     ,SUM(PGD.Won)                            AS Won
     ,SUM(PGD.Drn)                            AS Drn
     ,SUM(PGD.Lst)                            AS Lst
     ,SUM(PGD.MPl)                            AS MPl
     ,SUM(PGD.PGl)                            AS PGl
     ,SUM(PGD.CSh)                            AS CSh
     ,SUM(PGD.YCd)                            AS YCd
     ,SUM(PGD.RCd)                            AS RCd
     ,SUM(PGD.TGF)                            AS TGF
     ,SUM(PGD.TGA)                            AS TGA
     ,SUM(  PGD.Min_Pts
          + PGD.Gl_Pts
          + PGD.GF_Pts
          + PGD.GA_Pts
          + PGD.CS_Pts
          + PGD.Res_Pts
          + PGD.YCPts
          + PGD.RCPts
         )                                    AS PPt
     FROM
      Player_Game_Detail PGD
        INNER JOIN
      player       plr
          ON  plr.PlayerID = PGD.PID
        INNER JOIN
      player_squad psq
          ON  psq.PlayerID = PGD.PID
          AND psq.SeasonID = PGD.SID
    WHERE PGD.SID=".$season."
    GROUP BY SNo ,PID ,PNm
    ORDER BY ".$reqso." ,SNo ,PID
"
;

$pltot = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

/* Get the player totals since 2006 */
switch ($sortorder) {
  case 1:  $reqso="PSNm ,PFNm ";         /* Surname, Forename              */
           break;
  case 2:  $reqso="PSNm ,PFNm ";         /* MCSP - for now same as default */
           break;
  case 3:  $reqso="FGm DESC ,SGm DESC "; /* Games played                   */
           break;
  case 4:  $reqso="MPl DESC ";           /* Minutes played                 */
           break;
  case 5:  $reqso="Won DESC ";           /* Games Won                      */
           break;
  case 6:  $reqso="Drn DESC ";           /* Games Drawn                    */
           break;
  case 7:  $reqso="Lst DESC ";           /* Games Lost                     */
           break;
  case 8:  $reqso="PGl DESC ";           /* Goals scored by player         */
           break;
  case 9:  $reqso="TGF DESC ";           /* Team Goals Scored              */
           break;
  case 10: $reqso="TGA DESC ";           /* Team Goals Conceded            */
           break;
  case 11: $reqso="CSh DESC ";           /* Clean Sheets                   */
           break;
  case 12: $reqso="YCd DESC ";           /* Yellow Cards                   */
           break;
  case 13: $reqso="RCd DESC ";           /* Red Cards                      */
           break;
  case 14: $reqso="PPt DESC ";           /* Player Points                  */
           break;
  default: $reqso="PSNm ,PFNm ";        /* default to Name                 */
           break;
}

$sql="
     SELECT
      PGD.PID                                 AS PID
     ,plr.FirstName                           AS PFNm
     ,plr.Surname                             AS PSNm
     ,CONCAT(plr.FirstName ,' ' ,plr.Surname) AS PNm
     ,SUM(PGD.FGm)                            AS FGm
     ,SUM(PGD.SGm)                            AS SGm
     ,SUM(PGD.Won)                            AS Won
     ,SUM(PGD.Drn)                            AS Drn
     ,SUM(PGD.Lst)                            AS Lst
     ,SUM(PGD.MPl)                            AS MPl
     ,SUM(PGD.PGl)                            AS PGl
     ,SUM(PGD.CSh)                            AS CSh
     ,SUM(PGD.YCd)                            AS YCd
     ,SUM(PGD.RCd)                            AS RCd
     ,SUM(PGD.TGF)                            AS TGF
     ,SUM(PGD.TGA)                            AS TGA
     ,SUM(  PGD.Min_Pts
          + PGD.Gl_Pts
          + PGD.GF_Pts
          + PGD.GA_Pts
          + PGD.CS_Pts
          + PGD.Res_Pts
          + PGD.YCPts
          + PGD.RCPts
         )                                    AS PPt
     ,MAX(PGD.SID)                            AS MSID
     FROM
      Player_Game_Detail PGD
        INNER JOIN
      player       plr
          ON  plr.PlayerID = PGD.PID
        INNER JOIN
      player_squad psq
          ON  psq.PlayerID = PGD.PID
          AND psq.SeasonID = PGD.SID
	WHERE (FGm + SGm) > 0
    GROUP BY PID ,PNm
    ORDER BY ".$reqso." ,PSNm ,PFNm
"
;

$plAllTime = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>