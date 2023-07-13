<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Modifier un utilisateur</title>
</head>
<body>
<?php

session_start();
require_once "connexion.php";

if($_POST){
    //   les informations sont fournies et envoyé
    if(isset($_POST['name'])
    && isset($_POST['price'])
    && isset($_POST['resume'])
    && isset($_POST['category_id']) 
    
    ){
        require_once('connexion.php');
        
        // nettoyer les données envoyé
        $id = strip_tags($_GET['id']);
        $name = strip_tags($_POST['name']);
        $price = strip_tags($_POST['price']); 
        $resume = strip_tags($_POST['resume']);
        $category_id = strip_tags($_POST['category_id']);
        
        
        $sql= "UPDATE `products` SET `name`=:name, `price`=:price, `resume`=:resume, `category_id`=:category_id WHERE `id`=:id;";
        
        
        $query = $db ->prepare($sql);
        
        
        $query ->bindValue(":id", $id);
        $query ->bindValue(":name", $name);
        $query ->bindValue(":price", $price);    
        $query ->bindValue(":resume", $resume);
        $query ->bindValue(":category_id", $category_id);
        
        
        
        $toto =$query->execute();
        
        
        
        $_SESSION['confirmation'] = "Utilisateur Modifié";
        
        header('Location: product.php');
        
        
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";

    }
}

//Est ce que l'id existe et n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `products` WHERE `id`= :id;';
    // on prépare la requête
    $query = $db->prepare($sql);
    // on accroche les paramêtre(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    // executer la requête
    $query->execute();
    // on récupère l'utilisateur
    $products = $query->fetch();
    // verifier si l'utilisateur existe
    if(!$products){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: product.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide"; 
    header('location: product.php');
}


?>
<h1>Modifier un utilisateur</h1>
<form method="post" action="#">


<div class="form-group">  

<label for="name">produit:</label><br>
<input type="text" name="name" id="name"
value="<?=$products['name'] ?>">
</div>



<div class="form-group">  
<label for="price">prix:</label><br>
<input type="number" name="price" id="price" value="<?=$products["price"] ?>">
</div>



<div class="form-group">  

<label for="resume">caracteristique:</label><br>
<input type="text" name="resume" id="resume" value="<?=$products["resume"] ?>"> 
</div>

<div class="form-group">  
<label for="category_id">Rayons</label><br>
<input type="text" name="category_id" id ="category_id" value="<?=$products["category_id"]?>">

</div>
<input type="hidden" value ="<?= $products['id']?>">
<div><button class="btn btn-primary" type="submit">Valider</button></div>


<div><button><a href="product.php">Annuler</a></button></div>

</form>

</body>
</html>