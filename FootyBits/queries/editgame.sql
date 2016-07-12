<?php
$sql="
      SELECT
       gam.GameID                            AS GID
      ,gam.CompetitionID                     AS CID
      ,cmp.FullName                          AS CFN
      ,gam.SeasonStart                       AS SSn
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
      ,CASE WHEN gam.Team1Goals IS NULL THEN '' ELSE gam.Team1Goals END AS T1Gl
      ,CASE WHEN gam.Team2Goals IS NULL THEN '' ELSE gam.Team2Goals END AS T2Gl
      FROM
       game        gam
         INNER JOIN
       competition cmp
           ON  cmp.CompetitionID = gam.CompetitionID
         INNER JOIN
       team        tm1
           ON  tm1.TeamID = gam.Team1ID
         INNER JOIN
       team        tm2
           ON  tm2.TeamID = gam.Team2ID
      WHERE
          gam.GameID      =  ".$gameid."
      AND gam.SeasonStart =  ".$season."
     "
;

$ge=mysql_query($sql);

if (mysql_error()) { show_sql_error($sql ,mysql_error(),__FILE__);}


?>