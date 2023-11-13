<?php declare(strict_types = 1);
    class DatabaseManager{

        private PDO $dbConnection;

        public function __construct(){
            $this->createConnection();
        }

        private function createConnection(){
            $username = "root";
            $password = "";
            $host = "localhost";
            $dbname = "recipebook";

            $this->dbConnection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        }

        public function addRecipe(){
            
        }

        public function getRecipe(int $id){
            $statement = $this->dbConnection->query("SELECT * FROM recipes WHERE id = $id");
        }

        public function getAllRecipes(){
            $statement = $this->dbConnection->query("SELECT * FROM recipes");
            $statement->execute();
            $results = $statement->fetchAll(); //Multidimensional array
            echo var_dump($results);
            for ($i=0; $i < count($results); $i++) { 
                echo $results[$i]["name"]. "<br>";
            }
            
    
        }
        
    }
    $dbm = new DatabaseManager();
    $dbm->getAllRecipes();
    $dbm->getRecipe(1);
?>