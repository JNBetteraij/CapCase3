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

        public function addRecipe(Recipe $recipe): bool{
            try{
                /*$recipeValues = $recipe->convertToDatabaseFormat();
                $implodedValues = implode(',' , $recipeValues);
                $result = "INSERT INTO recipes (id, submission_date, recipe_name, brief_description, preparation_time, instructions) VALUES ($implodedValues)";
                echo $result . "<br>";
                $statement = $this->dbConnection->query("INSERT INTO recipes (id, submission_date, recipe_name, brief_description, preparation_time, instructions) VALUES ($implodedValues)");
                $statement->execute();*/
                return true;
            }
            catch (PDOException $pdoException){
                echo $pdoException . "<br>";
                return false;
            }
            
        }

        public function deleteRecipe(int $id): bool{
            try{
                $statement = $this->dbConnection->query("DELETE FROM recipes WHERE id = $id");
                $statement->execute();
                return true;
            }
            catch (PDOException $pdoException){
                return false;
            }
        }

        public function updateRecipe(int $id, Recipe $recipe): bool{
            try{
                $this->deleteRecipe($id);
                $this->addRecipe($recipe);
                return true;
            }
            catch (PDOException $pdoException){
                return false;
            }
            
            return false;
        }

        public function getRecipe(string $id): Recipe{
            $statement = $this->dbConnection->query("SELECT * FROM recipes WHERE id = $id");
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
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
    $recipe = $dbm->getRecipe("2");
    $converted = $recipe->convertToDatabaseFormat();
    echo var_export($dbm->addRecipe(new Recipe("4", "12-2-2023", "Test", "Description", 15, "1 Test", []))) . "<br>";
    echo var_dump($converted);
    
    
    //echo var_export($dbm->deleteRecipe(1), true);


    // echo var_dump($recipe);
    // foreach($recipe as $key => $col){
    //     echo "$col<br>";
    // }
    
?>