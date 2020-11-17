<?php
session_start();

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Détails de la marque</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du Vendeur <?php echo $seller['seller_name'] ?></h1>
                <p>ID: <?php echo $seller['seller_id']?></p>
                <p>Nom: <?php echo $seller['seller_name']?></p>
                <p>Adresse: <?php echo $seller['seller_adress']?></p>
                <p>Email: <?php echo $seller['seller_email']?></p>
                <p>Image: <?php echo $seller['seller_image']?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?php $seller['seller_id'] ?>">Supprimer</a></p>
            </section>
        </div>
    </main>
</body>
</html>