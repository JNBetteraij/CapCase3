<?php declare(strict_types = 1);

require_once '../classes/RecipeRequester.php';
require_once 'displayComponents/RecipeListDisplay.php';
require_once '../public/displayComponents/FeaturedRecipeDisplay.php';
$displayComponent = new RecipeListDisplay();
$featuredComponent = new FeaturedRecipeDisplay(1);
?>