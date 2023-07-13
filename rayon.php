<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> 
<link rel="stylesheet" type="text/css" href="index.css"/>
<title>Détails User</title>

</head>
<body>
<?php
// determiner sur quelle page on est 
if(isset($_GET['page']) && !empty($_GET['page'])){
$currentPage =(int)strip_tags($_GET['page']);
}else{
  $currentPage = 1;
}


// demarrer la session
require_once "connexion.php";
session_start();
// détermine le nombre d'articles
$sql="SELECT COUNT(*) AS nb_products FROM `products`";
// execution de la requète
$query = $db->query($sql);

// recuperation du nombre d'articles
$page = $query->fetch();

$nbProducts = (int) $page['nb_products'];

// determiner le nombre de produits par page:
$parPage = 8;

//calcule de nombre de page total
$prodPage = ceil($nbProducts / $parPage);

// Calcul du premier article de la page

$premier = ($currentPage * $parPage ) - $parPage;

// récupération de la liste des utilisateur(users)
$sql= "SELECT * FROM `products` ORDER BY `category_id` DESC LIMIT :premier, :parpage";

// preparer la requête
$query = $db->prepare($sql);

$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);


// execution de la requète
$query->execute();

// recuperation avec fetch
$result = $query->fetchAll(PDO::FETCH_ASSOC);


// nav

$sql = 'SELECT * FROM `categories`';
// on prépare la requête
$query = $db->prepare($sql);


// executer la requête
$query->execute();

// on récupère l'utilisateur
$resolt = $query->fetchAll();

// afficher les produits correspondants au rayon

$rayon= "SELECT `category_id` FROM `products`";
// preparer la requête
$query = $db->prepare($rayon);

$query->execute();

$resultRayon = $query->fetchAll(PDO::FETCH_ASSOC);

$Pid = $_GET['id'];


$affiche= "SELECT * FROM `products` WHERE `category_id` = :pid";
$query = $db->prepare($affiche);
$query->bindValue(':pid', $Pid);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_ASSOC);

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

<?php
$i = 1;
foreach($result as $products) {
    ?>
<div class="card" >
  <img src="<?php echo $i.'.png';?>" class="card-img-top" alt="machine">
  <div class="card-body">
    <h1 class="card-title"><?=$products['name']?></h1>
    <a href="achat.php?id=<?=$products['id']?>" class="btn btn-primary stretched-link"><?=$products['price']?> €</a>
  </div>
</div>



 <?php 
 $i++;
   if ($i > 20)
   {
    $i = 1;
   }
}
      
?>
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item <?= ($currentPage== 1) ? "disabled" : "" ?>">
    <a href="./?page=<?= $currentPage - 1?>" class="page-link"  
    class="page-link">Previous</a>
    </li>
    <?php
  for($page = 1; $page<= $prodPage; $page++){
    ?>
    <li class="page-item <?= ($currentPage== $page) ? 
      "active" : "" ?>">
      <a class="page-link" href="./?page=<?= $page ?>"> <?= $page ?></a>
      </li>
   <?php
  }
   ?>
    <li class="page-item <?= ($currentPage== $prodPage) ? 
      "disabled" : "" ?>">
      <a href="./?page=<?= $currentPage + 1 ?>" class="page-link" >Next</a>
    </li>
  </ul>
</nav>


</body>
</html>