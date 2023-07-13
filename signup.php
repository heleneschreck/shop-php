<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>formulaire d'inscription</title>
</head>
<body>
<?php

// connexion BDD
include "connexion.php";


// verifier si le formulaire est envoyé
if(!empty($_POST)){
    // le formulaire est envoyé!
    // Verifier que tous champs sont remplis
    if(isset($_POST["username"], $_POST["email"], $_POST["password"])
    && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])
    
    ){
        //Le formulaire est complet 
        // Récuperer les donnés et les proteger
        $pseudo = strip_tags($_POST["username"]);
        // verifier si l'email en est un
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            die("adresse email incorrecte");
        }
        // Verifier que les deux pass sont identique
        if ( $_POST['password2'] != $_POST['password'] )
        {
            die("Les 2 mots de passe sont différents");            
        }
        
        //hasher le mot de passe
        
        $pass=crypt ($_POST["password"], 'str');
        
        
        
        // Verifier si l'utilisateur existe deja
        $sql = "SELECT * FROM `users` WHERE username = :username";
        $query = $db ->prepare($sql);
        $query ->bindValue(":username", $pseudo, PDO::PARAM_STR);
        $resolt= $query ->execute();
        $users = $query->fetch();
        
        
        if ($users)
        {
            die("utilisateur deja enregistrer");
        }
        // ajouts de controles souhaités
        
        
        $sql= "INSERT INTO `users`(`id`, `username`, `password`, `email`, `admin`) VALUES (NULL, :username, :password, :email, :admin)";
        
        $query = $db ->prepare($sql);
        var_dump($pseudo, $_POST["email"], $pass);
        $query ->bindValue(":username", $pseudo, PDO::PARAM_STR);
        $query ->bindValue(":password", $pass);    
        $query ->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query ->bindValue(":admin", 0);
        
        
        $toto = $query ->execute(); 
        // recuperer Id du nouvel utilisateur
        $id = $db->lastInsertId();
        
        //connecter l'utilisateur
        
        $sql = "SELECT `admin` FROM `users` WHERE username= :username";

        $query = $db ->prepare($sql);
    
        $query ->bindValue(":username", $_POST["username"]);
    
        $toto= $query ->execute();
        var_dump($toto);
        
        $user = $query->fetch();
        var_dump($user);
    
        if($user["admin"]){
          $_SESSION["users"]= 1;
          header("Location: admin.php");
        }else{
          header("location: index.php");
        }
        
        
  
        
        
    }else{
        die("Le formulaire est incomplet");
    }
    
    
    
    
}


?>


<h1>Inscription</h1> 
<form method="post">
<fieldset>
<div>
<label for="pseudo">pseudo:</label><br>
<input type="text" name="username" id="pseudo">
</div>

<div>   
<label for="email">email:</label><br>
<input type="email" name="email" id="email">
</div>
<!--  -->

<div>
<label for="pass">password:</label><br>
<input type="password" pattern="(?=^.{4,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*\W.*$"title="le mot de passe doit contenir entre 4 et 15 caractères et avoir
au moins un chiffre, une lettre majuscule, une lettre minuscule
et un caractère d'un autre type (ponctuation, contrôle...)"
name="password" id="pass"> 
</div>

<div>
<label for="pass2">confirmation password:</label><br>
<input type="password" name="password2" id="pass">
</div>

<div> <button type="submit">M'inscrire</button></div>

<p><div><a href="signin.php"> Already users?</a></div>   </p>

</fieldset>


</form>


</body>
</html>