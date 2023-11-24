<?php declare(strict_types = 1);
include_once('../classes/RecipeRequester.php');
    class RecipeDisplayer{

        private RecipeRequester $recipeRequester;
        private array $recipes;

        public function __construct(){
            $this->recipeRequester = new RecipeRequester();
            $this->recipes = $this->getAllRecipes();
        }

        public function displayRecipeList(){
            //$replace = ["{thumbnails}"];
            $recipes = $this->recipes;
            $convertedValues = "";
            foreach ($recipes as $recipe){
                $convertedValues .= $this->convertRecipeToThumbnail($recipe);
            }
            //echo var_dump($values);
            return $convertedValues;
            
            //$template = file_get_contents("displayComponents/recipeList.html");
            //echo str_replace($replace, $values, $template);
        }
    
        public function getAllRecipes(): array{
                // global $exampleArray;
            
                // $recipies = $exampleArray;
                // $thumbnails = [];
            
                // for ($i = 0; $i < count($recipies); $i++){
                //     $value = $recipies[$i];
                //     // echo $recipies[$i];
                //     // echo $i;
                //     array_push($thumbnails, getThumbnailElement($value));
                // }
                
                // return implode("", $thumbnails);
                // //return implode("",["<li>",implode("</li> <li>", $thumbnails),"</li>"]);
            return $this->recipeRequester->requestAllRecipes();
        }

        private function convertRecipeToThumbnail(Recipe $recipe){

            $replace = ["{id}"];
            $value = [$recipe->getID()];

            $template = file_get_contents("displayComponents/recipeThumbnail.html");
            return str_replace($replace, $value, $template);
        }

        public static function convertRecipeToHTML(Recipe $recipe){
            //private string $id;
            //private string $date;
            //private string $name;
            //private string $description;
            //private int $prepTime;
            //private string $instructions;
            //private array $ingredients;

            $replace = ["{id}", "{date}", "{name}", "{description}", "{prepTime}", "{instructions}, {ingredients}"];
            $values = [$recipe->getID(), $recipe->getDate(), $recipe->getName(), $recipe->getDescription(),
            $recipe->getPrepTime(), RecipeDisplayer::convertInstructionsToHTML($recipe->getInstructions())];

            $template = file_get_contents("displayComponents/recipeLayout.html");
            return str_replace($replace, $values, $template);
        }

        public static function convertInstructionsToHTML(string $instructions){
            $replace = ["{instructions}"];
            $values = [$instructions];

            $template = file_get_contents("displayComponents/recipeInstruction.html");
            return str_replace($replace, $values, $template);
        }

        public static function convertIngredientsToHTML(array $ingredients){
            $convertedIngredients = ""; 
            foreach ($ingredients as $ingredients){
                $replace = ["{instructions}"];
                $values = [$instructions];

                $template = file_get_contents("displayComponents/recipeIngredient.html");
                $convertedIngredients += str_replace($replace, $values, $template);
            }
            return $convertedIngredients;
        }
        
        public function getThumbnailElement(int $id): string{
        
            $replace = ["{id}"];
            $values = ["$id"];
        
            $template = file_get_contents("displayComponents/recipeThumbnail.html");
            return str_replace($replace, $values, $template);
        }
    }
?>