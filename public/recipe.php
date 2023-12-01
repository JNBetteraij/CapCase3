<?php declare(strict_types = 1);

include_once '../classes/RecipeRequester.php';
include_once 'displayComponents/RecipeDisplayer.php';
require_once '../classes/Sanitize.php';

$displayHTML = "Not a valid recipe ID.";
if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
    
}
else{
    $recipeID = (int)Sanitize::stringInput($_GET["id"]);
    $_GET["id"] = "";
    $recipeDisplayer = new RecipeDisplayer($recipeID);
    
    $displayHTML = $recipeDisplayer->convertRecipeToHTML();
}

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
            <?php echo $displayHTML; ?>
        </p>
        <a href="index.php">Terug naar de homepage</a>
    </main>
</body>
</html>