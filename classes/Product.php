<?php
namespace aitsydney;
use aitsydney\Database;
class Product extends Database{
    public $products = array();
    public $category = null;    

    public function __construct(){
    parent::__construct();
        if( isset($_GET['category_id'])){
            $this -> category = $_GET['category_id'];
        }
    }
public function getProducts(){
    $query = " SELECT
    @product_id := product.product_id as product_id,
    product.name,
    product.description,
    product.price,
    @image_id := ( SELECT image_id FROM product_image WHERE product_id = @product_id LIMIT 1) as image_id,
    ( SELECT image_file_name FROM image WHERE image_id = @image_id ) as image
    FROM product";

    if ( isset( $this -> category ) ){
        $query = $query .
        " " .
        "
        INNER JOIN
        product_category
        ON product_category.product_id = product.product_id 
        WHERE product_category.category_id = ? ";
    }

        $statement = $this -> connection -> prepare( $query );
        if( isset($this -> category ) ){
            $statement -> bind_param('i', $this -> category );
        }


        if( $statement -> execute() ){
            $result = $statement -> get_result();
            while ( $row = $result -> fetch_assoc() ){
                array_push( $this -> products, $row );
            }
        }
        return $this -> products;
    }

//get product details
public function getProductDetail( $id ){
    $query =" SELECT product_id, name,description,price FROM product WHERE product_id = ?";
    
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('i',$this -> category);
    if($statement -> execute()){
        $product_detail = array();
        $result = $statement -> get_result();
        $row = $result -> fetch_assoc();
        $product_detail['product'] = $row;
        return $product_details;
        }
    
    }
}
?>