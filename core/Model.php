<?php
    namespace App\Core;

    class Model implements IModel{
        public static function table():string{
            $table = get_called_class();
            $table = str_replace("App\\Model\\", "", $table);
            $table = ($table == "Professeur" or $table == "AC" or $table == "RP" or $table == "Etudiant" or $table == "User") ? "personne" : strtolower($table);
            return $table;
            // return get_called_class();
        }

        public static function role($role) {  
            return  $role;
        }

       //dependance voir diag de classes:creation dun objet de type database
        protected  static function database():Database{
            return new Database();
        }

        public function insert():int{
            return 0;
        }
        public function update():int{
            return 0;
        }

        public static function findAll():array{
            $db = self::database();
            $db->connectionBD();
            //requete non préparée, var injectée lors de l'écriture de la requête
                $sql = "SELECT * FROM ".self::table();
                $result = $db->executeSelect($sql);
            $db->closeConnection();
            return $result;        
        }

        public static function delete(int $id):int{
            $db = self::database();
            $db->connectionBD();
            //requete préparée, var injectée lors de l'exéxution de la requête, var remplacée par un joker, 1st joker pos -0, 2nd joker pos 1
                $sql = "DELETE FROM ".self::table()." WHERE id = ?";
                $result = $db->executeUpdate($sql, [$id]);
            $db->closeConnection();
            return $result;
        }
        
        public static function findById(int $id):object|null{
            $db = self::database();
            $db->connectionBD();
                $sql = "SELECT * FROM ".self::table()." WHERE id = ?";
                $result = $db->executeSelect($sql, [$id]);
            $db->closeConnection();
            return $result; 
        }

        public static function findBy(string $sql, array $data=null, $single=false):object|null|array{
            $db = self::database();
            $db->connectionBD();
                $result = $db->executeSelect($sql, $data, $single);
            $db->closeConnection();
            return $result; 
        }
    }