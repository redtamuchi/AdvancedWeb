<?php 
namespace aitsydney;

use aitsydney\Product;

class ProductDetail extends Product{
    public $product_detail = array();

 public function __construct(){
     parent::__construct();
}

//get product detail by id
public function getProductDetail( $id){
    $query = "
    SELECT 
    product_id,
    name,
    description,
    price
    FROM product
    WHERE product_id = ?
    ";
    $statement = $this -> connection -> prepare( $query);
    $statement -> bind_param('i', $id);
    if( $statement -> execute()){
        $result = $statement -> get_result();
        $row = $result -> fetch_assoc();
        $this -> product_detail['product'] = $row;
       $this -> product_detail['images'] = $this -> getProductImages( $id);
       return $this -> product_detail;
    }
    
}
private function getProductImages( $id ){
    $images_query = "
    SELECT 
image_file_name
FROM 'product_image'
INNER JOIN image
ON product_image.image_id = image.image_id
WHERE product_id = ?
    ";
 $statement = $this -> connection -> prepare($images_query);
 $statement -> bind_param ( 'i' , $id );
 if( $statement -> execute()){
    $result = $statement -> get_result();
    $image_array = array();
    while( $row = $result -> fetch_assoc()){
        array_push( $image_array, $row['image_file_name']);
    }
    return $image_array;
 }

}
}

?>