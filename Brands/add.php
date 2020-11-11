<?php
session_start();

if($_POST){
    if(isset($_POST['brand_name']) && !empty($_POST['brand_name'])
    && isset($_POST['brand_slogan']) && !empty($_POST['brand_slogan'])
    && isset($_POST['brand_logo']) && !empty($_POST['brand_logo'])
    && isset($_POST['brand_description']) && !empty($_POST['brand_description'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');
        //supprimer les balises de l'URL envoyé
        $name = strip_tags($_POST['brand_name']);
        $slogan = strip_tags($_POST['brand_slogan']);
        $logo = strip_tags($_POST['brand_logo']);
        $description = strip_tags($_POST['brand_description']);

        $sql = 'INSERT INTO `brands`(`brand_name`,`brand_slogan`,`brand_logo` ,`brand_description`) VALUES(:brand_name, :brand_slogan, :brand_logo, :brand_description)';


        $query = $db->prepare($sql);

        $query->bindValue(':brand_name',$name,PDO::PARAM_STR);
        $query->bindValue(':brand_slogan',$slogan,PDO::PARAM_STR);
        $query->bindValue(':brand_logo',$logo,PDO::PARAM_STR);
        $query->bindValue(':brand_description',$description,PDO::PARAM_STR);

        $query->execute();
        $_SESSION['message'] = "Nouvelle Marque Ajouté";
        require_once('../close.php');


        header('Location: index.php');
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
    <title>Ajouter une marque</title>
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
                        <label for="brand_name">Nom de la marque</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="brand_slogan">Slogan</label>
                        <input type="text" name="brand_slogan" id="brand_slogan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="brand_logo">Logo</label>
                        <input type="text" name="brand_logo" id="brand_logo" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="brand_description">Description</label>
                        <input type="text" name="brand_description" id="brand_description" class="form-control">
                    </div>
                    <button class="btn btn-primary">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>