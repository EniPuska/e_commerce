<?php
/******************************** HELPER FUNCTIONS ************************************/
	function redirect($location){
		header("Location: $location");
	}
	function query($sql){
		global $connection;
		return mysqli_query($connection,$sql);
	}
	function escape_string($string){
		global $connection;
		return mysqli_escape_string($connection,$string);
	} 
	function confirmQuery($result){
		global $connection;
		if(!$result){
            die("QUERY FAILED.". mysqli_error($connection));
        }
	}
	function fetchArray($result){
		return mysqli_fetch_array($result);
	}
	function selectCategories(){
		global $connection;
		$query = query("SELECT * FROM categories");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$cat_id = $row['cat_id'];
			$cat_title = $row['cat_title'];
			$result = '<a href="category.php?id='.$cat_id.'" class="list-group-item">'.$cat_title.'</a>';
			echo $result;
		}
	}
	function setMessage($msg){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		}else{
			$msg = "";
		}
	}	
	function displayMessage(){
		if(isset($_SESSION['message'])){
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	}
	function lastId(){
		global $connection;
		return mysqli_insert_id($connection);
	}	
	

	/******************************** FRONT END FUNCTIONS ************************************/
	//get all products and display it
	function getProducts(){
		global $connection;
		$query = query("SELECT * FROM products ");
		confirmQuery($query);
		$rows = mysqli_num_rows($query);
		if(isset($_GET['page'])){
			$page = preg_replace('#[^0-9]#', '', $_GET['page']);

		}else{
			$page = 1;
		}
			$perPage = 3;
			$lastPage = ceil($rows / $perPage);
			if($page < 1 ){
				$page = 1;
			}elseif($page > $lastPage){
				$page = $lastPage;
			}
			$middleNumbers = '';
			$sub1 = $page -1;
			$sub2 = $page -2;
			$add1 = $page + 1;
			$add2 = $page + 2;
			if($page == 1){

		      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';

		      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';

			} elseif ($page == $lastPage) {
			    
				  $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
				  $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
			}elseif ($page > 2 && $page < ($lastPage -1)) {

			      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">' .$sub2. '</a></li>';

			      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';

			      $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';

			         $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';

			      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">' .$add2. '</a></li>';
			} elseif($page > 1 && $page < $lastPage){

			     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page= '.$sub1.'">' .$sub1. '</a></li>';

			     $middleNumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
			 
			     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
			}
			$limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;
			$query2 = query("SELECT * FROM products $limit");
			confirmQuery($query2);
			$outputPagination = "";
			if($page != 1){
				$prev = $page - 1 ;
				$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
			}
			$outputPagination .= $middleNumbers;
			if($page != $lastPage){
				$next = $page + 1;
				$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
			}
		while($row = fetchArray($query2)){
			$product_id = $row['product_id'];
			$product_price = $row['product_price'];
			$product_title = $row['product_title'];
			$product_image = $row['product_image'];
			$result = '<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id='.$product_id.'"><img class="img img-responsive" src="../resources/uploads/'.$product_image.'" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&#36;'.$product_price.'</h4>
                                <h4><a href="item.php?id='.$product_id.'">'.$product_title.'</a>
                                </h4>
                                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="../resources/cart.php?add='.$product_id.'" class="btn btn-primary" target="_blank" >Add to cart</a>
                            </div>

                        </div>
                    </div>
			';
			echo $result;
		}
		echo "<div class='text-center'><ul class='pagination'>{$outputPagination}</ul></div>";
	}
	function singleProducts(){
		global $connection;
		$query = query("SELECT * FROM products WHERE product_id = ".escape_string($_GET['id'])." ");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$product_id = $row['product_id'];
			$product_price = $row['product_price'];
			$product_title = $row['product_title'];
			$product_image = $row['product_image'];
			$product_description = $row['product_description'];
			$short_description = $row['product_desc'];
			$single_product = '<div class="row">
								    <div class="col-md-7">
								       <img class="img-responsive" src="../resources/uploads/'.$product_image.'" alt="">
								    </div>
								    <div class="col-md-5">
							        	<div class="thumbnail">
								      		<div class="caption-full">
								        <h4><a href="#">'.$product_title.'</a> </h4>
								        <hr>
								        <h4 class="">&#36;'.$product_price.'</h4>
								        <p>'.$short_description.'</p>
								    <form action="">
								        <div class="form-group">
								            <a href="../resources/cart.php?add='.$product_id.'"class="btn btn-primary">Add To Cart</a>
								        </div>
								    </form>
								    	</div> 
									</div>
								</div>
								</div><!--Row For Image and Short Description-->
								        <hr>
								<!--Row for Tab Panel-->
								<div class="row">
								<div role="tabpanel">
								  <!-- Nav tabs -->
								  <ul class="nav nav-tabs" role="tablist">
								    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
								    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
								  </ul>
								  <!-- Tab panes -->
								  <div class="tab-content">
								    <div role="tabpanel" class="tab-pane active" id="home">
								<p></p>          
								   <p>'.$product_description.'</p>
								    </div>
								    <div role="tabpanel" class="tab-pane" id="profile">
								  <div class="col-md-6">
								       <h3>2 Reviews From </h3>

								        <hr>
								        <div class="row">
								            <div class="col-md-12">
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star-empty"></span>
								                Anonymous
								                <span class="pull-right">10 days ago</span>
								                <p>This product was great in terms of quality. I would definitely buy another!</p>
								            </div>
								        </div>

								        <hr>

								        <div class="row">
								            <div class="col-md-12">
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star-empty"></span>
								                Anonymous
								                <span class="pull-right">12 days ago</span>
								                <p>I"ve alredy ordered another one!</p>
								            </div>
								        </div>

								        <hr>

								        <div class="row">
								            <div class="col-md-12">
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star"></span>
								                <span class="glyphicon glyphicon-star-empty"></span>
								                Anonymous
								                <span class="pull-right">15 days ago</span>
								                <p>I"ve seen some better than this, but not at this price. I definitely recommend this item.</p>
								            </div>
								        </div>

								    </div>


								    <div class="col-md-6">
								        <h3>Add A review</h3>

								     <form action="" class="form-inline">
								        <div class="form-group">
								            <label for="">Name</label>
								                <input type="text" class="form-control" >
								            </div>
								             <div class="form-group">
								            <label for="">Email</label>
								                <input type="test" class="form-control">
								            </div>

								        <div>
								            <h3>Your Rating</h3>
								            <span class="glyphicon glyphicon-star"></span>
								            <span class="glyphicon glyphicon-star"></span>
								            <span class="glyphicon glyphicon-star"></span>
								            <span class="glyphicon glyphicon-star"></span>
								        </div>

								            <br>
								            
								             <div class="form-group">
								             <textarea name="" id="" cols="60" rows="10" class="form-control"></textarea>
								            </div>

								             <br>
								              <br>
								            <div class="form-group">
								                <input type="submit" class="btn btn-primary" value="SUBMIT">
								            </div>
								        </form>

								    </div>

								 </div>

								 </div>
								</div>
								</div><!--Row for Tab Panel-->
			';
			echo $single_product;
		}
	}
	function getProductsFromCatPage(){
		global $connection;
		$query = query("SELECT * FROM products WHERE product_category_id = ". escape_string($_GET['id'])." ");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$product_id = $row['product_id'];
			$product_price = $row['product_price'];
			$product_title = $row['product_title'];
			$product_image = $row['product_image'];
			$result = '	<div class="col-md-3 col-sm-6 hero-feature">
			                <div class="thumbnail">
			                    <img src="../resources/uploads/'.$product_image.'" alt="">
			                    <div class="caption">
			                        <h3>'.$product_title.'</h3>
			                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			                        <p>
			                            <a href="../resources/cart.php?add='.$product_id.'" class="btn btn-primary">Buy Now!</a>  <a href="item.php?id='.$product_id.'" class="btn btn-info"> <i class="fa fa-info" aria-hidden="true"></i> More Info</a>
			                        </p>
			                    </div>
			                </div>
            			</div>
			';
			echo $result;
		}
	}
	function getProductsInShopPage(){
		global $connection;
		$query = query("SELECT * FROM products");
		confirmQuery($query);
		
		while($row = fetchArray($query)){
			$product_id = $row['product_id'];
			$product_price = $row['product_price'];
			$product_title = $row['product_title'];
			$product_image = $row['product_image'];
			$result = '	<div class="col-md-3 col-sm-6 hero-feature">
			                <div class="thumbnail">
			                    <img src="../resources/uploads/'.$product_image.'" alt="">
			                    <div class="caption">
			                        <h3>'.$product_title.'</h3>
			                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			                        <p>
			                            <a href="../resources/cart.php?add='.$product_id.'" class="btn btn-primary"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now!</a>  
			                            <a href="item.php?id='.$product_id.'" class="btn btn-info"> <i class="fa fa-info" aria-hidden="true"></i> More Info</a>
			                        </p>
			                    </div>
			                </div>
            			</div>
			';
			echo $result;
		}
	}
	//the function which the user is logged in
	function loginUser(){
		global $connection;
		if(isset($_POST['submit'])){
			$username = escape_string($_POST['username']);
			$password = escape_string($_POST['password']);
			$query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
			confirmQuery($query);
			if(mysqli_num_rows($query) == 0){
				setMessage("Your password or username are wrong");
				redirect("login.php");
			}else{
				$_SESSION['username'] = $username;
				redirect("admin");
			}
		}
	}
	function sendMessage(){
		if(isset($_POST['submit'])){
			$to 	 = "enipuska@gmail.com";
			$name 	 = $_POST['name'];
			$subject = $_POST['subject'];
			$email 	 = $_POST['email'];
			$message = $_POST['message'];
			$headers = "From: {$name} {$email}";
			$result = mail($to, $subject, $message, $headers);
			if(!$result){
				echo "ERROR";
			}else{
				echo "SENT";
			}
		}
	}
	//main cart function
	function cart(){
		global $connection;
		$item_name = 1;
		$item_number = 1;
		$item_amount = 1;
		$total = 0;
		$quantity = 1;
		$item_quantity = 0;
		foreach ($_SESSION as $name => $value) {
			if($value > 0){
				if(substr($name, 0, 8)=="product_"){
					$length = strlen($name);
					$id = substr($name, 8 , $length);
					$query = query("SELECT * FROM products WHERE product_id = ".escape_string($id)."");
					confirmQuery($query);
						while($row = fetchArray($query)){	
							$product_id = $row['product_id'];
							$name = $row['product_title'];
							$image = $row['product_image'];
							$price = $row['product_price'];
							$product_quality = $row['product_quantity'];
							$subTotal = $price * $value;
							$item_quantity += $value;
							$result = '	<tr>
										<td>'.$name.'</td>
										<td><img width = "100" src="../resources/uploads/'.$image.'"</td>
				                        <td>&#36;'.$price.'</td>
				                        <td>'.$value.'</td>
				                        <td>&#36;'.$subTotal.'</td>
				                        <td>
				                        <a class="btn btn-success" href="../resources/cart.php?add='.$product_id.'"><span class="glyphicon glyphicon-plus"></span></a>
				                        <a class="btn btn-warning" href="../resources/cart.php?remove='.$product_id.'"><span class="glyphicon glyphicon-minus"></span></a>
				                        <a class="btn btn-danger" href="../resources/cart.php?delete='.$product_id.'"><span class="glyphicon glyphicon-remove"></span></a>
				                        </td>
				                        </tr>
				                          <input type="hidden" name="item_name_'.$item_name.'" value="'.$name.'">
										  <input type="hidden" name="item_number_'.$item_number.'" value="'.$product_id.'">
										  <input type="hidden" name="amount_'.$item_amount.'" value="'.$price.'">
										  <input type="hidden" name="quantity_'.$quantity.'" value="'.$value.'">
							';
							echo $result;
							$item_name++;
							$item_number++;
							$item_amount++;
							$quantity++;				
						}
 							$_SESSION['item_total'] = $total += $subTotal;
 							$_SESSION['item_quantity'] = $item_quantity;
				}
			}
		}
	}	
	//if we click the + button we add the quantity of the desired item
	function addQuantity(){
		if(isset($_GET['add'])){
        $query = query("SELECT * FROM products WHERE product_id= ".escape_string($_GET['add'])."");
        confirmQuery($query);
	        while($row = fetchArray($query)){
	            if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
	                $_SESSION['product_' . $_GET['add']]+=1;
	                redirect("../public/checkout.php");
	            }else{
	                setMessage(" We only have ". $row['product_title'] . " " . $row['product_quantity'] . " " . "available");
	                redirect("../public/checkout.php");
	            }
	        }
	    }    
	}
	//The purpose of the function is to remove a quantity from the chekout list
	function removeQuantity(){
		if(isset($_GET['remove'])){
        $_SESSION['product_' . $_GET['remove']]--;
	        if($_SESSION['product_' . $_GET['remove']] < 1){
	            unset($_SESSION['item_total']);
	            unset($_SESSION['item_quantity']);
	            redirect("../public/checkout.php");
	        }else{
	            redirect("../public/checkout.php");
	        }
    	}		
	} 
	//the purpose of the function is to delete the product of the checkout list
	function deleteProduct(){
		if(isset($_GET['delete'])){
	        $_SESSION['product_' . $_GET['delete']] = '0';
	        unset($_SESSION['item_total']);
	        unset($_SESSION['item_quantity']);
	        redirect("../public/checkout.php");
    	}
	}
	//display the buy now button 
	function displayPaypalBtn(){
		if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity']){
			$paypal_button = '<input type="image" name="upload" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
		';
		return $paypal_button;
		}		
	}
	function proccessTransaction(){
        global $connection;
            if(isset($_GET['tx'])){
                $transaction = $_GET['tx'];
                $currency = $_GET['cc'];
                $amount = $_GET['amt'];
                $status = $_GET['st'];
                
          	}else{
                redirect("index.php");
          	}	
        $total = 0;
        $item_quantity = 0;
        foreach ($_SESSION as $name => $value) {
            if($value > 0){
                if(substr($name, 0, 8)=="product_"){
                    $length = strlen($name - 8);
                    $id = substr($name, 8 , $length);
                    $send_order =  query("INSERT INTO orders(order_amount,order_transaction,order_status,order_currency) VALUES('{$amount}','{$transaction}','{$currency}','{$status}')");
	                $last_id = lastId();
	                confirmQuery($send_order);   
                    $query = query("SELECT * FROM products WHERE product_id = ".escape_string($id)."");
                    confirmQuery($query);
                    while($row = fetchArray($query)){   
                        $product_id = $row['product_id'];
                        $name = $row['product_title'];
                        $price = $row['product_price'];
                        $product_quality = $row['product_quantity'];
                        $subTotal = $price * $value;
                        $item_quantity += $value;     
                    }
                     $query =  query("INSERT INTO reports(product_id,order_id,product_title,product_price,product_quantity) VALUES('{$id}','{$last_id}','{$name}','{$price}','{$value}')");  
                }
            }
            
        }
        session_destroy();
    }
	/******************************** BACK END FUNCTIONS ************************************/
	function displayOrders(){
		global $connection;
		$query = query("SELECT * FROM orders");
		confirmQuery($query);
		while($row=fetchArray($query)){
			$id = $row['order_id'];
			$amount = $row['order_amount'];
			$transaction = $row['order_transaction'];
			$currency = $row['order_currency'];
			$status = $row['order_status'];
			$result = '	<tr>	
						<td>'.$id.'</td>
						<td>'.$amount.'</td>
						<td>'.$transaction.'</td>
						<td>'.$currency.'</td>
						<td>'.$status.'</td>
						<td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id='.$id.'""><span class="glyphicon glyphicon-remove"></span></a></td>
						</tr>
			';
			echo $result;
		}
	}
	//delete orders in the admin session
	function deleteOrder(){
		global $connection;
		if(isset($_GET['id'])){
			$query = query("DELETE FROM orders WHERE order_id = ".escape_string($_GET['id'])."");
			confirmQuery($query);
			setMessage("Order Deleted");
			redirect("../../../public/admin/index.php?orders");
		}else{
			redirect("../../../public/admin/index.php?orders");
		}
	}
	/*********************Admin Products ***************************/
	function getProductsInAdmin(){
		global $connection;
		$query = query("SELECT * FROM products");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$product_id = $row['product_id'];
			$product_price = $row['product_price'];
			$product_title = $row['product_title'];
			$product_image = $row['product_image'];
			$product_quantity = $row['product_quantity'];
			$category = showProductCatTitle($row['product_category_id']);
			$result = '	<tr>
						<td>'.$product_id.'</td>
						<td>'.$product_title.'</td>
						<td><a href="index.php?edit_product&id='.$product_id.'"><img width="100" src="../../resources/uploads/'.$product_image.'"" alt=""></a></td>
						<td>'.$category.'</td>
						<td>'.$product_price.'</td>
						<td>'.$product_quantity.'</td>
						<td><a class="btn btn-primary" href="index.php?edit_product&id='.$product_id.'"><span class="glyphicon glyphicon-pencil"></span></a></td>
						<td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id='.$product_id.'""><span class="glyphicon glyphicon-remove"></span></a></td>
						</tr>
			';
			echo $result;
		}
	}
	/************** SHOW categories titles in admin page **************************/
	function showProductCatTitle($product_category_id){
		global $connection;
		$query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}'");
		confirmQuery($query);
		while($row = fetchArray($query)){
			return $row['cat_title'];
		}
	}
	function deleteProductInAdmin(){
	global $connection;
		if(isset($_GET['id'])){
			$query = query("DELETE FROM products WHERE product_id = ".escape_string($_GET['id'])."");
			confirmQuery($query);
			setMessage("Product Deleted");
			redirect("../../../public/admin/index.php?view_products");
		}else{
			redirect("../../../public/admin/index.php?view_products");
		}
	}	
/***************************** ADD products in admin  *****************************/	
	function addProduct(){
		global $connection;
		if(isset($_POST['publish'])){
			$product_title = escape_string($_POST['product_title']);
			$product_category_id = escape_string($_POST['product_category_id']);
			$product_price = escape_string($_POST['product_price']);
			$product_quantity = escape_string($_POST['product_quantity']);
			$product_description = escape_string($_POST['product_description']);
			$short_desc = escape_string($_POST['short_desc']);
			$product_image = escape_string($_FILES['file']['name']);
			$image_tmp = escape_string($_FILES['file']['tmp_name']);
			move_uploaded_file($image_tmp , UPLOAD_DIR . DS . $product_image);
			$query = query("INSERT INTO products(product_title,product_category_id,product_price,product_quantity,product_description,product_desc,product_image)
							VALUES('{$product_title}','{$product_category_id}','{$product_price}','{$product_quantity}','{$product_description}',
									'{$short_desc}','{$product_image}')");
			$last_id = lastId();
			confirmQuery($query);
			setMessage("Product with id {$last_id} Inserted successfully");
			redirect("index.php?view_products");

		}
	}
	/***************** Show the categories in the administration areas ************************/
	function showCategoriesInAdmin(){
		global $connection;
			$query = query("SELECT * FROM categories");
			confirmQuery($query);
			while($row = fetchArray($query)){
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];
				$result = '<option value="'.$cat_id.'">'.$cat_title.'</option>';
				echo $result;
			}
	}
	/********************* UPDATE PRODUCT *******************/
	function updateProduct(){
	global $connection;
		if(isset($_POST['update'])){
			$product_title = escape_string($_POST['product_title']);
			$product_category_id = escape_string($_POST['product_category_id']);
			$product_price = escape_string($_POST['product_price']);
			$product_quantity = escape_string($_POST['product_quantity']);
			$product_description = escape_string($_POST['product_description']);
			$short_desc = escape_string($_POST['short_desc']);
			$product_image = escape_string($_FILES['file']['name']);
			$image_tmp = escape_string($_FILES['file']['tmp_name']);
			if(empty($product_image)){
				$query =query("SELECT product_image FROM products WHERE product_id =" .escape_string($_GET['id'])."");
				confirmQuery($query);
				while($row = fetchArray($query)){
					$product_image = $row['product_image'];
				}
			}
			move_uploaded_file($image_tmp , UPLOAD_DIR . DS . $product_image);
			$query =  "UPDATE products SET ";
			$query .= "product_title       = '{$product_title}'        , ";
			$query .= "product_category_id = '{$product_category_id}'  , ";
			$query .= "product_price       = '{$product_price}'        , ";
			$query .= "product_quantity    = '{$product_quantity}'     , ";
			$query .= "product_description = '{$product_description}'  , ";
			$query .= "product_desc        = '{$short_desc}'           , ";
			$query .= "product_image       = '{$product_image}'          ";
			$query .= "WHERE product_id=" . escape_string($_GET['id']);
			$sendUpdateQuery = query($query);
			confirmQuery($sendUpdateQuery);
			setMessage("Product has been updated successfully");
			redirect("index.php?view_products");

		}
	}	
	/***************** Display reports ************************************/
	function showReports(){
		global $connection;
		$query = query("SELECT * FROM reports");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$report_id = $row['report_id'];
			$product_id = $row['product_id'];
			$order_id = $row['order_id'];
			$report_title = $row['product_title'];
			$report_price = $row['product_price'];
			$report_quantity = $row['product_quantity'];
			$result = ' <tr>
							<td>'.$report_id.'</td>
							<td>'.$product_id.'</td>
							<td>'.$order_id.'</td>
							<td>'.$report_title.'</td>
							<td>'.$report_price.'</td>
							<td>'.$report_quantity.'</td>
							<td><a class="btn btn-danger" href="../../resources/templates/back/delete_reports.php?id='.$report_id.'""><span class="glyphicon glyphicon-remove"></span></a></td>
						</tr>
			';
			echo $result;
		}
	}
	/****** Delete reports in administration area *************************/
	function deleteReports(){
		global $connection;
			if(isset($_GET['id'])){
				$query = query("DELETE FROM reports WHERE report_id = ".escape_string($_GET['id'])."");
				confirmQuery($query);
				setMessage("Product Deleted");
				redirect("../../../public/admin/index.php?reports");
			}else{
				redirect("../../../public/admin/index.php?reports");
			}
	}
	/***************** display categories in administration area *******************/
	function displayCatInAdmin(){
		global $connection;
		$query = query("SELECT * FROM categories");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$category_id = $row['cat_id'];
			$category_title = $row['cat_title'];
			$result = '<tr>
						<td>'.$category_id.'</td>
						<td>'.$category_title.'</td>
						<td><a class="btn btn-danger" href="../../resources/templates/back/delete_categories.php?id='.$category_id.'""><span class="glyphicon glyphicon-remove"></span></a></td>
					   <tr>
			';
			echo $result;
		}
	}
	/********* delete categories in the administration area **************/
	function deleteCategories(){
		global $connection;
			if(isset($_GET['id'])){
				$query = query("DELETE FROM categories WHERE cat_id = ".escape_string($_GET['id'])."");
				confirmQuery($query);
				setMessage("Category Deleted");
				redirect("../../../public/admin/index.php?categories");
			}else{
				redirect("../../../public/admin/index.php?categories");
			}
	}
	/******************** insert category in the database from the administration area **********************/
	function createCategory(){
		global $connection;
			if(isset($_POST['create_category'])){
				$cat_title = escape_string($_POST['cat_title']);
				if(empty($cat_title) || $cat_title == " "){
					setMessage ("<h4 class='bg-danger'>Please insert a category");
				}else{
					$query = query("INSERT INTO categories(cat_title) VALUES ('{$cat_title}')");
					confirmQuery($query);
					setMessage("Category inserted successfully");
					redirect("index.php?categories");
				}
			
			}
	}
	/**************** display users in the administration area ****************/
	function displayUsers(){
		global $connection;
		$query = query("SELECT * FROM users");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$result = ' <tr>
							<td>'.$row['id'].'</td>
							<td>'.$row['firstname'].'</td>
							<td>'.$row['lastname'].'</td>
							<td>'.$row['username'].'</td>
							<td><a href="index.php?edit_user&id='.$row['id'].'"><img class="img-responsive" width="80" heigth="50" src="../../resources/uploads/'.$row['picture'].'"" alt=""></a></td>
							<td><a class="btn btn-primary" href="index.php?edit_user&id='.$row['id'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>
							<td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id='.$row['id'].'""><span class="glyphicon glyphicon-remove"></span></a></td>
							<td></td>
						</tr>
			';
			echo $result;
		}
	}
	/****************************add user in admin area ****************************/
	function addUser(){
		global $connection;
		if(isset($_POST['add_user'])){
			$firstName = escape_string($_POST['firstname']);
			$lastName = escape_string($_POST['lastname']);
			$email = escape_string($_POST['email']);
			$userName = escape_string($_POST['username']);
			$password = escape_string($_POST['password']);
			$userImage = escape_string($_FILES['file']['name']);
			$image_tmp = escape_string($_FILES['file']['tmp_name']);
			move_uploaded_file($image_tmp , UPLOAD_DIR . DS . $userImage);
			$query = query("INSERT INTO users(firstname,lastname,email,username,password,picture)VALUES ('{$firstName}','{$lastName}','{$email}','{$userName}','{$password}','{$userImage}')");
			confirmQuery($query);
			setMessage("You have successfully added a user");
			redirect("index.php?users");
		}
	}
	/************************ Delete a user from administration table ********************************/
	function deleteUser(){
		global $connection;
			if(isset($_GET['id'])){
				$query = query("DELETE FROM users WHERE id = ".escape_string($_GET['id'])."");
				confirmQuery($query);
				setMessage("User Deleted");
				redirect("../../../public/admin/index.php?users");
			}else{
				redirect("../../../public/admin/index.php?users");
			}
	}
	/******************************UPDATE users from administration area **********************/
	function updateUser(){
		global $connection;
			if(isset($_POST['add_user'])){
				$firstName = escape_string($_POST['firstname']);
				$lastName = escape_string($_POST['lastname']);
				$userName = escape_string($_POST['username']);
				$email = escape_string($_POST['email']);
				$password = escape_string($_POST['password']);
				$picture = escape_string($_FILES['file']['name']);
				$image_tmp = escape_string($_FILES['file']['tmp_name']);
				if(empty($picture)){
					$query =query("SELECT picture FROM users WHERE id =" .escape_string($_GET['id'])."");
					confirmQuery($query);
					while($row = fetchArray($query)){
						$picture = $row['picture'];
					}
				}
				move_uploaded_file($image_tmp , UPLOAD_DIR . DS . $picture);
				$query =  "UPDATE users SET ";
				$query .= "firstname       = '{$firstName}'        , ";
				$query .= "lastname        = '{$lastName}'  , ";
				$query .= "username        = '{$userName}'        , ";
				$query .= "password        = '{$password}'     , ";
				$query .= "email           = '{$email}'  , ";
				$query .= "picture         = '{$picture}'          ";
				$query .= "WHERE id=" . escape_string($_GET['id']);
				$sendUpdateQuery = query($query);
				confirmQuery($sendUpdateQuery);
				setMessage("User has been updated successfully");
				redirect("index.php?users");
			}
	}
	/*************** Slides functions *************************************/
	/****************** ADD slides to database ***************************/
	function addSlides(){
		if(isset($_POST['add_slides'])){
			$slide_title = escape_string($_POST['slide_title']);
			$slide_image = escape_string($_FILES['file']['name']);
			$slide_image_loc = escape_string($_FILES['file']['tmp_name']);
			if(empty($slide_title) || empty($slide_image)){
				echo "<p class='bg-danger'>This field cannot be empty</p>";
			}else{
				move_uploaded_file($slide_image_loc , UPLOAD_DIR . DS . $slide_image);
				$query = query("INSERT INTO slides(slide_title,slide_image) VALUES ('{$slide_title}','{$slide_image}')");
				confirmQuery($query);
				setMessage("Slide Added");
				redirect("index.php?slides");
			}
		}
	}
	function getCurrentSlideInAdmin(){
		$query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$slideImage = $row['slide_image'];
			$result = '
            		<img class="img-responsive" src="../../resources/uploads/'.$slideImage.'"" alt="">

			';
			echo $result;
		}
	}
	function getSlides(){
		global $connection;
		$query = query("SELECT * FROM slides");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$slideImage = $row['slide_image'];
			$result = '
				<div class="item">
            		<img class="slide-image" src="../resources/uploads/'.$slideImage.'"" alt="">
        		</div>
			';
			echo $result;
		}
	}
	function getActiveSlides(){
		$query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$slideImage = $row['slide_image'];
			$result = '
				<div class="item active">
            		<img class="slide-image" src="../resources/uploads/'.$slideImage.'"" alt="">
        		</div>
			';
			echo $result;
		}
	}
	function getSlidesThumbnails(){
		$query = query("SELECT * FROM slides ORDER BY slide_id ASC");
		confirmQuery($query);
		while($row = fetchArray($query)){
			$slideImage = $row['slide_image'];
			$result = '
            		<div class="col-xs-6 col-md-3 image_container">
						<a href="index.php?delete_slide_id='.$row['slide_id'].'">
							<img class="img-responsive slide_image" src="../../resources/uploads/'.$slideImage.'"" alt="" alt="">
						</a>
						<div class="caption">
							<p>'.$row['slide_title'].'</p>
						</div>
					</div>

			';
			echo $result;
		}
	}
	/**********************Delete slides from admin area ***********************************/
	function deleteSlides(){
		global $connection;
		if(isset($_GET['delete_slide_id'])){
			$queryFindImage = query("SELECT slide_image FROM slides WHERE slide_id = ".escape_string($_GET['delete_slide_id'])." LIMIT 1 ");
			confirmQuery($queryFindImage);
			$row = fetchArray($queryFindImage);
			$targePath = UPLOAD_DIR . DS . $row['slide_image'];
			unlink($targePath);
			$query = query("DELETE FROM slides WHERE slide_id = ".escape_string($_GET['delete_slide_id'])."");
			confirmQuery($query);
			$targePath = "../../resources/uploads/";
			setMessage("Slide Deleted");
			redirect("index.php?slides");
		}else{
			redirect("index.php?slides");
		}
	}
?>