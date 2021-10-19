
    <div class="row">
        <div class="jumbotron col-lg-12 jumbotron-fluid">
            <div class="container-fluid text-center">
                <h1 class="display-2 p-2">Soluções</h1>
                <p class="lead">Tabela e Gráfico com todas as Soluções</p>
                <p class="lead">Clique no nome do Algoritmo para ver todas as Soluções daquele Algoritmo</p>
            </div>
        </div>
    </div>
        
    <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left" id="tabelaSolucoes">Tabela de Soluções</h1>   

    <?php
        include_once "Solucao.class.php";
        $solucao = new Solucao;
        $dados = $solucao->lista();
        $dados = $dados->fetchAll(PDO::FETCH_OBJ);
    ?>

    <div class="table-responsive-sm col-xl-11 col-lg-12 mx-auto" > 
        <?php echo "<h1 class='text-center display-3 m-4 m-lg-0'> ". count($dados)." Soluções registradas.</h1>";?>
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
                    <th data-field="X">X</th>
                    <th data-field="Y">Y</th>
                    <th data-field="nome_algoritmo" data-sortable="true">Nome do Algoritmo (ID)</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                    foreach($dados as $dado){
                        ?>
                        <tr>
                            <td><?=$dado->cod_sol?></td>
                            <td><?=$dado->x?></td>
                            <td><?=$dado->y?></td>
                            <td><a nane = "<?=$dado->nomeAlg?>" href="?e=4&cod_alg=<?=$dado->fk_cod_alg?>" title="Ver Soluções"><?=$dado->nomeAlg?> (<?=$dado->fk_cod_alg?>)</a></td>
                            <td><a href="?e=2&cod_sol=<?=$dado->cod_sol?>&cod_alg=<?=$dado->fk_cod_alg?>" title='Editar'><i class="fas fa-edit"></i></td>
                           <td><a href="includes/exclui.php?e=2&cod_sol=<?=$dado->cod_sol?>&cod_alg=<?=$dado->fk_cod_alg?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    
   

    <?php
        $stm = $solucao->getXY();
        if(count($stm->fetchAll(PDO::FETCH_OBJ)) > 0){
            
    ?>
     <h1 class="display-4 p-xl-4 p-lg-2 col-xl-12 text-left my-5" id="graficoSolucoes">Gráfico das Soluções</h1>   
    <div class='bg-dark col-xl-11 col-lg-12 mx-auto mb-5'> 
        <canvas id="chart"></canvas>
    </div>
    
    <?php
            $stm = $solucao->getXY();
            $stm1 = $solucao->getXY();
            $meX = min($stm->fetchAll(PDO::FETCH_COLUMN,0));
            $meY = min($stm1->fetchAll(PDO::FETCH_COLUMN,1));

            $stm = $solucao->lista();
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
                                <th>Nome do Algoritmo (ID)</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td><?=$row->cod_sol?></td>
                                <td><?=$row->x?></td>
                                <td><?=$row->y?></td>
                                <td><?=$row->nomeAlg?> (<?=$row->fk_cod_alg?>)</td>
                                <td><a href="?e=2&cod_sol=<?=$row->cod_sol?>&cod_alg=<?=$row->fk_cod_alg?>" title='Editar'><i class="fas fa-edit"></i></td>
                                <td><a href="includes/exclui.php?e=2&cod_sol=<?=$row->cod_sol?>&cod_alg=<?=$row->fk_cod_alg?>" title='Excluir'><i class="fas fa-trash-alt"></i></a></td>
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

            $stm = $solucao->lista();
            $comp = $stm->fetchAll(PDO::FETCH_OBJ);
            $stm2 = $solucao->lista();
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
                                                <th>Nome do Algoritmo (ID)</th>
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
                                <td><?=$row->nomeAlg?> (<?=$row->fk_cod_alg?>)</td>
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
            $stm = $solucao->getXY();
            $sol_json = json_encode($stm->fetchAll(PDO::FETCH_OBJ));
            $dados = $solucao->dadosGrafico();
            $labels = [];
            $datasets = [];
            $data = [];
            foreach($dados as $dado){
                
                    $stm = $solucao->getXYById($dado->cod_alg);
                    
                    while($row = $stm->fetch(PDO::FETCH_OBJ)){
                        $d = new stdClass; 
                        $d->x = $row->x;
                        $d->y = $row->y; 
                        $data[] = $d;

                        $labelItem = 'ID ' . $row->cod_sol;
                        $labels[] = $labelItem;
                    }

                    $ds = new stdClass; 
                    $ds->label = $dado->nomeAlg .' (' . $dado->cod_alg . ')';
                    $ds->pointBackgroundColor = $solucao->getRandomColor();
                    $ds->borderColor = 'black';
                    $ds->pointRadius = 10;
                    $ds->pointHoverBorderWidth = 2;
                    $ds->pointHoverRadius = 10;
                    $ds->borderColor = 'black';
                    $ds->data = $data;

                    

                    $datasets[] = $ds;
                
                    unset($data);
            }

        } 
        
    ?>

    <script>

        var myArray = <?=$sol_json?> 
        var i;
        var tot = 0;
        var ctx = document.getElementById('chart').getContext('2d')
        var chart = new Chart(ctx, {
            
            type: 'scatter', 
            data: {
                labels:<?=json_encode($labels);?>,
                datasets: <?=json_encode($datasets);?>,
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
