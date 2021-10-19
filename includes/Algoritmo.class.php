<?php
    class Algoritmo{
        public function lista(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select algoritmos.*,alunos.nome,(select count(fk_cod_alg) from solucoes where algoritmos.cod_alg = fk_cod_alg) as qtd from algoritmos inner join alunos on alunos.matricula = fk_mat;"); 
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function excluirAlgoritmo($cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("delete from solucoes where fk_cod_alg = ?");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();

            $stm = $con->prepare("delete from algoritmos where cod_alg = ?");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();
        }
        
        public function dadosAlgoritmos($cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select * from algoritmos where cod_alg = ?;");
            $stm->bindValue(1,$cod_alg);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }

        public function editaAlgoritmo($nome,$linguagem,$fk_mat,$cod_alg){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("update algoritmos set nomeAlg=?,linguagem = ?,fk_mat=? where cod_alg = ?;");
            $stm->bindValue(1,$nome);
            $stm->bindValue(2,$linguagem);
            $stm->bindValue(3,$fk_mat);
            $stm->bindValue(4,$cod_alg);
            $stm->execute();
        }

        public function algoritmosAluno($mat){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_alg,nomeAlg,linguagem,fk_mat,alunos.nome,(select count(fk_cod_alg) from solucoes where algoritmos.cod_alg = fk_cod_alg) as qtd from algoritmos inner join alunos on alunos.matricula=fk_mat where fk_mat = ?;");
            $stm->bindValue(1,$mat);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function getCod_alg(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA = 'id11753124_solucoes' AND TABLE_NAME = 'algoritmos';");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }

        public function novoAlg($nome,$linguagem,$autor){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("insert into algoritmos values(default,?,?,?);");
            $stm->bindValue(1,$nome);
            $stm->bindValue(2,$linguagem);
            $stm->bindValue(3,$autor);
            $stm->execute();
        }

        public function cod_alg(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select cod_alg from algoritmos;");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_COLUMN);
        }

        
    }
?>