<?php

    class  Aluno{
        
        public function lista(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select alunos.*,(select count(fk_mat) from algoritmos where alunos.matricula = fk_mat) as qtd from alunos;"); 
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } 

        public function cadastraAluno($nome,$curso){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("insert into alunos values(default,?,?)");
            $stm->bindValue(1,$nome);
            $stm->bindValue(2,$curso);
            $stm->execute();
        }

        public function getMatricula(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA = 'id11753124_solucoes' AND TABLE_NAME = 'alunos';");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }

        public function excluirAluno($matricula){
            include_once "conn.php";
            $con = conn();
            $stm1 = $con->prepare("select * from algoritmos where fk_mat = ?");
            $stm1->bindValue(1,$matricula);
            $stm1->execute();
            $dadosAlgoritmos = $stm1->fetchAll(PDO::FETCH_OBJ);
            foreach($dadosAlgoritmos as $dado){
                $stm2 = $con->prepare("delete from solucoes where fk_cod_alg = ?");
                $stm2->bindValue(1,$dado->cod_alg);
                $stm2->execute();
            }
            $stm1 = $con->prepare("delete from algoritmos where fk_mat = ?");
            $stm1->bindValue(1,$matricula);
            $stm1->execute();
            $stm1 = $con->prepare("delete from alunos where matricula = ?");
            $stm1->bindValue(1,$matricula);
            $stm1->execute();
        }

        public function dadosAluno($matricula){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select * from alunos where matricula = ?");
            $stm->bindValue(1,$matricula);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
        
        public function editaAluno($nome,$curso,$matricula){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("update alunos set nome = ?,curso=? where matricula = ?");
            $stm->bindValue(1,$nome);
            $stm->bindValue(2,$curso);
            $stm->bindValue(3,$matricula);
            $stm->execute();
        }

        public function matriculas(){
            include_once "conn.php";
            $con = conn();
            $stm = $con->prepare("select matricula from alunos;");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_COLUMN);
        }
    }
    

?>