<?php declare(strict_types = 1);

include_once '../classes/RecipeRequester.php';
include_once 'displayComponents/RecipeDisplayer.php';

$recipeRequester = new RecipeRequester();

$recipeID = "Recipe missing";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receptenboek</title>   
</title>
</head>
<body>
    <header>
        <h1>
            Recept Pagina
        </h1>
    </header>
    <main>
        <p>
            <?php
            if(!empty($_GET["recipe"]))
                {
                    $recipeID = (int)$_GET["recipe"]; //Dit moet nog gevalideerd worden!
                    $retrievedRecipe = $recipeRequester->requestRecipeByID($recipeID);
                    //echo $retrievedRecipe->getInstructions();
                    echo RecipeDisplayer::convertRecipeToHTML($retrievedRecipe);
                    $_GET["recipe"] = "";
                }
            
            ?>

            <br>

            <?php
                // $recipes = $recipeRequester->requestAllRecipes();
                // foreach ($recipes as $recipe){
                //     echo $recipe->getID() . "<br>";
                // }
            ?>
        </p>
        <a href="index.php">Terug naar de homepage</a>
    </main>
</body>
</html>