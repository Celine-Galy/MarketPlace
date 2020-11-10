<?php
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL

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


        $brand = $query->fetch();


    //Vérifier si la marque existe
    if(!$brand){
        $_SESSION['erreur']="cet id n'existe pas";
        header('location: index.php');
        die();
    }

    $sql = "DELETE FROM `brands` WHERE `brand_id` = ".$_GET['id'];


    //On prépare la requête
    $query = $db->prepare($sql);

    //On "accroche" les paramètre (id)
    $query->bindValue(':id',$id,PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Marque supprimé";
    header('Location: index.php');

}else{
    $_SESSION['erreur'] = "URL Invalide";
    header('Location: index.php');    
}
?>