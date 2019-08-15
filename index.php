<?php
require('vendor/autoload.php');

use aitsydney\Navigation;

$nav = new Navigation();
$navigation = $nav -> getNavigation();

use aitsydney\Product;

//create categories
use aitsydney\Category;

$cat = new Category();
$categories = $cat -> getcategories();


//creat an instance of Product class
$products = new Product();
$products_result = $products -> getProducts();

//create twig loader
//$loader = new \Twig\Loader\Filesystem('templates');
$loader = new Twig_Loader_Filesystem('templates');

//create twig environment
$twig = new Twig_Environment($loader);

//load a twig template
$template = $twig -> load('home.twig');

//pass values to twig
echo $template -> render(array(
    'categories' => $categories,
    'navigation' => $navigation,
    'products' => $products_result,
    'title' => 'Hello shop'
));
?>