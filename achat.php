<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="achat.css"/>
<title>Détails User</title>

</head>
<body>
<?php
require_once "connexion.php";
session_start();
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
    // var_dump($products);
    
// nav

$sql = 'SELECT * FROM `categories`';
// on prépare la requête
$query = $db->prepare($sql);


// executer la requête
$query->execute();

// on récupère l'utilisateur
$resolt = $query->fetchAll();




// verifier si l'utilisateur existe
    if(!$users){
        
        header('Location: index.php');
    }
    }else{
         
        header('location: index.php');
}
?>
<nav class="navbar navbar-expand-lg bg-light ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="logo.png" alt="logo"/> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><a href="signin.php">deconnexion</a></a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link" href="#">Mon panier</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Rayon
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php foreach($resolt as $categories) {?><li><a class="dropdown-item" href="rayon.php?id=<?=$categories['id'] ?>"><?= $categories['name'];}  ?></a></li>
         
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link "><label for= "prix:"></label>Trier par prix :  <input type="range" name="prix" id="prix" min="0" max="100000" /> </br></a>
        </li>
     

      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<p><a href="index.php">Page principale</a></p>
    <!-- produit -->
   <div class="flex">
    <div class="card" style="width: 50%;">
  <img src="1.png" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?=$products['name']   ?></h5>
    <p class="card-text"><?=$products['resume']     ?></p>
  </div>

  <div class="card-body">
    <a href="#" class="card-link"><?=$products['price'] ?> € <br></a>
    <a href="index.php" class="retour"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
</svg></a>
  </div>
</div>
<?php
$nbpaiementCredit = 4;
$PrixComptant= $products['price'];
// var_dump($PrixComptant);
$paiementCredit = ($PrixComptant / $nbpaiementCredit);
// var_dump($paiementCredit);

?>
<div class="infos">
<h1><?=$products['price']?> €</h1>
<p>Regler au comptant ou en 4X CB (<?=$paiementCredit?> €) </br>
<a href=""> Regler en 4 fois ?</a> </p>
<p><label for="disponibilité">Commande : </label>
<input type="number" name="disponibilité"  /> </p>
<button><a href="#">Ajouter au panier </a>   </button>
<h4>Livraion</h4>
<ul>disponibilité :
<li>Livraison sous 7 jours -> Gratuit </li> 
<li>Livraison en point relais</li>
<li>Livraion à domicile</li>
<li>Livraion express -> 24,90€ </li>
</ul>

<h4>Service complémentaires</h4>
<p>Reprise gratuite de votre ancien appareil <br>
Montage et installation<br>
Retour sous 14 jours <br> </p>

<h4>Garantit légale et extension</h4>
<p> Garantie: 2ans gratuite <br>
Extension de Garantie (3 ans supplémentaires)-> 99,99€ </p>
</div>
</div>
<h4>Vous aimerez aussi :</h4> 
<div class="voir">

<?php
$Voir = $products['category_id'];
// var_dump($Voir);
$affiche= 'SELECT * FROM `products` WHERE `category_id` = :voir LIMIT 4';
$query = $db->prepare($affiche);
$query->bindValue(':voir', $Voir);
$query->execute();
// var_dump($query);

$voirAussi = $query->fetchAll(PDO::FETCH_ASSOC);
// var_dump($voirAussi);

foreach ($voirAussi as $product){
?>
<div class="card voir" style="width: 20%;">
  <img src="1.png" class="card-img-top voir" alt="...">
  <div class="card-body voir">
    <h6 class="card-title voir"><?= $product['name'];?></h6>
    <a href="achat.php?id=<?=$products['id'] ?>" class=" primary voir"><?=$product['price'] ;?> €</a>
  </div>
</div>
<?php
}
?>
</div>





</body>
</html>