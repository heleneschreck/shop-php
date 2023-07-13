<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Détails User</title>
</head>
<body>
<?php
// demarrer la session
require_once "connexion.php";
session_start();

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
    $_SESSION['erreur'] = "URL  invalide"; 
    header('location: member.php');
}
?>
<main class="containeur">
    <div class="row">
        <section class="col-12">
            <h1>Détail de l'utilisateur <?=$users['username']?></h1>
            
            <p>ID : <?=$users['id'] ?></p>
            <p>username : <?=$users['username'] ?></p>
            <p>password : <?=$users['password'] ?></p>
            <p>email : <?=$users['email'] ?></p>
            <p><a href="member.php">Retour au tableau complet</a></p>
            <p><a href="update.php?id=<?=$users['id'] ?>">Modifier</a>   </p>


        
        
        
        </section>
    </div>
</main>



</body>
</html>