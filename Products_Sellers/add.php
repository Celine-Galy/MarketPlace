<?php
session_start();

if($_POST){
    if(isset($_POST['seller_id']) && !empty($_POST['seller_id'])
    && isset($_POST['product_id']) && !empty($_POST['product_id'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');
        //supprimer les balises de l'URL envoyé
        $sellerID = strip_tags($_POST['seller_id']);
        $productID = strip_tags($_POST['product_id']);


        $sql = 'INSERT INTO `products_sellers`(`product_id`,`seller_id`) VALUES(:product_id, :seller_id)';


        $query = $db->prepare($sql);

        $query->bindValue(':seller_id',$sellerID,PDO::PARAM_INT);
        $query->bindValue(':product_id',$productID,PDO::PARAM_INT);


        $query->execute();
        $_SESSION['message'] = "Liason Ajouté";
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
                <h1>Lier Vendeur-produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="seller_id">ID du vendeur</label>
                        <input type="text" name="seller_id" id="seller_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_id">ID du produit</label>
                        <input type="text" name="product_id" id="product_id" class="form-control">
                    </div>

                    <button class="btn btn-primary">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>