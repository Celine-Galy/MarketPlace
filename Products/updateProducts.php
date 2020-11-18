<?php
include('../config.inc.php');
include('../connexion.inc.php');
if (
    !empty($_POST['seller_id'])
    and !empty($_POST['product_EAN13'])
    and !empty($_POST['product_name'])
    and !empty($_POST['product_shortDescription'])
    and !empty($_POST['product_longDescription'])
    and !empty($_POST['category_id'])
    and !empty($_POST['product_stock'])
    and !empty($_POST['product_priceHT'])
    and !empty($_POST['product_deliveryHT'])
    and !empty($_POST['brand_id'])
) :

    //Traitement d'un update
    if (!empty($_POST['product_id'])) :

        $maRequete = "UPDATE products SET
                        
                        product_EAN13       = '" . $_POST['product_EAN13'] . "',
                        product_image       = '" . $_POST['product_image'] . "',
                        product_name        = '" . $_POST['product_name'] . "',
                        product_shortDescription = '" . $_POST['product_shortDescription'] . "',
                        product_priceHT     = '" . $_POST['product_priceHT'] . "',
                        product_deliveryHT  = '" . $_POST['product_deliveryHT'] . "',
                        brand_id     = '" . $_POST['brand_id'] . "'
                        where product_id = '" . $_POST['product_id'] . "'
                    ";

        if ($result = $mysqli->query($maRequete)) :

            $marequeteStock = "UPDATE products_sellers SET
           
        seller_id =         '" . $_POST['seller_id'] . "',
        product_stock =     '" . $_POST['product_stock'] . "'
         WHERE product_id = '" . $_POST['product_id'] . "'
        
        ";
            if ($resultCategory = $mysqli->query($marequeteCategory));
            $marequeteCategory = "UPDATE categories_products SET
           
            category_id =         '" . $_POST['category_id'] . "',
           WHERE product_id =     '" . $_POST['product_id'] . "'
            
            ";
            if ($resultStock = $mysqli->query($marequeteCategory));
            $message = "Le produit a été modifié avec succès";
        else :
            $message = "Une erreur est survenue lors de la modification " . $maRequete;
        endif;

    //Traitement d'un insert
    else :
        $maRequete = "INSERT INTO products
                            (
                            product_EAN13,
                            product_image,
                            product_name,
                            product_shortDescription,
                            product_longDescription,
                            product_priceHT,
                            product_deliveryHT,
                            brand_id)
                       VALUES (
                            '" . $_POST['product_EAN13'] . "',
                            '" . $_POST['product_image'] . "',
                            '" . $_POST['product_name'] . "',
                            '" . $_POST['product_shortDescription'] . "',
                            '" . $_POST['product_longDescription'] . "',
                            '" . $_POST['product_priceHT'] . "',
                            '" . $_POST['product_deliveryHT'] . "',
                            '" . $_POST['brand_id'] . "')
    ";

        if ($result = $mysqli->query($maRequete)) :
            $product_id = $mysqli->insert_id;
            $marequeteStock = "INSERT INTO products_sellers
                            (
                            seller_id,
                            product_id,
                            product_stock)
                        VALUES (
                            '" . $_POST['seller_id'] . "',
                            '$product_id',
                            '" . $_POST['product_stock'] . "'
                            )
                            ";
            if ($resultStock = $mysqli->query($marequeteStock)) :

                $marequeteCat = "INSERT INTO categories_products
                (
                    category_id,
                    product_id
                )
                VALUES (
                    '" . $_POST['category_id'] . "',
                    '$product_id'
                )";
                $resultCategory = $mysqli->query($marequeteCat);


                $message = "Le produit a été ajouté avec succès";
                header('Location:products.php');
            else :
                $message = "Une erreur est survenue lors de l'ajout " . $maRequete;
            endif;
        endif;
    endif;
endif;

//$_REQUEST = permet d'avoir à la fois le $_GET  et le $_POST
if (!empty($_REQUEST['product_id'])) {
    $product_id = $_REQUEST['product_id'];
}

//Selection pour préremplissage du formulaire
if (!empty($product_id)) :
    $marequete = 'SELECT * FROM products 
    INNER JOIN products_sellers ON products_sellers.product_id = products.product_id 
    INNER JOIN categories_products ON categories_products.product_id = products.product_id
    INNER JOIN categories ON categories.category_id = categories_products.category_id';

    if ($resultproduct = $mysqli->query($marequete)) :
        $monProduitAAjouter = $resultproduct->fetch_assoc();
    endif;
endif;

?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">
    <title>Admin Simplon MarketPlace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <main class="container">

        <div class="row">
            <section class="col-12">

                <?php
                if (!empty($message)) :
                ?>
                    <p><?php echo $message; ?></p>
                <?php
                endif;
                ?>

                <h1>Ajouter un nouveau Produit</h1>

                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                    <div class="form-group">
                        <label>Choisir le vendeur:</label>
                        <select name="seller_id">
                            <?php
                            $reqSeller = 'SELECT seller_id, seller_name FROM sellers';
                            if ($result = $mysqli->query($reqSeller)) :
                                while ($objSeller = $result->fetch_assoc()) :
                            ?>
                                    <option value="<?php echo $objSeller['seller_id']; ?>"><?php echo $objSeller['seller_name']; ?></option>
                                <?php
                                endwhile;
                                $result->close();
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_EAN13">Code-barre</label>
                        <input type="text" name="product_EAN13" value="<?php if (!empty($monProduitAAjouter['product_EAN13'])) echo $monProduitAAjouter['product_EAN13']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_image">Image</label>
                        <input type="text" name="product_image" value="<?php if (!empty($monProduitAAjouter['product_image'])) echo $monProduitAAjouter['product_image']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_name">Désignation</label>
                        <input type="text" name="product_name" value="<?php if (!empty($monProduitAAjouter['product_name'])) echo $monProduitAAjouter['product_name']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_shortDescription">Description courte</label>
                        <input type="text" name="product_shortDescription" value="<?php if (!empty($monProduitAAjouter['product_shortDescription'])) echo $monProduitAAjouter['product_shortDescription']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_longDescription">Description longue</label>
                        <input type="longDescription" name="product_longDescription" value="<?php if (!empty($monProduitAAjouter['product_longDescription'])) echo $monProduitAAjouter['product_longDescription']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Catégorie:</label>
                        <select name="category_id">
                            <?php
                                $reqCat = 'SELECT category_id, category_name FROM categories';
                                if ($resultCat = $mysqli->query($reqCat)) :
                                    while ($objCat = $resultCat->fetch_assoc()) :
                            ?>
                                    <option value="<?php echo $objCat['category_id']; ?>"><?php echo $objCat['category_name']; ?></option>
                                <?php
                                    endwhile;
                                    $resultCat->close();
                                ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="product_stock">Stock: </label>
                        <input type="stock" name="product_stock" value="<?php if (!empty($monProduitAAjouter['product_stock'])) echo $monProduitAAjouter['product_stock']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_priceHT">Prix HT</label>
                        <input type="text" name="product_priceHT" value="<?php if (!empty($monProduitAAjouter['product_priceHT'])) echo $monProduitAAjouter['product_priceHT']; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="product_deliveryHT">Prix livraison HT</label>
                        <input type="text" name="product_deliveryHT" value="<?php if (!empty($monProduitAAjouter['product_deliveryHT'])) echo $monProduitAAjouter['product_deliveryHT']; ?>" />
                    </div>
                    <div class="form-group">
                        <select name="brand_id">
                            <?php
                                    $reqBrand = 'SELECT brand_id, brand_name FROM brands';
                                    if ($result = $mysqli->query($reqBrand)) :
                                        while ($objBrand = $result->fetch_assoc()) :
                            ?>
                                    <option value="<?php echo $objBrand['brand_id'] ?>"><?php echo $objBrand['brand_id'] . $objBrand['brand_name']; ?></option>
                                <?php
                                        endwhile;
                                        $result->close();
                                ?>
                        </select>

                    </div>
                    <input class="btn btn-danger" type="submit" value="valider" />
                    <a href="update.php">Ajouter un nouveau Vendeur</a>
                    <a href="updateCategory.php">Ajouter une nouvelle Catégorie</a>
                    <a href="index.php" title="retour">Liste vendeurs</a>
                    <a href="products.php" title="produits">Liste produits</a>

                </form>

                <?php
                            endif;
                        endif;
                    endif;
                ?>
            </section>
        </div>
    </main>

</body>

</html>