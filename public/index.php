<?php declare(strict_types = 1);

include_once 'displayComponents/displayRecipeList.php';
include_once '../classes/RecipeRequester.php';
$recipeRequester = new RecipeRequester();
$recipeDisplayer = new RecipeDisplayer();
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
            Ons lekkere kookboek
        </h1>
    </header>
    <main>
        <?php $recipeDisplayer->displayRecipeList();?>
    </main>
</body>
</html>

<?php