<?php

print "<!-- GameID = ".$gameid." -->\n";
print "<!-- SeasonID = ".$season." -->\n";

$sql="
  UPDATE game
  SET
    GameDate='".$EGD_GDt."'
  ,CompetitionID=".$EGD_Cmp."
  ,Round='".$EGD_CRd."'
  ,ReplayInd='".$EGD_CRI."'
  ,OppositionID=".$EGD_Opp."
  ,GameMins=".$EGD_GMn."
  ,Venue='".$EGD_Ven."'
  ,KitID=".$EGD_Kit."
  ,FT_GF=".('-'==$EGD_FTF ? 'NULL' : $EGD_FTF)."
  ,FT_GA=".('-'==$EGD_FTA ? 'NULL' : $EGD_FTA)
;

if (90<$EGD_GMn) {
  $sql.="
    ,ET_GF=".('-'==$EGD_ETF||''==$EGD_ETF ? 'NULL' : $EGD_ETF)."
    ,ET_GA=".('-'==$EGD_ETA||''==$EGD_ETA ? 'NULL' : $EGD_ETA)."
    ,Pn_GF=".('-'==$EGD_PnF||''==$EGD_PnF ? 'NULL' : $EGD_PnF)."
    ,Pn_GA=".('-'==$EGD_PnA||''==$EGD_PnA ? 'NULL' : $EGD_PnA)
  ;
}

$sql.="
  WHERE SeasonID=".$season."
   AND GameID=".$gameid."
  "
;

$updgame=mysql_query ($sql);

if (mysql_error()) {
  show_sql_error($sql ,mysql_error(),__FILE__);
  $UpdOK=FALSE;
}
else {
  $UpdOK=TRUE;
}

if (''!=$EGD_GF01 OR ''!=$EGD_GA01) {

  $sql="
    DELETE FROM game_goals
    WHERE SeasonID=".$season."
      AND GameID=".$gameid
  ;
  
  $delgg=mysql_query ($sql);

  if (mysql_error()) {
    show_sql_error($sql ,mysql_error(),__FILE__);
    $UpdOK=FALSE;
  }
  
  $sql="
    INSERT INTO game_goals VALUES 
    (".$gameid."
    ,".$season."
    ,".(''==$EGD_GF01 ? 'NULL' : $EGD_GF01)."
    ,".(''==$EGD_GF02 ? 'NULL' : $EGD_GF02)."
    ,".(''==$EGD_GF03 ? 'NULL' : $EGD_GF03)."
    ,".(''==$EGD_GF04 ? 'NULL' : $EGD_GF04)."
    ,".(''==$EGD_GF05 ? 'NULL' : $EGD_GF05)."
    ,".(''==$EGD_GF06 ? 'NULL' : $EGD_GF06)."
    ,".(''==$EGD_GF07 ? 'NULL' : $EGD_GF07)."
    ,".(''==$EGD_GF08 ? 'NULL' : $EGD_GF08)."
    ,".(''==$EGD_GF09 ? 'NULL' : $EGD_GF09)."
    ,".(''==$EGD_GF10 ? 'NULL' : $EGD_GF10)."
    ,".(''==$EGD_GA01 ? 'NULL' : $EGD_GA01)."
    ,".(''==$EGD_GA02 ? 'NULL' : $EGD_GA02)."
    ,".(''==$EGD_GA03 ? 'NULL' : $EGD_GA03)."
    ,".(''==$EGD_GA04 ? 'NULL' : $EGD_GA04)."
    ,".(''==$EGD_GA05 ? 'NULL' : $EGD_GA05)."
    ,".(''==$EGD_GA06 ? 'NULL' : $EGD_GA06)."
    ,".(''==$EGD_GA07 ? 'NULL' : $EGD_GA07)."
    ,".(''==$EGD_GA08 ? 'NULL' : $EGD_GA08)."
    ,".(''==$EGD_GA09 ? 'NULL' : $EGD_GA09)."
    ,".(''==$EGD_GA10 ? 'NULL' : $EGD_GA10)."
    )"
  ;

  $insgg=mysql_query ($sql);

  if (mysql_error()) {
    show_sql_error($sql ,mysql_error(),__FILE__);
    $UpdOK=FALSE;
  }

}

?>