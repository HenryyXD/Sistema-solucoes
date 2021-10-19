<?php
    class Solucao{
        private $colors = array( 
            "#F00",
            "#FF1493",
            "#DB7093",
            "#FF6347",
            "#FFA500",
            "#FFFF00",
            "#BDB76B",
            "#8A2BE2",
            "#8B008B",
            "#00FF00",
            "#008000",
            "#00FFFF",
            "#0000FF",
            "#191970",
            "#B0E0E6",
            "#8B4513"
        );

        public function lista(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_sol,x,y,fk_cod_alg,algoritmos.nomeAlg from solucoes inner join algoritmos on algoritmos.cod_alg = fk_cod_alg order by cod_sol;");
            $stm->execute();
            return $stm;
        }

        public function dadosSolucao($cod_sol){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select * from solucoes where cod_sol = ?;");
            $stm->bindValue(1,$cod_sol);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }

        public function editaSolucao($x,$y,$fk_cod_alg,$cod_sol){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("update solucoes set x=?,y = ?,fk_cod_alg=? where cod_sol = ?;");
            $stm->bindValue(1,$x);
            $stm->bindValue(2,$y);
            $stm->bindValue(3,$fk_cod_alg);
            $stm->bindValue(4,$cod_sol);
            $stm->execute();
        }

        public function excluirSolucao($cod_sol){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("delete from solucoes where cod_sol = ?");
            $stm->bindValue(1,$cod_sol);
            $stm->execute();
        }

        public function getXY(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select x,y from solucoes");
            $stm->execute();
            return $stm;
        }

        public function solucoesAlgoritmo($cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_sol,x,y,fk_cod_alg,algoritmos.nomeAlg from solucoes inner join algoritmos on algoritmos.cod_alg=fk_cod_alg where fk_cod_alg = ?;");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function getCod_sol(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA = 'id11753124_solucoes' AND TABLE_NAME = 'solucoes';");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }

        public function getXYById($cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_sol,x,y from solucoes where fk_cod_alg = ? order by fk_cod_alg;");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();
            return $stm;
        }

        public function listaById($cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_sol,x,y,fk_cod_alg,algoritmos.nomeAlg from solucoes inner join algoritmos on algoritmos.cod_alg = fk_cod_alg where fk_cod_alg = ? order by cod_sol;");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();
            return $stm;
        }

        public function novaSol($x,$y,$fk_cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("insert into solucoes values(default,?,?,?)");
            $stm->bindValue(1,$x);
            $stm->bindValue(2,$y);
            $stm->bindValue(3,$fk_cod_alg);
            $stm->execute();
        }

        public function dadosGrafico(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_alg,nomeAlg from algoritmos inner join solucoes on solucoes.fk_cod_alg = cod_alg group by cod_alg  order by cod_alg;");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function getRandomColor() {
            if(sizeof($this->colors) > 0){
                $key = array_rand($this->colors);
                $color = $this->colors[$key];
                unset($this->colors[$key]);
                return strtolower($color);
            }else{
                return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
        }

    }
?>