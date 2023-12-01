<?php declare(strict_types = 1);

include_once '../classes/RecipeRequester.php';
include_once 'displayComponents/RecipeDisplayer.php';

$recipeRequester = new RecipeRequester();

$recipeID = "Recipe missing";
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receptenboek</title>   
</title>
</head>
<body>
    <?php include("displayComponents/header.html");?>
    <main style="max-width: 80%; margin-left: auto; margin-right: auto">
        <p>
            <?php

            function sanitizeInput(string $data): string 
            {   
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);   
                return $data; 
            }

            if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                echo "Not a valid recipe ID.";
            }
            else{
                $recipeID = (int)sanitizeInput($_GET["id"]); //Dit moet nog gevalideerd worden!
                $retrievedRecipe = $recipeRequester->requestRecipeByID($recipeID);
                //echo $retrievedRecipe->getInstructions();
                echo RecipeDisplayer::convertRecipeToHTML($retrievedRecipe);
                $_GET["id"] = "";
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