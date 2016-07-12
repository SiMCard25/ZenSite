<?php
$sql="
      SELECT
       gam.SeasonStart                       AS SSt
      ,gam.GameID                            AS GID
      ,gam.GameDate                          AS FGD
      ,DATE_FORMAT(gam.GameDate ,'%a')       AS GDy
      ,DATE_FORMAT(gam.GameDate ,'%d %b %y') AS GDt
      ,gam.Team1ID                           AS T1ID
      ,tm1.FullName                          AS T1FN
      ,tm1.ShortName                         AS T1SN
      ,tm1.Tag                               AS T1Tg
      ,gam.Team2ID                           AS T2ID
      ,tm2.FullName                          AS T2FN
      ,tm2.ShortName                         AS T2SN
      ,tm2.Tag                               AS T2Tg
      ,prd.Res                               AS Pred
      FROM
       game gam
         INNER JOIN
       team tm1
           ON  tm1.TeamID = gam.Team1ID
         INNER JOIN
       team tm2
           ON  tm2.TeamID = gam.Team2ID
         INNER JOIN
       prediction prd
           ON  prd.SSt = gam.SeasonStart
           AND prd.GID = gam.GameID           
      WHERE
          gam.CompetitionID =  ".$comp."
      AND gam.SeasonStart   =  ".$season."
      AND gam.GameDate      <= NOW()
      AND gam.Team1Goals    IS NULL
      ORDER BY FGD ,T1FN
     "
;

$result=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}


?>