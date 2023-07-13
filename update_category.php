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
    && isset($_POST['parent_id'])
   
    
    ){
        require_once('connexion.php');
        echo"hello";
        // nettoyer les données envoyé
        $id = strip_tags($_GET['id']);
        $name = strip_tags($_POST['name']);
        $parent_id = strip_tags($_POST['parent_id']); 
        
        
        $sql= "UPDATE `categories` SET `name`=:name, `parent_id`=:parent_id WHERE `id`=:id;";
        var_dump($sql);
        
        $query = $db ->prepare($sql);
        var_dump($query);
        
        $query ->bindValue(":id", $id);
        $query ->bindValue(":name", $name);
        $query ->bindValue(":parent_id", $parent_id);    
               
        
        
        $toto =$query->execute();
        
        var_dump($toto);
        
        $_SESSION['confirmation'] = "Utilisateur Modifié";
        
        header('Location: category.php');
        
        
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";

    }
}

//Est ce que l'id existe et n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `categories` WHERE `id`= :id;';
    // on prépare la requête
    $query = $db->prepare($sql);
    // on accroche les paramêtre(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    // executer la requête
    $query->execute();
    // on récupère l'utilisateur
    $categories = $query->fetch();
    // verifier si l'utilisateur existe
    if(!$categories){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location:category.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide"; 
    header('location: category.php');
}


?>
<h1>Modifier un rayon</h1>
<form method="post" action="#">


<div class="form-group">  

<label for="name">rayon:</label><br>
<input type="text" name="name" id="name"
value="<?=$categories['name'] ?>">
</div>



<div class="form-group">  
<label for="parent_id">parent_id:</label><br>
<input type="text" name="parent_id" id="parent_id" value="<?=$categories["parent_id"] ?>">
</div>


<input type="hidden" value ="<?= $categories['id']?>">
<div><button class="btn btn-primary" type="submit">Valider</button></div>


<div><button><a href="category.php">Annuler</a></button></div>

</form>





</body>
</html>