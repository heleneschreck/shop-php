<?php 
include_once "connexion.php";
if(isset($_POST["connection"])){
    if(!empty($_POST["username"])&&(!empty($_POST["password"]))){
        $pseudo_par_defaut = "admin";
        $mdp_par_defaut = "admin1234";

        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $mdp_saisi = htmlspecialchars($_POST['mdp']);

        if($pseudo_saisi == $pseudo_par_defaut && $mdp_saisi == $mdp_par_defaut ){

            header("Location: admin.php/");  }else{
          header("location: index.php/");
        }
    }else{
       echo "Formulaire incomplet";
    }
}
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        
        <link rel="stylesheet" type="text/css" href="signin.css"/>
        <title>connexion base de donnee</title>
    </head>
    <body>
        <form method="POST">
            <input type="text" name="username" autocomplete="off">
            <input type="password" name="password">
            <input type="submit" name ="connection">
        </form>   

    </body>
</html>