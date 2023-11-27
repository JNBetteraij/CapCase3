<?php declare(strict_types = 1);
    
class RecipeListDisplay{
    private RecipeRequester $recipeRequester;

    public function __construct(){
        $this->recipeRequester = new RecipeRequester();
    }

    public function displayRecipeList(){
        $replace = ["{thumbnails}","{thumbnailGrid}"];
        $values = [implode("",$this->getThumbnailElements()),""];
        $template = file_get_contents("displayComponents/recipeList.html");
        echo str_replace($replace, $values, $template);
    }

    private function getThumbnailElements(int $maxAmount = INF, int $startIndex = 0): array{
        $elements = [];

        $recipes = $this->getAllRecipes();

        if($startIndex > 0){
            $recipes = array_slice($recipes,$startIndex, $maxAmount+$startIndex);
        }

        foreach ($recipes as $recipe){
            $newElement = $this->convertRecipeToThumbnailElement($recipe);
            array_push($elements, $newElement);
        }

        echo "we cool?";
        
        return $elements;
    }

    public function getAllRecipes(): array{
        return $this->recipeRequester->requestAllRecipes();
    }

    private function convertRecipeToThumbnailElement(Recipe $recipe): string{
        $replace = ["{id}"];
        $value = [$recipe->getID()];

        $template = file_get_contents("displayComponents/recipeThumbnail.html");
        return str_replace($replace, $value, $template);
    }
}
?>