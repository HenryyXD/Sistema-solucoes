<?php
session_start();
ob_start();
    if(isset($_GET['mat']) && !isset($_GET['cod_alg'])){ 
        try{
            include_once "Aluno.class.php";
            $aluno = new Aluno;
            $aluno->excluirAluno($_GET['mat']);
            $_SESSION['sucesso'] = true;
            header('location: ../index.php?e=0#tabelaAlunos');
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            header('location: ../index.php?e=0#tabelaAlunos');
        }
    }else if(isset($_GET['cod_alg']) && !isset($_GET['cod_sol'])){
        try{
            include_once "Algoritmo.class.php";
            $algoritmo = new Algoritmo;
            $algoritmo->excluirAlgoritmo($_GET['cod_alg']);
            $_SESSION['sucesso'] = true;
            if(isset($_GET['mat'])){
                header('location: ../index.php?e='.$_GET['e'].'&mat='.$_GET['mat'].'#tabelaAlgoritmos');
            }else{
                header('location: ../index.php?e='.$_GET['e'].'#tabelaAlgoritmos');
            }
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            if(isset($_GET['mat'])){
                header('location: ../index.php?e='.$_GET['e'].'&mat='.$_GET['mat'].'#tabelaAlgoritmos');
            }else{
                header('location: ../index.php?e='.$_GET['e'].'#tabelaAlgoritmos');
            }
        }
    }else if(isset($_GET['cod_sol'])){
        try{
            include_once "Solucao.class.php";
            $solucao = new Solucao;
            $solucao->excluirSolucao($_GET['cod_sol']);
            $_SESSION['sucesso'] = true;
            header('location: ../index.php?e='.$_GET['e'].'&cod_alg='.$_GET['cod_alg'].'#tabelaSolucoes');
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            header('location: ../index.php?e='.$_GET['e'].'&cod_alg='.$_GET['cod_alg'].'#tabelaSolucoes');
        }
    }

ob_end_flush();
?>