<?php
session_start();
ob_start();
//error_reporting(0);
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="">
    <title>Algoritmos e Soluções</title>
    <link href="files/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="files/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="files/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.2"></script>
</head>

<body>
    <?php 
    
    if(isset($_SESSION['sucesso']) && $_SESSION['sucesso']){
        echo "<div class='alert alert-success alert-dismissible fade show col-sm-12 fixed-top text-center' role='alert'>
        <strong>Sucesso!</strong> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        </div>";
        unset($_SESSION['sucesso']);
    }else if(isset($_SESSION['sucesso']) && !$_SESSION['sucesso']){
        echo "<div class='alert alert-danger alert-dismissible fade show col-sm-12 fixed-top text-center' role='alert'>
        <strong>Ops! Algo deu errado, tente novamente.</strong> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        </div>";
        unset($_SESSION['sucesso']);
    } 

    if(isset($_GET['c'])){
        switch($_GET['c']){
            case 1:
                try{
                    include_once "includes/Aluno.class.php";
                    $aluno = new Aluno;
                    $aluno->cadastraAluno($_POST['nome'],$_POST['curso']);
                    $_SESSION['sucesso'] = true;
                    header('location:index.php?e=0');
                    
                }catch(PDOException $e){
                    $_SESSION['sucesso'] = false;
                    header('location:index.php?e=0');
                }
            break;
            case 2:
                try{
                    include_once "includes/Algoritmo.class.php";
                    $algoritmo = new Algoritmo;
                    $algoritmo->novoAlg($_POST['nomeAlg'],$_POST['linguagem'],$_GET['mat']);
                    $_SESSION['sucesso'] = true;
                    header('location: index.php?e=3&mat='.$_GET['mat']);
                }catch(PDOException $e){
                    $_SESSION['sucesso'] = false;
                    header('location: index.php?e=3&mat='.$_GET['mat']);
                }
            break;
            case 3:
                try{
                    include_once "includes/Solucao.class.php";
                    $solucao = new Solucao;
                    $solucao->novaSol($_POST['x'],$_POST['y'],$_GET['cod_alg']);
                    $_SESSION['sucesso'] = true;
                    header('location: index.php?e=4&cod_alg='.$_GET['cod_alg']);
                }catch(PDOException $e){
                    $_SESSION['sucesso'] = false;
                    header('location: index.php?e=4&cod_alg='.$_GET['cod_alg']);
                }
            break;
            default:
                $_SESSION['sucesso'] = false;
                header('location: index.php');
        }
    }
    ?>
    <div class="container-fluid h-100 w-100">
        <div class="row h-100">
            <div class="col-xl-3 col-lg-4 fundo" id="left">
                <div class="bg img-fluid mx-auto d-block mb-lg-5"></div>
                <div class="list-group list-group-flush mx-auto col-xl-9 col-md-10 col-sm-12 text-center">
                    <a class="list-group-item list-group-item-action rounded fundo <?php if($_GET['e'] == 0) {?>  active <?php } ?>" href="?e=0">Alunos</a>
                    <a class="list-group-item list-group-item-action rounded fundo <?php if($_GET['e'] == 1) {?>  active <?php } ?>" href="?e=1">Algoritmos</a>
                    <a class="list-group-item list-group-item-action rounded fundo <?php if($_GET['e'] == 2) {?>  active <?php } ?>" href="?e=2">Soluções</a>
                    <a class="list-group-item list-group-item-action rounded fundo btn disabled <?php if($_GET['e'] == 3) {?> active <?php }else{?>d-none<?php }?>" href="#">Algoritmos por Aluno</a>
                    <a class="list-group-item list-group-item-action rounded fundo btn disabled <?php if($_GET['e'] == 4) {?> active <?php }else{?>d-none<?php }?>" href="#">Soluções por Algoritmo</a>
                </div>
            </div> 
            <div class="col-xl-9 col-lg-8 offset-xl-3 offset-lg-4 fundo2">
                <?php 
                    if(!isset($_GET['e']) || $_GET['e'] == 0){
                        include_once "includes/tabelaAluno.php";
                        if(isset($_GET['mat'])) {
                            include_once "includes/formEdita.php";
                            $_SESSION['mostraForm'] = true;
                        }
                    }

                    if(isset($_GET['e']) && $_GET['e'] == 1) {
                        include_once "includes/tabelaAlgoritmos.php";
                        if(isset($_GET['cod_alg'])) {
                            include_once "includes/formEdita.php";
                            $_SESSION['mostraForm'] = true;
                        }
                    }

                    if(isset($_GET['e']) && $_GET['e'] == 2) {
                        include_once "includes/tabelaSolucoes.php";
                        if(isset($_GET['cod_sol'])) {
                            include_once "includes/formEdita.php";    
                            $_SESSION['mostraForm'] = true;
                        }
                    } 

                    if(isset($_GET['e']) && $_GET['e'] == 3) {
                        include_once "includes/algoritmoAluno.php";
                        if(isset($_GET['cod_alg'])) {
                            include_once "includes/formEdita.php";
                            $_SESSION['mostraForm'] = true;
                        }   
                    }

                    if(isset($_GET['e']) && $_GET['e'] == 4) {
                        include_once "includes/solucaoAlgoritmo.php";
                        if(isset($_GET['cod_sol'])) {
                            include_once "includes/formEdita.php";
                            $_SESSION['mostraForm'] = true;
                        }   
                    }
                ?>
                <footer class="my-5"></footer>  
            </div>
            
        </div>
        
    </div>
                  
    <script type="text/javascript" src="files/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="files/bootstrap.min.js"></script>
    <script type="text/javascript" src="files/popper.min.js"></script>
    <script type="text/javascript" src="files/bootstrap-table.min.js"></script>
    <script type="text/javascript" src="files/bootstrap-table-pt-BR.min.js"></script>
    <script type="text/javascript" src="files/script.js"></script>
    <script>
        $('.alert').alert()
    </script>
<?php
    if(isset($_SESSION['mostraForm']) && $_SESSION['mostraForm']) {
        echo "<script>$(document).ready(function() {";
        echo " window.location.hash = '#formEdita';";    
        echo "})</script>";
        $_SESSION['mostraForm'] = false;
    }
    ob_end_flush();
?>
</body>

</html>
