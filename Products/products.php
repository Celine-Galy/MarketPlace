<?php
include('../config.inc.php');
include('../connexion.inc.php');
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="style/main.css"> -->

    <title>MarketPlace | Connexion à une base de données CRUD</title>
</head>

<body>

    <h1>Admin Simplon Marketplace</h1>
    <a href="updateProducts.php">Ajouter un produit</a>
    <h2>Produit </h2>

    <section class="col-12">
        <table class="table">
            <thead>
                
                <th>Nom</th>
                <th>EAN</th>
                <th>Image</th>
                <th>Description courte</th>
                <th>Description longue</th>
                <th>Stock</th>
                <th>Prix HT</th>
                <th>Livraison</th>
                <th>MarqueID</th>
                <th>Nom de la catégorie</th>
                <th>Action</th>

            </thead>


            <tbody>

                <?php
                $maRequete = 'SELECT * FROM products 
                INNER JOIN products_sellers ON products_sellers.product_id = products.product_id
                INNER JOIN categories_products ON categories_products.product_id = products.product_id
                INNER JOIN categories ON categories.category_id = categories_products.category_id';


                if ($result = $mysqli->query($maRequete)) :
                    while ($objproduct = $result->fetch_object()) :
                ?>
                        <tr>
                            <td><?php echo $objproduct->product_name; ?></td>
                            <td><?php echo $objproduct->product_EAN13; ?></td>
                            <td><img src="<?php echo $objproduct->product_image; ?>" /></td>
                            <td><?php echo $objproduct->product_shortDescription; ?></td>
                            <td><?php echo $objproduct->product_longDescription; ?></td>
                            <td><?php echo $objproduct->product_stock; ?></td>
                            <td><?php echo $objproduct->product_priceHT; ?></td>
                            <td><?php echo $objproduct->product_deliveryHT; ?></td>
                            <td><?php echo $objproduct->brand_id; ?></td>
                            <td><?php echo $objproduct->category_name; ?></td>
                            <!-- Methode 2 avec un paramètre en URL -->
                            <td> <a href="updateProducts.php?product_id=<?php echo $objproduct->product_id; ?>" title="modifier">Modifier</a><a href="deleteProducts.php?product_id=<?php echo $objproduct->product_id; ?>" title="supprimer">Supprimer</a> </td>
                        </tr>
                        <?php
                    endwhile;

                    $result->close();
                else :
?>
            </tbody>
        </table>

    </section>





<p>Aucun résultat trouvé</p>
<?php
                endif;

?>
</body>

</html>