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
    if(isset($_POST['username'])
    && isset($_POST['password'])
    && isset($_POST['email'])
    && isset($_POST['admin']) 
    
    ){
        require_once('connexion.php');
        
        // nettoyer les données envoyé
        $id = strip_tags($_GET['id']);
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']); 
        $email = strip_tags($_POST['email']);
        $admin = strip_tags($_POST['admin']);
        
        
        //hasher le mot de passe
        
        $password=crypt ($_POST["password"], 'str');
        
        $sql= "UPDATE `users` SET `username`=:username, `password`=:password, `email`=:email, `admin`=:admin WHERE `id`=:id;";
        var_dump($sql);
        
        $query = $db ->prepare($sql);
        
        
        $query ->bindValue(":id", $id);
        $query ->bindValue(":username", $username, PDO::PARAM_STR);
        $query ->bindValue(":password", $password);    
        $query ->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query ->bindValue(":admin", $admin);
        
        
        
        $toto =$query->execute();
        
       
        
        $_SESSION['confirmation'] = "Utilisateur Modifié";
        
        header('Location: member.php');
        
        
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";

    }
}

//Est ce que l'id existe et n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET['id'])){
    // on nettoie l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `users` WHERE `id`= :id;';
    // on prépare la requête
    $query = $db->prepare($sql);
    // on accroche les paramêtre(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    // executer la requête
    $query->execute();
    // on récupère l'utilisateur
    $users = $query->fetch();
    // verifier si l'utilisateur existe
    if(!$users){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location:member.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide"; 
    header('location: member.php');
}


?>
<h1>Modifier un utilisateur</h1>
<form method="post" action="#">


<div class="form-group">  

<label for="username">pseudo:</label><br>
<input type="text" name="username" id="username"
value="<?=$users['username'] ?>">
</div>



<div class="form-group">  
<label for="email">email:</label><br>
<input type="email" name="email" id="email" value="<?=$users["email"] ?>">
</div>



<div class="form-group">  

<label for="password">password:</label><br>
<input type="password" pattern="(?=^.{4,15}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*\W.*$"title="le mot de passe doit contenir entre 4 et 15 caractères et avoir
au moins un chiffre, une lettre majuscule, une lettre minuscule
et un caractère d'un autre type (ponctuation, contrôle...)"
name="password" id="password" value="<?=$users["password"] ?>"> 
</div>

<div class="form-group">  
<label for="admin">utilisateur/administrateur?</label>
<select name="admin" id ="admin" value="<?=$users["admin"]?>">
<option value="0">0</option>
<option value="1">1</option>
</select>

</div>
<input type="hidden" value ="<?= $users['id']?>">
<div><button class="btn btn-primary" type="submit">Valider</button></div>


<div><button><a href="member.php">Annuler</a></button></div>

</form>





</body>
</html>