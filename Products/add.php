<?php
session_start();

if($_POST){
    if(isset($_POST['product_name']) && !empty($_POST['product_name'])
    && isset($_POST['product_shortDescription']) && !empty($_POST['product_shortDescription'])
    && isset($_POST['product_image']) && !empty($_POST['product_image'])
    && isset($_POST['product_longDescription']) && !empty($_POST['product_longDescription'])
    && isset($_POST['product_priceHT']) && !empty($_POST['product_priceHT'])
    && isset($_POST['product_deliveryHT']) && !empty($_POST['product_deliveryHT'])
    && isset($_POST['brand_id']) && !empty($_POST['brand_id'])){
        //Inclusion de la connexion à la base
        require_once('../connect.php');

        //supprimer les balises de l'URL envoyé
        $image = strip_tags($_POST['product_image']);
        $name = strip_tags($_POST['product_name']);
        $shortDescription = strip_tags($_POST['product_shortDescription']);
        $longDescription = strip_tags($_POST['product_longDescription']);
        $priceHT = strip_tags($_POST['product_priceHT']);
        $deliveryHT = strip_tags($_POST['product_deliveryHT']);
        $brand_id = strip_tags($_POST['brand_id']);
        
        $sql = 'INSERT INTO `products`(`product_name`,`product_shortDescription`,`product_longDescription`,`product_priceHT`,`product_deliveryHT`,`brand_id`,`product_image`) VALUES(:product_name, :product_shortDescription, :product_longDescription,:product_priceHT,:product_deliveryHT,:brand_id,:product_image)';


        $query = $db->prepare($sql);

        // $query->bindValue(':product_id',$id,PDO::PARAM_INT);
        $query->bindValue(':product_name',$name,PDO::PARAM_STR);
        $query->bindValue(':product_shortDescription',$shortDescription,PDO::PARAM_STR);
        $query->bindValue(':product_longDescription',$longDescription,PDO::PARAM_STR);
        $query->bindValue(':product_priceHT',$priceHT,PDO::PARAM_INT);
        $query->bindValue(':product_deliveryHT',$deliveryHT,PDO::PARAM_INT);
        $query->bindValue(':brand_id',$brand_id,PDO::PARAM_INT);
        $query->bindValue(':product_image',$image,PDO::PARAM_STR);



        $query->execute();
        $_SESSION['message'] = "Nouveau produit Ajouté";
        require_once('../close.php');

        var_dump($query);
        header('Location: ../Categories_products/add.php');
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
                <h1>Ajouter un Produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="product_name">Nom du produit</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_shortDescription">Description Courte</label>
                        <input type="text" name="product_shortDescription" id="product_shortDescription" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_longDescription">Description Longue</label>
                        <input type="text" name="product_longDescription" id="product_longDescription" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_priceHT">prixHT</label>
                        <input type="text" name="product_priceHT" id="product_priceHT" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_deliveryHT">livraisonHT</label>
                        <input type="text" name="product_deliveryHT" id="product_deliveryHT" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="brand_id">id marque</label>
                        <input type="text" name="brand_id" id="brand_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="product_image">image</label>
                        <input type="text" name="product_image" id="product_image" class="form-control">
                    </div>
                    <!-- <input type="hidden" value="<?php echo $product['product_id'] ?>" name="product_id"> -->

                    <button class="btn btn-danger">Valider</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>