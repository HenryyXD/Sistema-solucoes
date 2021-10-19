<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

<?php 
    if($_GET['e'] == 0){
        include_once "includes/Aluno.class.php";
        $aluno = new Aluno;
        $dados = $aluno->dadosAluno($_GET['mat']);
?>
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="formEdita">Editar Aluno <?=$dados->nome?></h1>
    <form action="includes/edita.php?e=0" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="matricula">Matrícula</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="Matrícula" name="matricula" readonly id="matricula" value = <?=$_GET['mat']?>>
            </div>
            <div class="col-lg form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" placeholder="Nome" name="nome" id="nome" required autocomplete="off" value = "<?=$dados->nome?>">
            </div>
            <div class="col-lg form-group">
                <label for="curso">Curso</label>
                <input type="text" class="form-control" placeholder="Curso" name="curso" id="curso" required autocomplete="off" value = "<?=$dados->curso?>">
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Aplicar</button>
        </div>
    </form> 

    <?php
        }else if($_GET['e'] == 1 || $_GET['e'] == 3){
            include_once "includes/Algoritmo.class.php";
            $algoritmo = new Algoritmo;
            $dados = $algoritmo->dadosAlgoritmos($_GET['cod_alg']);
    ?>
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="formEdita">Editar Algoritmo <?=$dados->cod_alg?></h1>
    <form action="includes/edita.php?e=<?=$_GET['e']?>&mat=<?=$_GET['mat']?>" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="id">ID</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="ID" name="cod_alg" readonly id="id" value = <?=$_GET['cod_alg']?>>
            </div>
            <div class="col-lg form-group">
                <label for="nomeAlg">Nome</label>
                <input type="text" class="form-control" placeholder="Nome" name="nomeAlg" id="nomeAlg" required autocomplete="off" value = "<?=$dados->nomeAlg?>">
            </div>
            <div class="col-lg form-group">
                <label for="linguagem">Linguagem</label>
                <input type="text" class="form-control" placeholder="Linguagem" name="linguagem" id="linguagem" required autocomplete="off" value = "<?=$dados->linguagem?>">
            </div>
            <div class="col-lg form-group">
                <label for="fk_mat">Matrícula do Autor</label>
                <input type="number" class="form-control" placeholder="Matrícula do Autor" name="fk_mat" id="fk_mat" required autocomplete="off" value = <?=$dados->fk_mat?>>
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Aplicar</button>
        </div>
    </form> 

    <?php 
        }else if($_GET['e'] == 2 || $_GET['e'] == 4){
            include_once "Solucao.class.php";
            $solucao = new Solucao;
            $dados = $solucao->dadosSolucao($_GET['cod_sol']);
    ?>

<h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="formEdita">Editar Solução <?=$dados->cod_sol?></h1>
    <form action="includes/edita.php?e=<?=$_GET['e']?>&cod_alg=<?=$_GET['cod_alg']?>" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="id">ID</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="ID" name="cod_sol" readonly id="id" value = <?=$_GET['cod_sol']?>>
            </div>
            <div class="col-lg form-group">
                <label for="x">Valor do X</label>
                <input type="number" class="form-control" placeholder="Valor do X" name="x" id="x" required autocomplete="off" value = <?=$dados->x?>>
            </div>
            <div class="col-lg form-group">
                <label for="y">Y</label>
                <input type="number" class="form-control" placeholder="Valor do Y" name="y" id="y" required autocomplete="off" value = <?=$dados->y?>>
            </div>
            <div class="col-lg form-group">
                <label for="fk_cod_alg">ID do Algoritmo</label>
                <input type="number" class="form-control" placeholder="ID do Algoritmo" name="fk_cod_alg" id="fk_cod_alg" required autocomplete="off" value = <?=$dados->fk_cod_alg?>>
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Aplicar</button>
        </div>
    </form> 

    <?php
        }
    ?>
</body>
</html>
