<?php declare(strict_types = 1);

    include_once("../classes/recipe.php");
    include_once("../classes/Ingredient.php");
    class DatabaseManager{
        private PDO $dbConnection;

        private string $username = "root";
        private string $password = "";
        private string $host = "localhost";
        private string $dbname = "recipebook";

        private string $recipeTableName = "recipes";
        private string $ingredientTableName = "ingredients";
        private string $joinTableName = "ingredients_recipes";

        public function __construct(){
            try {
                $this->dbConnection = $this->createDBConnection();
            } catch (PDOException $pdoException) {
                //note: currently assuming db doesn't exist, therefor run setup for database
                $this->setupDatabase();
                $this->dbConnection = $this->createDBConnection();
            }
        }

        private function createDBConnection(): PDO{
            return new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        }

#region database set up
        public function setupDatabase(){
            $this->createDatabase();
            $this->createRecipeTable();
            $this->createIngredientTable();
            $this->createRecipeIngredientJoinTable();
        }

        private function createDatabase(): void{
            try {
                $conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
                $conn->exec("CREATE DATABASE $this->dbname");
                $conn = null;
            } 
            catch (PDOException $pdoException) {
                //throw $pdoException;
            }
        }

        public function createRecipeTable(): void{
            try {
                $conn = $this->createDBConnection();
                $conn->exec("CREATE TABLE $this->recipeTableName(
                    id INT(36) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    recipe_name VARCHAR(255),
                    brief_description VARCHAR(255),
                    preparation_time INT(11),
                    instructions TEXT
                )");
                $conn = null;
            } 
            catch (PDOException $pdoException) {
                //throw $pdoException;
            }
        }

        public function createIngredientTable(): void{
            try {
                $conn = $this->createDBConnection();
                $conn->exec("CREATE TABLE $this->ingredientTableName(
                    id INT(36) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    ingredient_name VARCHAR(255),
                    brief_description VARCHAR(255)
                )");
                $conn = null;
            } 
            catch (PDOException $pdoException) {
                //throw $pdoException;
            }
        }

        public function createRecipeIngredientJoinTable(): void{
            try {
                $conn = $this->createDBConnection();
                $conn->exec("CREATE TABLE $this->joinTableName(
                    recipe_id INT(36),
                    ingredient_id INT(36),
                    amount INT(36),
                    units VARCHAR(255)
                )");
                $conn = null;
            } 
            catch (PDOException $pdoException) {
                //throw $pdoException;
            }
        }
#end region
        
#region add entries
        public function addRecipe(Recipe $recipe): int|Exception{
            try {
                $recipeTableData = $recipe->getRecipeTableValues();
                $columnHeaders = implode(',',$recipeTableData->headers);
                $columnValues = implode(',',$recipeTableData->values);

                echo "see if this runs<br>";

                // $statement = $this->dbConnection->prepare("INSERT INTO $this->recipeTableName ($columnHeaders)
                // VALUES($columnValues)");
                
                $statement = $this->dbConnection->prepare("INSERT INTO bestaat_niet ($columnHeaders)
                VALUES($columnValues)");

                $statement->execute();
                $id = $this->dbConnection->lastInsertId();
                echo "added new recipe with id:$id<br>";
                return (int)$id;
            } 
            catch (Exception $exception) {
                echo "!exception thrown when adding new recipe<br>".$exception;
                throw $exception;
                echo "show this after exception<br>";
            }
        }

        public function addIngredient(Ingredient $ingredient): string|false{
            try {
                $tableData = $ingredient->convertToDatabaseFormat();
                $columnHeaders = implode(',',$tableData->headers);
                $columnValues = implode(',',$tableData->values);

                $statement = $this->dbConnection->prepare("INSERT INTO $this->ingredientTableName ($columnHeaders)
                VALUES($columnValues)");
                $statement->execute();

                $id = $this->dbConnection->lastInsertId();
                if(is_bool($id) && !$id){
                    
                }
                return $id;
            } 
            catch (PDOException $pdoException) {
                echo $pdoException;
                return null;
            }
        }

        public function addIngredientToRecipe(Recipe $recipe, Ingredient $ingredient, bool $newIngredient = false){
            try {
                if($newIngredient){
                    $this->addIngredient($ingredient);
                    //TODO: get new ingredient entry ID
                    //note need to ensure we retrieve the correct latest added
                }

                if(is_null($ingredient->getID())){
                    throw new Exception("ingredient missing valid ID");
                    return;
                }
            } 
            catch (Exception $exception) {
                //throw $exception;
            }
        }

        private function addEntryTonRecipeIngredientJoinTable(Recipe $recipe,Ingredient $ingredient){
            $recipeID = $recipe->getID();
            $ingredientID = $ingredient->getID();


        }
#end region
        
#region read/get entries
        public function getRecipe(int $id): Recipe{
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
#end region

#region update entries
        public function updateRecipe(int $id, Recipe $recipe): void{
            try {
                $recipeTableData = $recipe->getRecipeTableValues();
                $updatedColumnHeaders = $recipeTableData->headers;
                $updatedColumnValues = $recipeTableData->values;
                $this->updateEntryInTable($this->recipeTableName, $id, $updatedColumnHeaders, $updatedColumnValues);
            } 
            catch (Exception $exception) {
                throw $exception;
            }
        }

        public function updateIngredient(int $id, Ingredient $ingredient): void{
            $tableData = $ingredient->convertToDatabaseFormat();
                $updatedColumnHeaders = $tableData->headers;
                $updatedColumnValues = $tableData->values;
                $this->updateEntryInTable($this->recipeTableName, $id, $updatedColumnHeaders, $updatedColumnValues);
        }

        public function updateEntryInTable(string $tableName, int $id, array $columnHeaders, array $columnValues):void{
            try{
                $updates = [];
                foreach ($columnHeaders as $key => $columnHeader) {
                    $querySnippet = $columnHeader."=".$columnValues[$key];
                    array_push($updates, $querySnippet);
                }
                $updates = implode( ", ",$updates);

                $statement = $this->dbConnection->prepare("UPDATE $tableName SET $updates WHERE id=$id");
                $statement->execute();
            }
            catch (PDOException $pdoException){
                throw $pdoException;
            }
        }
#end region

#region delete
        public function deleteRecipe(int $id): bool{
            try{
                //test if this works with prepare then delete this comment
                $statement = $this->dbConnection->prepare("DELETE FROM $this->recipeTableName WHERE id = $id");
                $statement->execute();
                return true;
            }
            catch (PDOException $pdoException){
                return false;
            }
        }

        public function deleteEntryInTable(string $tableName, int $id): void{
            try{
                $statement = $this->dbConnection->prepare("DELETE FROM $tableName WHERE id = $id");
                $statement->execute();
            }
            catch (PDOException $pdoException){
                throw $pdoException;
            }
        }
#end region
    }


    $dbm = new DatabaseManager();
    echo "test error handling<br>";
    $testRecipe = new Recipe(0, date("Y-m-d H:i:s"), "recipe title", "brief_description", 69, "instruction list",[]);
    try {
        $result = $dbm->addRecipe($testRecipe);
        echo "result:".$result."<br><br>";
        echo "$result is van type: ".gettype($result)."<br>";
    } catch (\Throwable $th) {
        echo "caught error <br><br>";
    }
    

    // $updateRecipe = new Recipe(0, date("Y-m-d H:i:s"), "updated recipe title", "updated description", 109, "new instruction list",[]);
    // $dbm->updateRecipe(8,$updateRecipe);
    
?>