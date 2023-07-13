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
    if(isset($_POST['username']) && !empty($_POST['username'])
    && isset($_POST['password']) && !empty($_POST['password'])
    && isset($_POST['email']) && !empty($_POST['email'])){
        require_once('connexion.php');
        
        // nettoyer les données envoyé
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']); 
        $email = strip_tags($_POST['email']);

          //hasher le mot de passe
        
        $password=crypt ($_POST["password"], 'str');
        
        $sql= "INSERT INTO `users`(`id`, `username`, `password`, `email`, `admin`) VALUES (NULL, :username, :password, :email, :admin)";
        var_dump($sql);

        $query = $db ->prepare($sql);
        var_dump($query);
        $query ->bindValue(":username", $username, PDO::PARAM_STR);
        $query ->bindValue(":password", $password);    
        $query ->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query ->bindValue(":admin", 0);
        
       
        
       $toto =$query->execute();

       var_dump($toto);
        
        $_SESSION['confirmation'] = "Utilisateur ajouté";
     
        header('Location: member.php');
        
        
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
<h1>Ajouter un utilisateur</h1>
<form method="post">
<div class="form-group">
<label for="username">username :</label></br>
<input type="text" id="username" name="username" class="form-control">
</div>
<div class="form-group">
<label for="password">password :</label></br>
<input type="password" pattern="(?=^.{4,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*\W.*$"title="le mot de passe doit contenir entre 4 et 15 caractères et avoir
au moins un chiffre, une lettre majuscule, une lettre minuscule
et un caractère d'un autre type (ponctuation, contrôle...)" id="password" name="password" class="form-control">
</div>
<div class="form-group">
<label for="email">email :</label></br>
<input type="mail" id="email" name="email" class="form-control">
</div>

<button class="btn btn-primary">Créer</button>
</form>
</section>
</div>
</main><br>

<div><button ><a href="member.php">Annuler</a></button></div>







</body>
</html>
