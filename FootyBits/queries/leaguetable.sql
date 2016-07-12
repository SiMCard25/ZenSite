<?php

$sql = "
        SELECT
         DT1.TID             AS TID
        ,DT1.TFN             AS TFN
        ,DT1.TSN             AS TSN
        ,DT1.TTg             AS TTg
        ,DT1.HPld            AS HPld
        ,DT1.HWon            AS HWon
        ,DT1.HDrn            AS HDrn
        ,DT1.HLst            AS HLst
        ,DT1.HGF             AS HGF 
        ,DT1.HGA             AS HGA 
        ,DT1.HPts            AS HPts
        ,DT1.HDif            AS HDif
        ,DT1.APld            AS APld
        ,DT1.AWon            AS AWon
        ,DT1.ADrn            AS ADrn
        ,DT1.ALst            AS ALst
        ,DT1.AGF             AS AGF 
        ,DT1.AGA             AS AGA 
        ,DT1.APts            AS APts
        ,DT1.ADif            AS ADif
        ,DT1.TPld            AS TPld
        ,DT1.TWon            AS TWon
        ,DT1.TDrn            AS TDrn
        ,DT1.TLst            AS TLst
        ,DT1.TGF             AS TGF 
        ,DT1.TGA             AS TGA 
        ,DT1.TPts + DT1.PAdj AS TPts
        ,DT1.TDif            AS TDif
        ,@tp := @tp +1       AS TPos
        FROM
         ( SELECT
            GRs.TeamID                                                        AS TID
           ,tm1.FullName                                                      AS TFN
           ,tm1.ShortName                                                     AS TSN
           ,tm1.Tag                                                           AS TTg
           ,TSn.PointAdjustment                                               AS PAdj
           ,COUNT(*)                                                          AS TPld
           ,SUM(GRs.GRs.Won       )                                           AS TWon
           ,SUM(GRs.Drawn         )                                           AS TDrn
           ,SUM(GRs.Lost          )                                           AS TLst
           ,SUM(GRs.GoalsFor      )                                           AS TGF
           ,SUM(GRs.GoalsAgainst  )                                           AS TGA
           ,SUM(GRs.GamePoints    )                                           AS TPts
           ,SUM(GRs.GoalDifference)                                           AS TDif
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN 1                  ELSE 0 END) AS HPld
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.Won            ELSE 0 END) AS HWon
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.Drawn          ELSE 0 END) AS HDrn
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.Lost           ELSE 0 END) AS HLst
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.GoalsFor       ELSE 0 END) AS HGF
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.GoalsAgainst   ELSE 0 END) AS HGA
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.GamePoints     ELSE 0 END) AS HPts
           ,SUM(CASE WHEN GRs.Venue = 'H' THEN GRs.GoalDifference ELSE 0 END) AS HDif
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN 1                  ELSE 0 END) AS APld
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.Won            ELSE 0 END) AS AWon
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.Drawn          ELSE 0 END) AS ADrn
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.Lost           ELSE 0 END) AS ALst
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.GoalsFor       ELSE 0 END) AS AGF
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.GoalsAgainst   ELSE 0 END) AS AGA
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.GamePoints     ELSE 0 END) AS APts
           ,SUM(CASE WHEN GRs.Venue = 'A' THEN GRs.GoalDifference ELSE 0 END) AS ADif
           FROM
            GameResult  GRs
              INNER JOIN
            team_season TSn
                ON  TSn.SeasonStart = GRs.SeasonStart
                AND TSn.TeamID      = GRs.TeamID
               INNER JOIN
            team        tm1
                ON  tm1.TeamID = TSn.TeamID
           WHERE
                TSn.CompetitionID = ".$comp."
            AND GRs.SeasonStart   = ".$season."
           GROUP BY TID ,TFN ,TSN ,TTg, PAdj
        ) DT1
          CROSS JOIN
       ( SELECT (@tp := 0) ) TPs
      ORDER BY TPts DESC ,TDif DESC ,TGF DESC ,TFN
    "
;

$ltb = mysql_query ($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}

?>