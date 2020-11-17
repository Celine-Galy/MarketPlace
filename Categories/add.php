<?php
session_start();

if($_POST){
    if(isset($_POST['category_name']) && !empty($_POST['category_name'])
    && isset($_POST['category_description']) && !empty($_POST['category_description'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');
        //supprimer les balises de l'URL envoyé
        $name = strip_tags($_POST['category_name']);
        $description = strip_tags($_POST['category_description']);

        $sql = 'INSERT INTO `categories`(`category_name`,`category_description`) VALUES(:category_name, :category_description)';


        $query = $db->prepare($sql);

        $query->bindValue(':category_name',$name,PDO::PARAM_STR);
        $query->bindValue(':category_description',$description,PDO::PARAM_STR);

        $query->execute();
        $_SESSION['message'] = "Nouvelle Catégorie Ajouté";
        require_once('../close.php');


        // header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Catégorie</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo'<div class ="alert alert-danger" role= "alert">'. $_SESSION['erreur'].'
                        </div>';
                        $_SESSION['erreur']='';
                    }
                ?>
                <h1>Ajouter une marque</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="category_name">Nom de la categorie</label>
                        <input type="text" name="category_name" id="category_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="category_description">Description</label>
                        <input type="text" name="category_description" id="category_description" class="form-control">
                    </div>
                    <button class="btn btn-primary">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>