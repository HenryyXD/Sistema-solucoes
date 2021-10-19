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
                <h1 class="display-2 p-2">Algoritmos</h1>
                <p class="lead">Tabela com todos os algoritmos</p>
                <p class="lead">Clique na quantidade de Soluções para ver todas as Soluções daquele Algoritmo</p>
                <p class="lead">Clique no nome do Autor para ver todos os seus Algoritmos</p>
            </div>
        </div>
    </div>
        
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="tabelaAlgoritmos">Tabela de Algoritmos</h1>   

    <?php
        include_once "Algoritmo.class.php";
        $algoritmo = new Algoritmo;
        $dados = $algoritmo->lista();
    ?>

    <div class="table-responsive-sm col-xl-11 col-lg-12 mx-auto" > 
        <?php echo "<h1 class='text-center display-3 m-4 m-lg-0'> ". count($dados)." Algoritmos registrados.</h1>";?>
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
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="nome" data-sortable="true">Nome</th>
                    <th data-field="linguagem" data-sortable="true">Linguagem</th>
                    <th data-field="autor" data-sortable="true">Autor (Matrícula)</th>
                    <th data-field="solucoes" data-sortable="true">Soluções</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    foreach($dados as $dado){
                        ?>
                        <tr>
                            <td><?=$dado->cod_alg?></td>
                            <td><?=$dado->nomeAlg?></td>
                            <td><?=$dado->linguagem?></td>
                            <td><a name="<?=$dado->nome?> <?=$dado->fk_mat?>" href="?e=3&mat=<?=$dado->fk_mat?>" title="Ver Algoritmos" class="d-block"> <?=$dado->nome?> (<?=$dado->fk_mat?>)  </a></td>
                            <td><a name="<?=$dado->qtd?>" href="?e=4&cod_alg=<?=$dado->cod_alg?>" title="Ver Soluções" class="d-block"><?=$dado->qtd?></a></td>
                            <td><a href="?e=1&cod_alg=<?=$dado->cod_alg?>&mat=<?=$dado->fk_mat?>" title='Editar'><i class="fas fa-edit"></i></td>
                           <td><a href="includes/exclui.php?e=1&cod_alg=<?=$dado->cod_alg?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>