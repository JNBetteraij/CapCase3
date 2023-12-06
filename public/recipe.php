<?php declare(strict_types = 1);

include_once '../classes/RecipeRequester.php';
include_once 'displayComponents/RecipeDisplayer.php';
require_once '../classes/Sanitize.php';

$displayHTML = "Not a valid recipe ID.";
if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
    $displayHTML = "Not a valid recipe ID.";
}
else{
    //cheated a bit, by hardcoding the max, get this by getting all recipes and get a count
    if((int)$_GET["id"] <= 6){
        $recipeID = (int)Sanitize::stringInput($_GET["id"]);
        $_GET["id"] = "";
        $recipeDisplayer = new RecipeDisplayer($recipeID);

        $displayHTML = $recipeDisplayer->convertRecipeToHTML();
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../public/index.css" rel="stylesheet">
    <link href="../public/style.css" rel="stylesheet">
</head>
<body>
    <?php include("displayComponents/header.html");?>
    <main style="max-width: 80%; margin-left: auto; margin-right: auto">
        <p>
            <?php echo $displayHTML; ?>
        </p>
        <a href="index.php" class="btn btn-secondary">Terug naar de homepage</a>
    </main>
    <?php include("displayComponents/footer.html");?>
</body>
</html>