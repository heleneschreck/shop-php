<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="member.css"/>
<title>interface administrateur</title>
</head>
<body>
<?php


session_start();
if($_POST){
    //   les informations sont fournies et envoyés
    if(isset($_POST['name']) && !empty($_POST['name'])
    && isset($_POST['price']) && !empty($_POST['price'])
    && isset($_POST['resume']) && !empty($_POST['resume'])
    && isset($_POST['category_id']) && !empty($_POST['category_id'])
    && isset($_POST['photo']) && !empty($_POST['photo'])

    ){
        require_once('connexion.php');
        
        // nettoyer les données envoyé
        $name = strip_tags($_POST['name']);
        $price = strip_tags($_POST['price']); 
        $resume = strip_tags($_POST['resume']);
        $category_id = strip_tags($_POST['category_id']);
        $photo = strip_tags($_POST['photo']);

        $sql= "INSERT INTO `products`(`id`, `name`, `price`, `resume`, `category_id`, `photo`) VALUES (NULL, :name, :price, :resume, :category_id, :photo)";
  

        $query = $db ->prepare($sql);
       
        $query ->bindValue(":name", $name);
        $query ->bindValue(":price", $price);    
        $query ->bindValue(":resume", $resume);
        $query ->bindValue(":category_id", $category_id);
        $query ->bindValue(":photo", $photo);
       
        
       $toto =$query->execute();


        
        $_SESSION['confirmation'] = "Utilisateur ajouté";
     
        header('Location: product.php');
        
        
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}



?>

<main class="container">
<div class="row">
<section class="col-12">
<?php
if (!empty($_SESSION['erreur'])){
    echo'<div class="alert alert-danger" role="alert">
    '. $_SESSION['erreur'].'
    </div>';
    $_SESSION['erreur'] = "";
}
?>
<h1>Ajouter un produit</h1>
<form method="post">
<div class="form-group">
<label for="name">produit :</label></br>
<input type="text" id="name" name="name" class="form-control">
</div>
<div class="form-group">
<label for="price">prix :</label></br>
<input type="number" name="price" class="form-control">
</div>
<div class="form-group">
<label for="resume">Description du produit :</label></br>
<input type="text" id="resume"  name="resume"  class="form-control">
</div>
<div class="form-group">
<label for="category_id">Rayon :</label></br>
<input type="text" id="category_id" name="category_id" class="form-control">
</div>
<div class="form-group">
<label for="photo">Photo :</label></br>
<input type="text" id="photo" name="photo" class="form-control">
</div>

<button class="btn btn-primary">Créer</button>
</form>
</section>
</div>
</main><br>

<div><button ><a href="member.php">Annuler</a></button></div>







</body>
</html>