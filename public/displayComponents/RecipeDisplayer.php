<?php declare(strict_types = 1);
include_once('../classes/RecipeRequester.php');
    class RecipeDisplayer{

        private RecipeRequester $recipeRequester;
        private array $recipes;

        public function __construct(){
            $this->recipeRequester = new RecipeRequester();
            $this->recipes = $this->getAllRecipes();
        }
    
        public function getAllRecipes(): array{
            return $this->recipeRequester->requestAllRecipes();
        }

        public static function convertRecipeToHTML(Recipe $recipe){
            $replace = ["{id}", "{date}", "{name}", "{description}", "{prepTime}", "{instructions}", "{ingredients}"];
            $values = [
                $recipe->getID(), 
                $recipe->getDate(), 
                $recipe->getName(), 
                $recipe->getDescription(),
                $recipe->getPrepTime(), RecipeDisplayer::convertInstructionsToHTML($recipe->getInstructions()),
                RecipeDisplayer::convertIngredientsToHTML($recipe->getIngredients())
            ];
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
    }
?>