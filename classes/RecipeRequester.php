<?php declare(strict_types = 1);

include_once("../database/databaseManager.php");
class RecipeRequester {

    private DatabaseManager $databaseManager;

    public function __construct(){
        $this->databaseManager = new DatabaseManager();
    }

    public function requestRecipeByID(string $id): Recipe{
        return $this->databaseManager->getRecipe($id);
    }
}

?>