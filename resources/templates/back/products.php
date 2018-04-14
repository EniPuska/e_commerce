
<div class="row">
  <h1 class="page-header">
     All Products

  </h1>
  <h3 class="bg-success"><?php displayMessage();?></h3>
  <table class="table table-hover">
      <thead>
        <tr>
             <th>Id</th>
             <th>Title</th>
             <th>Picture</th>
             <th>Category</th>
             <th>Price</th>
             <th>Quantity</th>
             <th>Edit</th>
             <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php getProductsInAdmin(); ?>
    </tbody>
  </table>
</div>
