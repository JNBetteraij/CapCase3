<?php declare(strict_types = 1);
    
class FeaturedRecipeDisplay{
    private RecipeRequester $recipeRequester;
    private int $recipeID;

    public function __construct(int $recipeID){
        $this->recipeRequester = new RecipeRequester();
        $this->recipeID = $recipeID;
    }

    public function displayFeaturedRecipe(){
        $recipe = $this->getRecipe($this->recipeID);
        if(!$recipe){
            return;
        }

        $replace = [
            "{id}",
            "{name}",
            "{description}",
            "{prepTime}"];
        $values = [
            $recipe->getID(),
            $recipe->getName(),
            $recipe->getDescription(),
            $recipe->getPrepTime()];
        $template = file_get_contents("displayComponents/featuredRecipe.html");
        echo str_replace($replace, $values, $template);
    }

    public function getRecipe(int $id): Recipe|false{
        try{
            return $this->recipeRequester->requestRecipeByID($id);
        }
        catch(Exception $e){
            return false;
        }
    }
}
?>