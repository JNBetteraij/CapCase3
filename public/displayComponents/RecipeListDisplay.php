<?php declare(strict_types = 1);
    
class RecipeListDisplay{
    private RecipeRequester $recipeRequester;
    private int $displayAmount;
    private int $startIndex;

    public function __construct(int $displayAmount = PHP_INT_MAX, int $startIndex = 0){
        $this->displayAmount = $displayAmount;
        $this->startIndex = $startIndex;
        $this->recipeRequester = new RecipeRequester();
    }

    public function displayRecipeList(){
        $replace = ["{thumbnails}","{thumbnailGrid}"];
        $values = [implode("",$this->getThumbnailElements()),""];
        $template = file_get_contents("displayComponents/recipeList.html");
        echo str_replace($replace, $values, $template);
    }

    private function getThumbnailElements(): array{
        $elements = [];

        $recipes = $this->getRecipes($this->displayAmount, $this->startIndex);

        foreach ($recipes as $recipe){
            $newElement = $this->convertRecipeToThumbnailElement($recipe);
            array_push($elements, $newElement);
        }
        
        return $elements;
    }

    public function getRecipes(int $maxAmount = PHP_INT_MAX, int $startIndex = 0): array{
        $recipes = $this->getAllRecipes();

        if($startIndex > 0){
            $recipes = array_slice($recipes,$startIndex, $maxAmount+$startIndex);
        }
        return $recipes;
    }

    public function getAllRecipes(): array{
        return $this->recipeRequester->requestAllRecipes();
    }

    private function convertRecipeToThumbnailElement(Recipe $recipe): string{
        $replace = ["{name}","{id}"];
        $value = [$recipe->getName(),$recipe->getID()];

        $template = file_get_contents("displayComponents/recipeThumbnail.html");
        return str_replace($replace, $value, $template);
    }
}
?>