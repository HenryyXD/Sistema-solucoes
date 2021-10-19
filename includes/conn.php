<?php
  function conn(){
    $con = new PDO('mysql:host=localhost;dbname=id11753124_solucoes;charset=utf8','id11753124_henrique','henriquebd');
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $con;
  }
?>