<?php
        include_once "Solucao.class.php";
        include_once "Algoritmo.class.php";
        $solucao = new Solucao;
        $algoritmo = new Algoritmo;
        $dadosSol = $solucao->solucoesAlgoritmo($_GET['cod_alg']);
        $dadosAlg = $algoritmo->dadosAlgoritmos($_GET['cod_alg']);
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
                <h1 class="display-2 p-2">Soluções por Algoritmo</h1>
                <p class="lead">Tabela com todas as soluções de um Algoritmo e formulário para adicionar uma nova Solução</p>
                <p class="lead">Tabela mostrando a Solução dominante ou Soluções incomparáveis</p>
            </div>
        </div>
    </div>

    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left">Adicionar uma Solução</h1>
    <form action="index.php?e=4&c=3&cod_alg=<?=$_GET['cod_alg']?>" method="POST" class="mt-5 mt-lg-4">
        <div class="form-row ml-xl-4 mr-xl-4 ml-lg-2 mr-lg-2">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-4 mx-auto form-group text-center text-lg-left">
                <label for="cod_sol">ID</label>
                <input type="number" class="form-control text-center text-lg-left" placeholder="ID" name="cod_sol" readonly id="cod_sol" value = <?php 

                    $stm = $solucao->getCod_sol();
                    echo $stm->AUTO_INCREMENT;

                ?>>
            </div>
            <div class="col-lg form-group">
                <label for="x">X</label>
                <input type="number" class="form-control" placeholder="Valor do X" name="x" id="x" required autocomplete="off">
            </div>
            <div class="col-lg form-group">
                <label for="y">Y</label>
                <input type="number" class="form-control" placeholder="Valor do Y" name="y" id="y" required autocomplete="off">
            </div>
        </div>
        <div class="form-row mb-5">
            <button type="submit" class="btn btn-primary col-lg-6 col-sm-10 mt-3 mx-auto ">Adicionar</button>
        </div>
    </form> 
        
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="tabelaSolucoes">Soluções do algoritmo <?=$dadosAlg->nomeAlg?> (ID: <?=$dadosAlg->cod_alg?>)</h1>  

    <div class="table-responsive-sm col-xl-11 col-lg-12 mx-auto" > 
        <?php echo "<h1 class='text-center display-3 m-4 m-lg-0'> ". count($dadosSol)." Soluções registradas.</h1>";?>
        <table  class="table table-dark table-bordered" 
        
                data-toggle="table"  
                data-sort-name="id" 
                data-sort-order="asc" 
                
                <?php if(count($dadosSol) > 10) { echo 'data-height="550"';} ?>
                data-show-toggle="true"
                data-search="true"                    
        >
            <thead class="text-center">
                <tr class="thead">
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="X">X</th>
                    <th data-field="Y">Y</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    foreach($dadosSol as $dado){
                        ?>
                        <tr>
                            <td><?=$dado->cod_sol?></td>
                            <td><?=$dado->x?></td>
                            <td><?=$dado->y?></td>
                            <td><a href="?e=4&cod_sol=<?=$dado->cod_sol?>&cod_alg=<?=$dado->fk_cod_alg?>" title='Editar'><i class="fas fa-edit"></i></td>
                           <td><a href="includes/exclui.php?e=4&cod_sol=<?=$dado->cod_sol?>&cod_alg=<?=$dado->fk_cod_alg?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <?php
        $stm = $solucao->getXYById($_GET['cod_alg']);
        if(count($stm->fetchAll(PDO::FETCH_OBJ)) > 0){
            $stm = $solucao->getXYById($_GET['cod_alg']);
            $sol_json = json_encode($stm->fetchAll(PDO::FETCH_OBJ));
    ?>
     <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left my-5" id="graficoSolucoes">Gráfico das Soluções</h1>   
    <div class='bg-dark col-xl-11 col-lg-12 mx-auto mb-5'> 
        <canvas id="chart"></canvas>
    </div>

    <?php
            $stm = $solucao->getXYById($_GET['cod_alg']);
            $stm1 = $solucao->getXYById($_GET['cod_alg']);
            $meX = min($stm->fetchAll(PDO::FETCH_COLUMN,1));
            $meY = min($stm1->fetchAll(PDO::FETCH_COLUMN,2));

            $stm = $solucao->listaById($_GET['cod_alg']);
            $dominante = false;
            while($row = $stm->fetch(PDO::FETCH_OBJ)){
                if($row->x == $meX && $row->y == $meY){
                    $dominante = true;
                    break;
                }
            }

            if($dominante){
            ?>
                <h1 class="display-4 px-xl-4 px-lg-2 col-xl-12 text-left mt-5" id="solucao">Solução Dominante</h1>  
                <div class="table-responsive-sm col-xl-11 col-lg-12 mx-auto mt-n3 mb-5"> 
                    <table  class="table table-dark table-bordered"  data-toggle="table"  data-show-toggle="true">
                        <thead class="text-center">
                            <tr class="thead">
                                <th>ID</th>
                                <th>X</th>
                                <th>Y</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td><?=$row->cod_sol?></td>
                                <td><?=$row->x?></td>
                                <td><?=$row->y?></td>
                                <td><a href="?e=4&cod_sol=<?=$row->cod_sol?>&cod_alg=<?=$row->fk_cod_alg?>" title='Editar'><i class="fas fa-edit"></i></td>
                                <td><a href="includes/exclui.php?e=4&cod_sol=<?=$row->cod_sol?>&cod_alg=<?=$row->fk_cod_alg?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
        <?php
            }else{
        ?>
            <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left my-5" id="">Soluções Incomparáveis</h1>

            <?php
            /* (x1>x2 && y1<y2) || (x1<x2 && y1>y2) */

                $stm = $solucao->listaById($_GET['cod_alg']);
                $comp = $stm->fetchAll(PDO::FETCH_OBJ);
                $stm2 = $solucao->listaById($_GET['cod_alg']);
                $rows = $stm2->fetchAll(PDO::FETCH_OBJ);
                $i = -1;
                $primeiroLoop = true;
                $matriz = [];
                $vetor = [];
                while($i++ != count($comp) - 1){
                $tabelaCriada = false;
                foreach($rows as $row){
                    if((($comp[$i]->x > $row->x && $comp[$i]->y < $row->y) || ($comp[$i]->x < $row->x && $comp[$i]->y > $row->y)) && !(isset($matriz[$row->cod_sol]) && in_array($comp[$i]->cod_sol,$matriz[$row->cod_sol]))){
                        $tabelaCriada = true;
                        if($primeiroLoop){
                            $primeiroLoop = false;
                            ?>
                                <div class="table-responsive-sm mx-auto col-lg-10 col-md-12"> 
                                <?="<h1 class='mt-5 mb-4 text-center display-3'>Solução " . $comp[$i]->cod_sol . " (X:" . $comp[$i]->x .", Y:". $comp[$i]->y .")</h1>"?>
                                    <table  class="table table-dark table-bordered table-sm" 
                                    >
                                        <thead class="text-center">
                                            <tr class="thead">
                                                <th>ID</th>
                                                <th>X</th>
                                                <th>Y</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                            <?php
                        }
                        ?>
                            <tr>
                                <td><?=$row->cod_sol?></td>
                                <td><?=$row->x?></td>
                                <td><?=$row->y?></td>
                            </tr>
                        <?php
                        array_push($vetor,$row->cod_sol);
                    }
                }
                if($tabelaCriada) echo "</tbody></table></div>";
                $matriz[$comp[$i]->cod_sol] = $vetor;
                $vetor = [];
                $primeiroLoop = true;
                }
            ?>

    <?php
            }

            $stm =  $solucao->getXYById($_GET['cod_alg']);
            $dados = $stm->fetchAll(PDO::FETCH_OBJ);
            $labels = [];
            $label = $dadosAlg->nomeAlg .' (' . $dadosAlg->cod_alg . ')';
            foreach($dados as $dado){
                $labelItem = 'ID ' . $dado->cod_sol;
                $labels[] = $labelItem;
            }
        }
    ?>
    <script>
        var myArray = <?=$sol_json?>;
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'scatter',
            data: {
                labels: <?=json_encode($labels);?>,
                datasets: [{
                    label: <?=json_encode($label);?>,
                    pointBackgroundColor: 'royalblue',
                    borderColor: 'black',
                    pointRadius: 10,
                    pointHoverBorderWidth: 2,
                    pointHoverRadius:10,
                    pointHoverBackgroundColor: 'blue',
                    data: myArray
                }],
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            tot = 0;
                            i = tooltipItem.datasetIndex;
                            while(i--){
                                tot += data.datasets[i].data.length;
                            }
                            
                            var label = data.labels[tot + tooltipItem.index];
                            return label + ': (' + tooltipItem.xLabel + ', ' + tooltipItem.yLabel + ')';
                        }
                    }
                }, 
                legend: {
                    labels: {
                        usePointStyle:true,
                        fontSize: 14,
                        fontColor: 'white',
                        boxWidth: 13
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            max: Math.max.apply(Math, myArray.map(o => o.y)) + 1, 
                            fontColor: '#FFF'
                        },
                        gridLines: {
						    color: 'rgba(255,255,255,0.25)',
                            zeroLineColor: 'rgba(255,255,255,1)'
                        },
                    }],
                    xAxes: [{
                        type: 'linear',
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            max: Math.max.apply(Math, myArray.map(o => o.x)) + 1,
                            fontColor: '#FFF'
                        },
                        gridLines: {
						    color: 'rgba(255,255,255,0.25)',
                            zeroLineColor: 'rgba(255,255,255,1)'
                        }
                    }]
                }
            }


        });
    </script>
    
</body>
</html>