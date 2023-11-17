<?php declare(strict_types = 1);

    include_once("../classes/recipe.php");
    class DatabaseManager{

        private PDO $dbConnection;

        public function __construct(){
            $this->createConnection();
        }

        /* id, date, name, brief_description, preparation_time, instructions
        */

        private function createConnection(){
            $username = "root";
            $password = "";
            $host = "localhost";
            $dbname = "recipebook";

            $this->dbConnection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        }

        public function addRecipe(){
            
        }

        public function deleteRecipe(int $id): bool{

            return false;
        }

        public function updateRecipe(int $id, Recipe $recipe): bool{

            return false;
        }

        public function getRecipe(int $id): Recipe{
            $statement = $this->dbConnection->query("SELECT * FROM recipes WHERE id = $id");
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
            echo var_dump($data);
            $recipe = $this->createRecipeObject($data);
            return $recipe;
            //!Returns each column double without the for loop, find out why later
        }

        public function getAllRecipes(): array{
            $statement = $this->dbConnection->query("SELECT * FROM recipes");
            $statement->execute();
            $data = $statement->fetchAll();
            $recipes = [];
            foreach ($data as $row){
                for ($i=count($row) - 1 ; $i >= 0 ; $i--) { 
                    if ($i % 2 == 0){
                        array_splice($row, $i, 1);
                    }
                }
                array_push($row, []);
                array_push($recipes, new Recipe(...$row));
            }
            return $recipes;
            /*foreach($recipes as $key => $recipe){
                echo $recipe["name"]. "<br>";
                echo $key . "<br>";
            }*/
            
    
        }

        private function createRecipeObject(array $data){
            $values = [];
            foreach($data as $key => $row){
                    array_push($values, $row); 
                }
            array_push($values, []); //Placeholder for ingredients
            $recipe = new Recipe(...$values);
            return $recipe;
        }
        
    }
    $dbm = new DatabaseManager();

    // $recipes = $dbm->getAllRecipes();
    // foreach($recipes as $key => $recipe){
    //     echo $recipe->getName(). "<br>";
    //     echo $key . "<br>";
    // }
    $recipe = $dbm->getRecipe(1);
    echo var_dump($recipe);
    // foreach($recipe as $key => $col){
    //     echo "$col<br>";
    // }
    
?>