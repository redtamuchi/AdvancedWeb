<?php
require('vendor/autoload.php');

use aitsydney\Product;

//creat an instance of Product class
$p = new Product();
$products = $p -> getProducts(); // $p->getProducts();

// print_r($products);

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
//call a twig template
$template = $twig -> load('home.twig');
//output the tamplate and data 
echo $template -> render(array('products' => $products,'title' => "welcome to the shop"));
?>