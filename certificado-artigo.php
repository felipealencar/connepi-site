<?php

$papers  = simplexml_load_file("papers/1-50.xml");
$artigos = array();

foreach($papers->children() as $paper){

  if($paper->count() > 1){
    foreach($paper as $info) {
      if($info->getName() == "title"){
        $artigos[] = $info;
      }

      $nome = array();
      if($info->count() > 1){
        foreach($info as $subinfo){
          if($subinfo->getName() == "firstname" || $subinfo->getName() == "middlename" || $subinfo->getName() == "lastname"){
            $nome[] = $subinfo;
          }
        }
      }
      $artigos[] = implode(" ", $nome);
    }
  }

  echo var_dump($artigos[5]);
}
?>
