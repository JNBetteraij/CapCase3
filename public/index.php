<?php declare(strict_types = 1);

require 'indexClasses.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receptenboek</title>   
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="../public/index.css" rel="stylesheet">
<link href="../public/style.css" rel="stylesheet">

</head>
<body>
    <?php include("displayComponents/header.html");?>
    <?php $smallList = new RecipeListDisplay();
    $smallList->displayRecipeList(3);
    ?>
    <?php include("displayComponents/footer.html");?>
</body>
</html>