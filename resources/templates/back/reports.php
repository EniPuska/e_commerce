
<div class="row">
  <h1 class="page-header">
     All Reports

  </h1>
  <h3 class="bg-success"><?php displayMessage();?></h3>
  <table class="table table-hover">
      <thead>
        <tr>
             <th>Id</th>
             <th>Product Id</th>
             <th>Order Id</th>
             <th>Title</th>
             <th>Price</th>
             <th>Quantity</th>
             <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php showReports() ?>
    </tbody>
  </table>
</div>
