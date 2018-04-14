<?php require_once("../resources/config.php");?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
    <!-- Page Content -->
    <?php 
        proccessTransaction();
    ?>
    <div class="container">
        <!-- /.row --> 
        <h1 class="text-center">Thank You</h1>
    </div><!--Main Content-->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>