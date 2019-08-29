<?php


/// Ran Shoshani   

require('vendor/autoload.php');

use aitsydney\Navigation;
use aitsydney\Account;


$nav = new Navigation();
$navigation = $nav -> getNavigation();
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //create an instance of account class
 
    $acc = new Account();
    $register = $acc -> register ( $email, $password );
}else{
$register = '';

}


//create twig loader
//$loader = new \Twig\Loader\Filesystem('templates');
$loader = new Twig_Loader_Filesystem('templates');

//create twig environment
$twig = new Twig_Environment($loader);

//load a twig template
$template = $twig -> load('register.twig');

//pass values to twig
echo $template -> render(array(
    'register' => $register,
    'navigation' => $navigation,
    'title' => 'Register for an account'
));

?>