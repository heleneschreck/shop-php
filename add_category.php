<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="member.css" />
    <title>interface administrateur</title>
</head>

<body>
    <?php


    session_start();
    if ($_POST) {
        //   les informations sont fournies et envoyés
        if (
            isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['parent_id']) && !empty($_POST['parent_id'])
        ) {
            require_once('connexion.php');

            // nettoyer les données envoyé
            $name = strip_tags($_POST['name']);
            $parent_id = strip_tags($_POST['parent_id']);




            $sql = "INSERT INTO `categories`(`id`, `name`, `parent_id`) VALUES (NULL, :name, :parent_id)";
            var_dump($sql);

            $query = $db->prepare($sql);
            var_dump($query);
            $query->bindValue(":name", $name,);
            $query->bindValue(":parent_id", $parent_id);




            $toto = $query->execute();

            var_dump($toto);

            $_SESSION['confirmation'] = "Utilisateur ajouté";

            header('Location: category.php');
        } else {
            $_SESSION['erreur'] = "Le formulaire est incomplet";
        }
    }



    ?>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">
    ' . $_SESSION['erreur'] . '
    </div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <h1>Ajouter un rayon</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="name">name :</label></br>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">parent_id :</label></br>
                        <input type="text" id="parent_id" name="parent_id" class="form-control">
                    </div>

                    <button class="btn btn-primary">Créer</button>
                </form>
            </section>
        </div>
    </main><br>

    <div><button><a href="category.php">Annuler</a></button></div>


</body>

</html>