<?php declare(strict_types = 1);
include_once('../classes/RecipeRequester.php');
    class RecipeDisplayer{

        private RecipeRequester $recipeRequester;
        private int $id;
        private Recipe $recipe;

        public function __construct($id){
            $this->recipeRequester = new RecipeRequester();
            $this->id = $id;
            $this->recipe = $this->getRecipe();
        }
    
        public function getAllRecipes(): array{
            return $this->recipeRequester->requestAllRecipes();
        }

        public function convertRecipeToHTML(){
            $recipe = $this->recipe;
            $replace = ["{id}", "{date}", "{name}", "{description}", "{prepTime}", "{instructions}", "{ingredients}"];
            $values = [
                $recipe->getID(), 
                $recipe->getDate(), 
                $recipe->getName(), 
                $recipe->getDescription(),
                $recipe->getPrepTime(), RecipeDisplayer::convertInstructionsToHTML($recipe->getInstructions()),
                RecipeDisplayer::convertIngredientsToHTML($recipe->getIngredients())
            ];
            $ingr = $recipe->getIngredients();
            foreach ($ingr as $ingredient) {
                echo $ingredient->getName()."<br>";
            }
            //$ingredients = recipeRequester->requestAllIngredientsFromRecipe($recipe->getID());
            // $ingredients = RecipeDisplayer::convertIngredientsToHTML($recipe->getIngredients());
            // array_push($values, $ingredients);
            $template = file_get_contents("displayComponents/recipeLayout.html");
            return str_replace($replace, $values, $template);
        }

        public static function convertInstructionsToHTML(array $instructions){
            $convertedHTML = "";
            $replace = ["{instructions}"];
            $template = file_get_contents("displayComponents/recipeInstruction.html");
            foreach ($instructions as $instruction){
                $convertedHTML .= str_replace($replace, $instruction, $template);
            }
            return $convertedHTML;
        }

        public static function convertIngredientsToHTML(array $ingredients){
            $convertedHTML = "";
            foreach ($ingredients as $ingredient){
                $replace = ["{ingredients}"];
                $template = file_get_contents("displayComponents/recipeIngredient.html");
                $convertedHTML .= str_replace($replace, $ingredient->getName(), $template);
            }
            return $convertedHTML;
        }

        public function getRecipe(): Recipe{
            return $this->recipeRequester->requestRecipeByID($this->id);
        }
    }
?>