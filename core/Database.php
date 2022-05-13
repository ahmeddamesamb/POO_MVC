<?php
    namespace App\Core;

    class Database {
        private \PDO|null $pdo=null;
          
        public function connectionBD():void{
            $this->pdo = new \PDO("mysql:dbname=poo_inscription;host=localhost:85","root","");
                echo "connexion a la base reussit";die;
        }

        public function closeConnection():void{
            $this->pdo = null;
        }

        public function executeSelect(string $sql, array $datas=[], bool $single = false):object|null|array{
            $query = $this->pdo->prepare($sql);
            $query->execute($datas);
            if($single){ //single = true
                $result = $query->fetch(\PDO::FETCH_OBJ);
                if($query->rowCount() == 0 ) return null;
            }
            else{
                $result = $query->fetchAll(\PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
            }
            return $result;
        }

        public function executeUpdate(string $sql, array $datas=[]):int{
            $query = $this->pdo->prepare($sql);
            $query->execute($datas);
            // insert -> retourner le dernier Id inséré
            return $query->rowCount(); 
        }
    }