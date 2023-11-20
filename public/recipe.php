<?php declare(strict_types = 1);

include '../classes/RecipeRequester.php';
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
        Tijd voor recept
        <p>
            <?php
            if(!empty($_GET["recipe"]))
                {
                    $recipeID = $_GET["recipe"];
                    $retrievedRecipe = $recipeRequester->requestRecipeByID("$recipeID");
                    echo $retrievedRecipe->getInstructions();
                    $_GET["recipe"] = "";
                }
            
            ?>
        </p>
        <a href="index.php">terug naar de homepage</a>
    </main>
</body>
</html>