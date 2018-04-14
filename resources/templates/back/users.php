
<div class="col-lg-12">
    <h1 class="page-header">Users</h1>
      <p class="bg-success"></p>
    <a href="index.php?add_user" class="btn btn-primary">Add User</a>
     <h3 class="bg-success"><?php displayMessage();?></h3>
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>UserName</th>
                    <th>Photo </th>
                    <th>Edit </th>
                    <th>Delete </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php displayUsers() ?>
                </tr>   
            </tbody>
        </table> <!--End of Table-->
    </div>
</div>
