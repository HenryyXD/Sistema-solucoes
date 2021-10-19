<?php
        include_once "Algoritmo.class.php";
        include_once "Aluno.class.php";
        $algoritmo = new Algoritmo;
        $aluno = new Aluno;
        $dadosAlu = $aluno->dadosAluno($_GET['mat']);
        $dadosAlg = $algoritmo->algoritmosAluno($_GET['mat']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div class="row">
        <div class="jumbotron col-lg-12 jumbotron-fluid">
            <div class="container-fluid text-center">
                <h1 class="display-2 p-2">Algoritmos por Aluno</h1>
                <p class="lead">Tabela com todos os algoritmos de um Aluno e formulário para adicionar um novo Algoritmo</p>
                <p class="lead">Clique na quantidade de Soluções para ver todas as Soluções daquele Algoritmo</p>
            </div>
        </div>
    </div>

    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left">Adicionar um Algoritmo</h1>
    <form action="index.php?e=3&c=2&mat=<?=$_GET['mat']?>" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="cod_alg">ID</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="ID" name="cod_alg" readonly id="cod_alg" value = <?php 
                    $stm = $algoritmo->getCod_alg();
                    echo $stm->AUTO_INCREMENT;

                ?>>
            </div>
            <div class="col-lg form-group">
                <label for="nomeAlg">Nome</label>
                <input type="text" class="form-control" placeholder="Nome" name="nomeAlg" id="nomeAlg" required autocomplete="off">
            </div>
            <div class="col-lg form-group">
                <label for="linguagem">Linguagem</label>
                <input type="text" class="form-control" placeholder="Linguagem" name="linguagem" id="linguagem" required autocomplete="off">
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Adicionar</button>
        </div>
    </form> 
        
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="tabelaAlgoritmos">Algoritmos de <?=$dadosAlu->nome?> (Matrícula: <?=$dadosAlu->matricula?>)</h1>  

    <div class="table-responsive-sm col-xl-11 col-lg-12 mx-auto" > 
        <?php echo "<h1 class='text-center display-3 m-4 m-lg-0'> ". count($dadosAlg)." Algoritmos registrados.</h1>";?>
        <table  class="table table-dark table-bordered" 
        
                data-toggle="table"  
                data-sort-name="id" 
                data-sort-order="asc" 
                
                <?php if(count($dadosAlg) > 10) { echo 'data-height="550"';} ?>
                data-show-toggle="true"
                data-search="true"                    
        >
            <thead class="text-center">
                <tr class="thead">
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="name" data-sortable="true">Nome</th>
                    <th data-field="linguage" data-sortable="true">Linguagem</th>
                    <th data-field="price" data-sortable="true">Soluções</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    foreach($dadosAlg as $dado){
                        ?>
                        <tr>
                            <td><?=$dado->cod_alg?></td>
                            <td><?=$dado->nomeAlg?></td>
                            <td><?=$dado->linguagem?></td>
                            <td><a name="<?=$dado->qtd?>" href="?e=4&cod_alg=<?=$dado->cod_alg?>" title="Ver Soluções" class="d-block"><?=$dado->qtd?></a></td>
                            <td><a href="?e=3&cod_alg=<?=$dado->cod_alg?>&mat=<?=$_GET['mat']?>" title='Editar'><i class="fas fa-user-edit"></i></td>
                            <td><a href="includes/exclui.php?e=3&cod_alg=<?=$dado->cod_alg?>&mat=<?=$dado->fk_mat?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <footer class="my-5"></footer>
</body>
</html>