<?php declare(strict_types = 1);
    require_once "../classes/recipe.php";
    require_once "../classes/Ingredient.php";
    require_once "../classes/Sanitize.php";

    //for debugging
    include_once "../dev/QueryEcho.php";
    
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
                $this->populateDatabaseWithTestRecipes();
            }
        }

        public function populateDatabaseWithTestRecipes(){


            $this->populateDatabaseWithTestRecipe(
                new Recipe(
                    1, 
                    date("Y-m-d H:i:s"), 
                    "Pannenkoeken", 
                    "Deze traditionele Nederlandse lekkerheid valt bij jong en oud in de smaak. Combineer met wat je maar wil voor eindeloze variatie. Smakelijk eten!",
                    random_int(0,100),
                    ["Maak een kuiltje in de bloem in een kom. Voeg de eieren en een beetje melk toe. Meng dit geleidelijk, voeg steeds meer melk toe tot een glad beslag.",
                        "Voeg een snufje zout toe. Naar wens kun je zoete of hartige ingrediënten toevoegen.",
                        "Verhit een klontje boter of wat olie in een koekenpan op middelhoog vuur.",
                        "Schenk een pollepel beslag in de pan, kantel voor een egale verdeling.",
                        "Bak de pannenkoek circa 2 minuten tot de onderkant goudbruin is, keer dan om. Bak de andere kant ook tot goudbruin.",
                        "Serveer de pannenkoeken warm. Traditioneel met stroop of poedersuiker, maar voel je vrij om te experimenteren met andere toppings."],
                    []
                ),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );

            $this->populateDatabaseWithTestRecipe(
                new Recipe(2, date("Y-m-d H:i:s"), "Kipsate", "Een heerlijke combinatie van smaken en texturen, typisch voor de Maleisische keuken. Eet smakelijk!", random_int(0,100),
                ["Maak een kuiltje in de bloem in een kom. Voeg de eieren en een beetje melk toe. Meng dit geleidelijk, voeg steeds meer melk toe tot een glad beslag.",
                "Voeg een snufje zout toe. Naar wens kun je zoete of hartige ingrediënten toevoegen.",
                "Verhit een klontje boter of wat olie in een koekenpan op middelhoog vuur.",
                "Schenk een pollepel beslag in de pan, kantel voor een egale verdeling.",
                "Bak de pannenkoek circa 2 minuten tot de onderkant goudbruin is, keer dan om. Bak de andere kant ook tot goudbruin.",
                "Serveer de pannenkoeken warm. Traditioneel met stroop of poedersuiker, maar voel je vrij om te experimenteren met andere toppings."],[]),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );

            $this->populateDatabaseWithTestRecipe(
                new Recipe(3, date("Y-m-d H:i:s"), "Boerenkool met Worst", "Dit traditionele gerecht is vooral populair in de koudere maanden en biedt een heerlijke combinatie van smaken en texturen. Eet smakelijk!", random_int(0,100),
                ["Maak een kuiltje in de bloem in een kom. Voeg de eieren en een beetje melk toe. Meng dit geleidelijk, voeg steeds meer melk toe tot een glad beslag.",
                "Voeg een snufje zout toe. Naar wens kun je zoete of hartige ingrediënten toevoegen.",
                "Verhit een klontje boter of wat olie in een koekenpan op middelhoog vuur.",
                "Schenk een pollepel beslag in de pan, kantel voor een egale verdeling.",
                "Bak de pannenkoek circa 2 minuten tot de onderkant goudbruin is, keer dan om. Bak de andere kant ook tot goudbruin.",
                "Serveer de pannenkoeken warm. Traditioneel met stroop of poedersuiker, maar voel je vrij om te experimenteren met andere toppings."],[]),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );

            $this->populateDatabaseWithTestRecipe(
                new Recipe(4, 
                date("Y-m-d H:i:s"), 
                "Spaghetti Bolognese", 
                "Dit klassieke Italiaanse gerecht is een favoriet in veel Nederlandse huishoudens en vormt een perfecte maaltijd voor zowel doordeweekse dagen als speciale gelegenheden. Eet smakelijk!", 
                random_int(0,100), 
                ["1. Lees de instructies","2. Volg de instructies","3. Controleer de instructies","4. Eet de instructies"],
                []),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );


            $this->populateDatabaseWithTestRecipe(
                new Recipe(5, date("Y-m-d H:i:s"), 
                "Kip Burritos", 
                "Deze burritos zijn een heerlijke combinatie van Mexicaanse smaken met een Nederlands tintje. Eet smakelijk!",
                random_int(0,100),
                ["Maak een kuiltje in de bloem in een kom. Voeg de eieren en een beetje melk toe. Meng dit geleidelijk, voeg steeds meer melk toe tot een glad beslag.",
                "Voeg een snufje zout toe. Naar wens kun je zoete of hartige ingrediënten toevoegen.",
                "Verhit een klontje boter of wat olie in een koekenpan op middelhoog vuur.",
                "Schenk een pollepel beslag in de pan, kantel voor een egale verdeling.",
                "Bak de pannenkoek circa 2 minuten tot de onderkant goudbruin is, keer dan om. Bak de andere kant ook tot goudbruin.",
                "Serveer de pannenkoeken warm. Traditioneel met stroop of poedersuiker, maar voel je vrij om te experimenteren met andere toppings."
                ],
                []),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );

            $this->populateDatabaseWithTestRecipe(
                new Recipe(6, 
                date("Y-m-d H:i:s"), 
                "Ratatouille", 
                "Deze ratatouille is niet alleen heerlijk, maar ook een visueel aantrekkelijk gerecht. Serveer warm als bijgerecht of hoofdgerecht. Eet smakelijk!", 
                random_int(0,100), ["Maak een kuiltje in de bloem in een kom. Voeg de eieren en een beetje melk toe. Meng dit geleidelijk, voeg steeds meer melk toe tot een glad beslag.",
                "Voeg een snufje zout toe. Naar wens kun je zoete of hartige ingrediënten toevoegen.",
                "Verhit een klontje boter of wat olie in een koekenpan op middelhoog vuur.",
                "Schenk een pollepel beslag in de pan, kantel voor een egale verdeling.",
                "Bak de pannenkoek circa 2 minuten tot de onderkant goudbruin is, keer dan om. Bak de andere kant ook tot goudbruin.",
                "Serveer de pannenkoeken warm. Traditioneel met stroop of poedersuiker, maar voel je vrij om te experimenteren met andere toppings."],
                []),
                [
                    new Ingredient(0,"bloem","",250,"gram"),
                    new Ingredient(0,"eieren","",2,""),
                    new Ingredient(0,"melk","",500,"ml"),
                    new Ingredient(0,"zout","",1,"Snufje"),
                    new Ingredient(0,"boter","",20,"gram")
                ]
            );
        }

        public function populateDatabaseWithTestRecipe(Recipe $newRecipe, array $newIngredients){
            $newRecipeID = $this->addRecipe($newRecipe);
            $newRecipe->setID($newRecipeID);

            foreach ($newIngredients as $ingredient) {
                $newIngredientID = $this->addIngredient($ingredient);
                $ingredient->setID($newIngredientID);
                $this->addIngredientToRecipe($newRecipe,$ingredient);
            }
        }

        private function createDBConnection(): PDO{
            return new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        }

#region database set up
        public function setupDatabase(): void{
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
        
#region create/add entries
        public function addRecipe(Recipe $recipe): int{
            try {
                $recipeTableData = $recipe->getRecipeTableValues();
                $columnHeaders = implode(',',$recipeTableData->headers);
                $columnValues = implode(',',$recipeTableData->values);


                $statement = $this->dbConnection->prepare("INSERT INTO $this->recipeTableName ($columnHeaders)
                VALUES($columnValues)");

                $statement->execute();
                $id = $this->dbConnection->lastInsertId();
                //echo "added new recipe with id:$id<br>";
                return (int)$id;
            } 
            catch (Exception $exception) {
                echo "!exception thrown when adding new recipe<br>".$exception;
                throw $exception;
                echo "show this after exception<br>";
            }
        }

        public function addIngredient(Ingredient $ingredient): int|null{
            try {
                $name = $ingredient->getName();
                //echo "adding $name"."<br>";
                $statement = $this->dbConnection->prepare("SELECT * FROM ingredients WHERE ingredient_name = '$name'");
                if($statement->execute()){
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    if($result){
                        return $result['id'];
                    }
                }

                $tableData = $ingredient->convertToDatabaseFormat();
                $columnHeaders = implode(',',$tableData->headers);
                $columnValues = implode(',',$tableData->values);

                $statement = $this->dbConnection->prepare("INSERT INTO $this->ingredientTableName ($columnHeaders)
                VALUES($columnValues)");
                $statement->execute();

                $id = $this->dbConnection->lastInsertId();
                if(is_numeric($id)){
                    return (int)$id;
                }
                return null;
            } 
            catch (PDOException $pdoException) {
                echo $pdoException;
                return null;
            }
        }

        public function addIngredientToRecipe(Recipe $recipe, Ingredient $ingredient){
            try {
                $tableData = $ingredient->convertToJoinTableFormat();
                array_unshift($tableData->headers,"recipe_id");
                array_unshift($tableData->values,$recipe->getID());
                $columnHeaders = implode(',',$tableData->headers);
                $columnValues = implode(',',$tableData->values);

                $statement = $this->dbConnection->prepare("INSERT INTO $this->joinTableName ($columnHeaders)
                VALUES($columnValues)");
                $statement->execute();
                
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
            $statement = $this->dbConnection->prepare("SELECT * FROM $this->recipeTableName WHERE id = $id");
            $statement->execute();
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            //$data = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
            $recipe = $this->createRecipeObject($data);

            //get recipe id, fetch all ingredient data through the join table, add these to ingredients in the recipe

            $ingredients = $this->getAllIngredientsFromRecipe($id);

            echo "<br>";
            echo count($ingredients);
            echo "<br>";echo "<br>";
            // echo var_dump($ingredients[1]);

            $recipe->setIngredients($ingredients);
            // echo "<br>";echo "<br>";
            // echo var_dump($recipe);
            return $recipe;
        }

        public function getAllRecipes(): array{
            $statement = $this->dbConnection->query("SELECT * FROM recipes");
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            QueryEcho::asTable($data);

            $recipes = [];
            foreach ($data as $row){
                array_push($recipes, $this->createRecipeObject($row));
            }
            return $recipes;
        }

        public function getAllIngredientsFromRecipe($id): array{
            $statement = $this->dbConnection->prepare("SELECT 
            $this->ingredientTableName.id,
            $this->ingredientTableName.ingredient_name,
            $this->ingredientTableName.brief_description,
            $this->joinTableName.amount,
            $this->joinTableName.units
            FROM $this->joinTableName
            RIGHT JOIN $this->ingredientTableName 
            ON $this->joinTableName.ingredient_id = $this->ingredientTableName.id
            WHERE $this->joinTableName.recipe_id = $id");            
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            QueryEcho::asTable($data);

            $ingredients = [];
            foreach ($data as $key => $row) {
                array_push($ingredients, new Ingredient(...array_values($row)));
            }
            return $ingredients;
        }

        private function createRecipeObject(array $data): Recipe{
            $data["instructions"] = json_decode($data["instructions"]); 
            $values = [...array_values($data), []]; //the trailing [] is a placeholder for ingredients
            return new Recipe(...$values);
        }

        // private function  createIngredientObject($data): Ingredient{
        //     $values = [];
        //     foreach($data as $key => $row){
        //             array_push($values, $row); 
        //         }

        //     $ingredient = new Ingredient(...$values);
        //     return $ingredient;
        // }
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

        //note before passing string values these need to be surrounded with ''
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

#test testing database
    //$dbm = new DatabaseManager();
#end region
?>