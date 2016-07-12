<?php
$sql = "SELECT
         GameID                                AS GID
        ,CASE WHEN gam.GameDate = '".($season + 1)."-06-01'
		      THEN 'n/a'
		      ELSE DATE_FORMAT(gam.GameDate ,'%a')
          END                                  AS GDy
        ,CASE WHEN gam.GameDate = '".($season + 1)."-06-01'
		      THEN 'TBC'
		      ELSE DATE_FORMAT(gam.GameDate ,'%d %b %y')
          END                                  AS GDt
        ,opp.ShortName AS Opp
        ,CASE WHEN gam.Round <> ''
              THEN CONCAT(cmp.ShortName 
                         ,'('
                         ,gam.Round
                         ,CASE WHEN gam.ReplayInd = 1 THEN ' R' ELSE '' END
                         ,')'
                         )
              ELSE cmp.ShortName
         END           AS Cmp
        ,gam.Venue     AS Ven
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
         END           AS Scr
       ,CASE WHEN (gam.FT_GF + COALESCE(gam.ET_GF ,0) +  COALESCE(gam.Pn_GF ,0))
                  > (gam.FT_GA + COALESCE(gam.ET_GA ,0) +  COALESCE(gam.Pn_GA ,0))
             THEN 'LimeGreen'
             WHEN (gam.FT_GF + COALESCE(gam.ET_GF ,0) +  COALESCE(gam.Pn_GF ,0))
                  < (gam.FT_GA + COALESCE(gam.ET_GA ,0) +  COALESCE(gam.Pn_GA ,0))
             THEN 'Red'
             WHEN (gam.FT_GF + COALESCE(gam.ET_GF ,0)) > 0
             THEN 'Yellow'
             ELSE 'Wheat'
       END             AS RsC
        FROM
         game        gam
           INNER JOIN
         opposition  opp
             ON  opp.OppositionID = gam.OppositionID
           INNER JOIN
         competition cmp
             ON  cmp.CompetitionID = gam.CompetitionID
        WHERE gam.SeasonID = ".$season."
        ORDER BY gam.GameDate ,opp.ShortName ,gam.Venue DESC
       "
;

$gmlist = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>