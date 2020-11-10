<?php
session_start();

//Est-ce que l'id existe et n'est pas vide dans l'url

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');
        
        //supprimer les balises de l'URL envoyé
        $id = strip_tags($_GET['id']);

    
        $sql ="SELECT * FROM `brands` WHERE `brand_id` = ".$_GET['id'];
            
        //préparation de la requête
        $query = $db ->prepare($sql);
    
        //lier les paramètres
        $query->bindValue(':id', $id,PDO::PARAM_INT);
    
        //Exécution de la requête
        $query->execute();
        //Récupérer la marque

        $brand = $query->fetch(PDO::FETCH_ASSOC);

        var_dump($brand);

    //Vérifier si la marque existe
    if(!$brand){
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
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <title>Détails de la marque</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails de la Marque <?php echo $brand['brand_name'] ?></h1>
                <p>ID: <?php echo $brand['brand_id']?></p>
                <p>Nom: <?php echo $brand['brand_name']?></p>
                <p>Slogan: <?php echo $brand['brand_slogan']?></p>
                <p>Logo: <?php echo $brand['brand_logo']?></p>
                <p>Description: <?php echo $brand['brand_description']?></p>
                
                <p><a href="index.php">Retour</a> <a href="delete.php?id=<?php echo $brand['brand_id'] ?>">Supprimer</a></p>
            </section>
        </div>
    </main>
</body>
</html>