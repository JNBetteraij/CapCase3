<?php declare(strict_types = 1);

include_once("../database/databaseManager.php");
class RecipeRequester {

    private DatabaseManager $databaseManager;

    public function __construct(){
        $this->databaseManager = new DatabaseManager();
    }

    public function requestRecipeByID(int $id): Recipe{
        return $this->databaseManager->getRecipe($id);
    }

    public function requestAllRecipes(): array{
        return $this->databaseManager->getAllRecipes();
    }
}

?>