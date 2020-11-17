<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../connect.php');
        
        //supprimer les balises de l'URL envoyé
        $id = strip_tags($_GET['id']);

    
        $sql ="SELECT * FROM `products` WHERE `product_id` = ".$_GET['id'];
    
        //préparation de la requête
        $query = $db ->prepare($sql);
    
        //lier les paramètres
        $query->bindValue(':id', $id,PDO::PARAM_INT);
    
        //Exécution de la requête
        $query->execute();
        //Récupérer le vendeur

        $product = $query->fetch();


    //Vérifier si le vendeur existe
    if(!$product){
        $_SESSION['erreur']="cet id n'existe pas";
        header('location: index.php');
    }

}else{
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Détails du produit</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du Produit <?php echo $product['product_name'] ?></h1>
                <p>ID: <?php echo $product['product_id']?></p>
                <p>Nom: <?php echo $product['product_name']?></p>
                <p>description Courte: <?php echo $product['product_shortDescription']?></p>
                <p>longue description: <?php echo $product['product_longDescription']?></p>
                <p>Prix HT: <?php echo $product['product_priceHT']?></p>
                <p>Prix Livraison HT: <?php echo $product['product_deliveryHT']?></p>
                <p>ID Marque: <?php echo $product['brand_id']?></p>

                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?php $product['product_id'] ?>">Supprimer</a></p>
            </section>
        </div>
    </main>
</body>
</html>