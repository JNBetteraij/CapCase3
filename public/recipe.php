<?php declare(strict_types = 1);

$recipeID = "Recipe missing";
if(isset($_POST["selectedRecipe"]))
{
    $recipeID = $_POST["selectedRecipe"]; 
}

if (isset($_GET['id'])) {
    $recipeID = $_GET['id'];
    //echo "Test";
}
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
            <?php echo $recipeID;?>
        </p>
        <a href="http://localhost/CapCase3/public/">terug naar de homepage</a>
    </main>
</body>
</html>