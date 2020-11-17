<?php
session_start();

if($_POST){
    if(isset($_POST['seller_id']) && !empty($_POST['seller_id'])
    && isset($_POST['seller_name']) && !empty($_POST['seller_name'])
    && isset($_POST['seller_adress']) && !empty($_POST['seller_adress'])
    && isset($_POST['seller_image']) && !empty($_POST['seller_image'])
    && isset($_POST['seller_email']) && !empty($_POST['seller_email'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');

        //supprimer les balises de l'URL envoyé
        $id = strip_tags($_POST['seller_id']);
        $name = strip_tags($_POST['seller_name']);
        $adress = strip_tags($_POST['seller_adress']);
        $email = strip_tags($_POST['seller_email']);
        $image = strip_tags($_POST['seller_image']);
        

        $sql = 'UPDATE `sellers` SET `seller_name`=:seller_name,`seller_adress`=:seller_adress,`seller_email`=:seller_email,`seller_image`=:seller_image WHERE `seller_id`=:seller_id';

        $query = $db->prepare($sql);

        $query->bindValue(':seller_id',$id,PDO::PARAM_INT);
        $query->bindValue(':seller_name',$name,PDO::PARAM_STR);
        $query->bindValue(':seller_adress',$adress,PDO::PARAM_STR);
        $query->bindValue(':seller_email',$email,PDO::PARAM_STR);
        $query->bindValue(':seller_image',$image,PDO::PARAM_STR);


        $query->execute();
        $_SESSION['message'] = "Vendeur Modifié";
        require_once('../close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../connect.php');
        
        //supprimer les balises de l'URL envoyé
        $id = strip_tags($_GET['id']);

        // $sql = 'SELECT * FROM `sellers` WHERE `seller_id` = :seller_id;';
    
        $sql ="SELECT * FROM `sellers` WHERE `seller_id` = ".$_GET['id'];
    
        //préparation de la requête
        $query = $db ->prepare($sql);
    
        //lier les paramètres
        $query->bindValue(':id', $id,PDO::PARAM_INT);
    
        //Exécution de la requête
        $query->execute();
        //Récupérer le vendeur

        $seller = $query->fetch();

        // var_dump($seller);

//Vérifier si le vendeur existe
if(!$seller){
    $_SESSION['erreur']="cet id n'existe pas";
    header('location: index.php');
}

}else{
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
    // var_dump($seller);
    
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
                <h1>Modifier le vendeur</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="seller_name">Nom du Vendeur</label>
                        <input type="text" name="seller_name" id="seller_name" class="form-control" value="<?php echo $seller['seller_name'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="seller_adress">Adresse</label>
                        <input type="text" name="seller_adress" id="seller_adress" class="form-control" value="<?php echo $seller['seller_adress'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="seller_email">Email</label>
                        <input type="email" name="seller_email" id="seller_email" class="form-control" value="<?php echo $seller['seller_email'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="seller_image">Image</label>
                        <input type="text" name="seller_image" id="seller_image" class="form-control" value="<?php echo $seller['seller_image'] ?>">
                    </div>
                    <input type="hidden" value="<?php echo $seller['seller_id'] ?>" name="seller_id">
                    <button class="btn btn-danger">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>