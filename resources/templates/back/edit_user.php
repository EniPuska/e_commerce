
<div class="col-md-12">


<?php 
  if(isset($_GET['id'])){
    $query = query("SELECT * FROM users WHERE id = " . escape_string($_GET['id']) . "");
    confirmQuery($query);
    while($row = fetchArray($query)){
      $firstName = escape_string($row['firstname']);
      $lastName = escape_string($row['lastname']);
      $userName = escape_string($row['username']);
      $email = escape_string($row['email']);
      $password = escape_string($row['password']);
      $picture = escape_string($row['picture']);
    }
  }

?>
<?php updateUser();?>
<div class="row">
  <h1 class="page-header">
     Edit User
  </h1>
</div>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-12">

      <div class="form-group">
          <label for="product-title">First Name</label>
          <input type="text" name="firstname" class="form-control" value="<?php echo $firstName ; ?>"> 
      </div>
      <div class="form-group">
          <label for="product-title">Last Name</label>
          <input type="text" name="lastname" class="form-control" value="<?php echo $lastName ; ?>" > 
      </div>
      <div class="form-group">
          <label for="product-title">Username</label>
          <input type="text" name="username" class="form-control" value="<?php echo $userName ; ?>" > 
      </div>
      <div class="form-group">
          <label for="product-title">Email</label>
          <input type="emai" name="email" class="form-control" value="<?php echo $email ; ?>"> 
      </div>
      <div class="form-group">
          <label for="product-title">Password</label>
          <input type="password" name="password" class="form-control" value="<?php echo $password ; ?>"> 
      </div>
      <div class="form-group">
        <label for="product-image">User Image</label>
        <input type="file" name="file">
        <img width="200" src="../../resources/uploads/<?php echo $picture; ?>">
      </div>
      <div class="form-group button">
        <input type="submit" name="add_user" class="btn btn-primary" value="Update">
      </div>
    </div><!--Main Content-->
</form>
</div>
