<?php require_once("../resources/config.php");?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <header>
            <h1 class="text-center">Login</h1>
            <h2 class="text-center bg-danger"><?php displayMessage(); ?></h2>
            <div class="col-sm-4 col-sm-offset-5">         
                <form class="" action="" method="post" enctype="multipart/form-data">
                    <?php loginUser(); ?>
                    <div class="form-group">
                       <label for="username">Username</label>
                       <input type="text" name="username" class="form-control">
                    </div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>  
        </header>
    </div>
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
   