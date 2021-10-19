<?php
session_start();
    if($_GET['e'] == 0){
        try{
            include_once "Aluno.class.php";
            $aluno = new Aluno;
            $aluno->editaAluno($_POST['nome'],$_POST['curso'],$_POST['matricula']);
            $_SESSION['sucesso'] = true;
            header('location: ../index.php?e=0#tabelaAlunos');
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            header('location: ../index.php?e=0#tabelaAlunos');
        }
    }else if($_GET['e'] == 1 || $_GET['e'] == 3){
        try{
            include_once "Algoritmo.class.php";
            include_once "Aluno.class.php";
            $aluno = new Aluno;
            $algoritmo = new Algoritmo;
            if(!in_array($_POST['fk_mat'],$aluno->matriculas())){
                throw new PDOException();
            }else{
                $algoritmo->editaAlgoritmo($_POST['nomeAlg'],$_POST['linguagem'],$_POST['fk_mat'],$_POST['cod_alg']);
                $_SESSION['sucesso'] = true;
                header('location: ../index.php?e='.$_GET['e'].'&mat='.$_GET['mat'].'#tabelaAlgoritmos'); 
            }
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            header('location: ../index.php?e='.$_GET['e'].'&mat='.$_GET['mat'].'#tabelaAlgoritmos');
        }
    }else if($_GET['e'] == 2 || $_GET['e'] == 4){
        try{
            include_once "Algoritmo.class.php";
            include_once "Solucao.class.php";
            $solucao = new Solucao;
            $algoritmo = new Algoritmo;
            if(!in_array($_POST['fk_cod_alg'],$algoritmo->cod_alg())){
                throw new PDOException();
            }else{
                $solucao->editaSolucao($_POST['x'],$_POST['y'],$_POST['fk_cod_alg'],$_POST['cod_sol']);
                $_SESSION['sucesso'] = true;
                header('location: ../index.php?e='.$_GET['e'].'&cod_alg='.$_GET['cod_alg'].'#tabelaSolucoes'); 
            }
        }catch(PDOException $e){
            $_SESSION['sucesso'] = false;
            header('location: ../index.php?e='.$_GET['e'].'&cod_alg='.$_GET['cod_alg'].'#tabelaSolucoes');
        }
    }

?>