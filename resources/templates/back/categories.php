
<h1 class="page-header">
  Product Categories

</h1>
<h4 class="bg-success"><?php displayMessage(); ?></h4>
<?php createCategory(); ?>
<div class="col-md-4">   
    <form action="" method="post">
        <div class="form-group">
            <label for="cat_title">Title</label>
            <input type="text" name="cat_title" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="create_category" class="btn btn-primary" value="Add Category">
        </div>      
    </form>
</div>
<div class="col-md-8">

    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Delete</th>
            </tr>
        </thead>
    <tbody>
        <tr>
            <?php displayCatInAdmin() ?>
        </tr>
    </tbody>

        </table>

</div>
