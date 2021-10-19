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
                <h1 class="display-2 p-2">Alunos</h1>
                <p class="lead">Cadastro e tabela com todos os Alunos</p>
                <p class="lead">Clique na quantidade de Algoritmos para ver os Algoritmos daquele Aluno</p>
            </div>
        </div>
    </div>

    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left">Cadastro de Aluno</h1>
    <form action="index.php?e=0&c=1" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="matricula" >Matrícula</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="Matrícula" name="matricula" readonly id="matricula" value =<?php 

                    include_once "Aluno.class.php";
                    $aluno = new Aluno;
                    $stm = $aluno->getMatricula(); 
                    echo $stm->AUTO_INCREMENT;

?>>
            </div>
            <div class="col-lg form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" placeholder="Nome" name="nome" id="nome" required autocomplete="off">
            </div>
            <div class="col-lg form-group">
                <label for="curso">Curso</label>
                <input type="text" class="form-control" placeholder="Curso" name="curso" id="curso" required autocomplete="off">
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Cadastrar</button>
        </div>
    </form> 
        
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="tabelaAlunos">Tabela de Alunos</h1>  

    <?php
        include_once "Aluno.class.php";
        $aluno = new Aluno;
        $dados = $aluno->lista();
    ?>

    <div class=" table-responsive-sm col-xl-11 col-lg-12 mx-auto" > 
        <?php echo "<h1 class='text-center display-3 m-4 m-lg-0'> ". count($dados)." Alunos cadastrados.</h1>";?>
        <table  class="table table-dark table-bordered" 
        
                data-toggle="table"  
                data-sort-name="id" 
                data-sort-order="asc" 
                
                <?php if(count($dados) > 10) { echo 'data-height="550"';} ?>
                data-show-toggle="true"
                data-search="true"                    
        >
            <thead class="text-center">
                <tr class="thead">
                    <th data-field="id" data-sortable="true">Matrícula</th>
                    <th data-field="nome" data-sortable="true">Nome</th>
                    <th data-field="curso" data-sortable="true">Curso</th>
                    <th data-field="algoritmos" data-sortable="true">Algoritmos</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    foreach($dados as $dado){
                        ?>
                        <tr>
                            <td><?=$dado->matricula?></td>
                            <td><?=$dado->nome?></td>
                            <td><?=$dado->curso?></td>
                            <td><a name="<?=$dado->qtd?>" href="?e=3&mat=<?=$dado->matricula?>" title="Ver Algoritmos" class="d-block"><?=$dado->qtd?></a></td>
                            <td><a href="?e=0&mat=<?=$dado->matricula?>" title='Editar'><i class="fas fa-edit"></i></td>
                           <td><a href="includes/exclui.php?mat=<?=$dado->matricula?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>