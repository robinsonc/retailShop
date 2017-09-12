<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include "config.php";

	// Get the Product once you scan the barcode

	$barcode=$_POST['barcode'];
	$products_query = "SELECT * from products where products.bar_code=".$barcode;
	$products = $mysqli->query($products_query);

	$row=mysqli_fetch_array($products,MYSQLI_ASSOC);

    if(count($row) > 0)
    {
        // Get the Frequently Bought Products
        $frequently_bought=array();
        $viewed_products=array();
        $shopper_products=array();
        $frequently_bought_query = "SELECT * from product_recommendation join products on products.id=product_recommendation.recommended_id where category_id=1 and product_id =".$row['id']." ORDER BY RAND() LIMIT 3";

        $frequently_bought_result = $mysqli->query($frequently_bought_query);

        while($frequently_bought_rows=mysqli_fetch_array($frequently_bought_result,MYSQLI_ASSOC))
        {
            $frequently_bought[]=$frequently_bought_rows;
        }

        $row['frequently_bought']= $frequently_bought;


        // Get the Viewed Products

        $viewed_products_query = "SELECT * from product_recommendation join products on products.id=product_recommendation.recommended_id where category_id=2 and product_id =".$row['id']." ORDER BY RAND() LIMIT 3";

        $viewed_products_result = $mysqli->query($viewed_products_query);

        while($viewed_products_rows=mysqli_fetch_array($viewed_products_result,MYSQLI_ASSOC))
        {
            $viewed_products[]=$viewed_products_rows;
        }

        $row['viewed_products']=$viewed_products;

        // Get the Shopper Stop Products

        $shopper_products_query = "SELECT * from product_recommendation join products on products.id=product_recommendation.recommended_id where category_id=3 and product_id =".$row['id']." ORDER BY RAND() LIMIT 3";

        $shopper_products_result = $mysqli->query($shopper_products_query);

        while($shopper_products_rows=mysqli_fetch_array($shopper_products_result,MYSQLI_ASSOC))
        {
            $shopper_products[]=$shopper_products_rows;
        }

        $row['shopper_products']=$shopper_products;

        // Idle time out

        $configuration_query = "SELECT * from configuration where id=1";
        $configuration = $mysqli->query($configuration_query);

        $configuration=mysqli_fetch_array($configuration,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        header("Content-Type:application/json");
        print_r(json_encode(["error"=>false,"message"=>"success","products"=>$row,"configuration"=>$configuration]));
    }
    else
    {
        header("HTTP/1.1 204 No Content");
        print_r(json_encode(["error"=>true,"message"=>"No Products","products"=>$row]));
    }

	

?>
