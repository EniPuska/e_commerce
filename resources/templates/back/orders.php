
<div class="col-md-12">
    <div class="row">
    <h1 class="page-header">
       All Orders

    </h1>
    <h4 class="bg-success"><?php displayMessage();?></h4>
    </div>

<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
               <th>Id</th>
               <th>Amount</th>
               <th>Transaction</th>
               <th>Currency</th>
               <th>Status</th>
               <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php displayOrders();?>
        </tbody>
    </table>
</div>
