<?php
session_start();

//Inclusion de la connexion à la base
require_once('connect.php');

//requète
$sql = 'SELECT * FROM `sellers`';

//préparation de la requête
$query = $db->prepare($sql);

//exécution de la requête

$query->execute();

//Stockage du résultat dans un tableau associatif 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <table class="table">
                    <?php
                        if(!empty($_SESSION['erreur'])){
                            echo'<div class ="alert alert-danger" role= "alert">'. $_SESSION['erreur'].'
                            </div>';
                            $_SESSION['erreur']='';
                        }
                    ?>
                    <?php
                        if(!empty($_SESSION['message'])){
                            echo'<div class ="alert alert-success" role= "alert">'. $_SESSION['message'].'
                            </div>';
                            $_SESSION['message']='';
                        }
                    ?>
                    <h1>Liste des Vendeurs</h1>
                    <thead>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        //Boucle sur la variable result
                            foreach($result as $sellers){
                        ?>
                            <tr>
                                <td><?php echo $sellers['seller_id'] ?></td>
                                <td><?php echo $sellers['seller_name'] ?></td>
                                <td><?php echo $sellers['seller_adress'] ?></td>
                                <td><?php echo $sellers['seller_email'] ?></td>
                                <td><a href="details.php?id=<?php echo $sellers['seller_id']?>">Voir</a> <a href="edit.php?id=<?php echo $sellers['seller_id']?>">Modifier</a> <a href="delete.php?id=<?php echo $sellers['seller_id']?>">Supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un nouveau vendeur</a>
            </section>
        </div>
    </main>
</body>
</html>