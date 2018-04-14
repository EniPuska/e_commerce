
<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add User
</h1>
<?php addUser(); ?>
<h4 class="bg-success"><?php displayMessage();?></h4>
</div>
<form action="" method="post" enctype="multipart/form-data">
<div class="col-md-12">

  <div class="form-group">
      <label for="product-title">First Name</label>
      <input type="text" name="firstname" class="form-control"> 
  </div>
  <div class="form-group">
      <label for="product-title">Last Name</label>
      <input type="text" name="lastname" class="form-control"> 
  </div>
  <div class="form-group">
      <label for="product-title">Username</label>
      <input type="text" name="username" class="form-control"> 
  </div>
  <div class="form-group">
      <label for="product-title">Email</label>
      <input type="emai" name="email" class="form-control"> 
  </div>
  <div class="form-group">
      <label for="product-title">Password</label>
      <input type="password" name="password" class="form-control"> 
  </div>
  <div class="form-group">
    <label for="product-image">User Image</label>
    <input type="file" name="file">
  </div>
  <div class="form-group button">
    <input type="submit" name="add_user" class="btn btn-primary" value="Add User">
  </div>
</div><!--Main Content-->
</form>
</div>
