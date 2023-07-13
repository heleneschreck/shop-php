<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
     <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>formulaire de connexion</title>
</head>
<body>
<?php 
session_start();
  // Verifier si le formulaire est envoyé
if(!empty($_POST)){
  // Le formulaire à été envoyé
  // Vérifier que tous les champs requis sont remplis
  
  if(isset($_POST["username"], $_POST["password"])
  && !empty($_POST["username"] && !empty($_POST["password"]))
  ){
    // est ce que l'utilisateur existe
    require_once "connexion.php";
    $sql = "SELECT * FROM `users` WHERE username = :username";
    
    $query = $db->prepare($sql);
    
    $query ->bindValue(":username", $_POST["username"]);
    
    $query ->execute();
    
    $users = $query->fetch();
    
    if ($users["password"]==crypt($_POST["password"],"str")){
      setcookie("user_name",$_POST["username"], time() + (86400 * 30));//86400=1jour
     
    }
    else{
      die ("utilisateur ou mot de passe incorrecte");
    }

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
    
    
    
    
    
    
  }
}
?>
<h1>Connexion</h1> 
<form method="post">
<fieldset>
<div>
<label for="pseudo">pseudo:</label><br>
<input type="text" name="username" id="pseudo">
</div>

<div>
<label for="pass">password:</label><br>
<input type="password" name="password" id="pass">
</div>

<div><button type="submit">Me connecter</button></div>

<p><div><a href="signup.php"> Not yet user?</a> </div>  </p>


</fieldset>


</form>

</body>
</html> 