<?php require_once("../resources/config.php");?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Shop</h1>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
        <!-- Page Features -->
        <div class="row text-center">
            <?php getProductsInShopPage(); ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
    </div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>