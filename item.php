<?php require_once("../resources/config.php");?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
<div class="container">
<!-- Side Navigation -->
    <div class="col-md-3">
        <?php selectCategories();?>
    </div>
<div class="col-md-9">

<!--Row For Image and Short Description-->

<?php singleProducts(); ?>



</div> <!-- col md-9 ends -->

</div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>