<?php
require_once "connexion.php";
session_start();

?>
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

// récupération de la liste des utilisateur(users)
$sql= "SELECT * FROM `products` ORDER BY `category_id` ASC";

// execution de la requète
$query = $db->query($sql);



// recuperation avec fetch
$result = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
if (!empty($_SESSION['erreur'])){
echo'<div class="alert alert-danger" role="alert">
  '. $_SESSION['erreur'].'
</div>';
$_SESSION['erreur'] = "";
}
if (!empty($_SESSION['confirmation'])){
  echo'<div class="alert alert-success" role="alert">
    '. $_SESSION['confirmation'].'
  </div>';
  $_SESSION['confirmation'] = "";
  }

if (!empty($_SESSION['message'])){
  echo'<div class="alert alert-success" role="alert">
    '. $_SESSION['message'].'
  </div>';
  $_SESSION['message'] = "";
  }
?>



<h1>Liste des produits</h1>
<table class="table">
<thead>
<th>ID :</th>
<th>name :</th>
<th>price :</th>
<th>Détails :</th>
<th>Rayon :</th>
<th>photo :</th>
</thead>
<tbody>
<?php

foreach($result as $products) {
    ?>
    <tr>
    <td><?= $products['id']?></td>
    <td><?=$products['name']?></td>
    <td><?=$products['price'] ?>€</td>
    <td><?=$products['resume']?></td>
    <td><?=$products['category_id']?></td>    
    <td><?=$products['photo']?></td>
    <td><button><a href="details_product.php?id=<?= $products['id'] ?>">Voir <br> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></a></button></td>
    <td><button><a href="update_product.php?id=<?= $products['id']?>">Modifier <br> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
</svg> </a></button></td>
    <td><button><a href="bannir_product.php?id=<?= $products['id']?>">Supprimer <br> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
</svg> </a></button> </td>
    </tr>
    </tbody>
    
    
    
    
    <?php
}

?> 
<p><button> <a href="add_product.php">Ajouter un produit <br> 
  </a></button>

<button> <a href="admin.php">Retour à la page principale <br> </a></button></p>










</body>
</html>
