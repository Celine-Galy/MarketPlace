<?php
session_start();

if($_POST){
    if(isset($_POST['seller_name']) && !empty($_POST['seller_name'])
    && isset($_POST['seller_address']) && !empty($_POST['seller_address'])
    && isset($_POST['seller_email']) && !empty($_POST['seller_email'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');

        //supprimer les balises de l'URL envoyé
        $name = strip_tags($_POST['seller_name']);
        $adress = strip_tags($_POST['seller_address']);
        $email = strip_tags($_POST['seller_email']);
        $image = strip_tags($_POST['seller_image']);
        

        $sql = 'INSERT INTO `sellers`(`seller_name`,`seller_address`,`seller_email`) VALUES(:seller_name, :seller_address, :seller_email)';
        $query = $db->prepare($sql);

        $query->bindValue(':seller_name',$name,PDO::PARAM_STR);
        $query->bindValue(':seller_address',$adress,PDO::PARAM_STR);
        $query->bindValue(':seller_email',$email,PDO::PARAM_STR);

        $query->execute();
        $_SESSION['message'] = "Nouveau vendeur Ajouté";
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
    <title>Ajouter un vendeur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
                <h1>Ajouter un vendeur</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="seller_name">Nom du Vendeur</label>
                        <input type="text" name="seller_name" id="seller_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="seller_address">Adresse</label>
                        <input type="text" name="seller_address" id="seller_address" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="seller_email">Email</label>
                        <input type="email" name="seller_email" id="seller_email" class="form-control">
                    </div>

                    <button class="btn btn-danger">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>