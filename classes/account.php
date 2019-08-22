<?php
      //ran shoshani 6369
namespace aitsydney;


use aistsydney\Database;



class Account extends Database{
    public function __constructor(){
        parent::__constructor();
    }

    public function register( $email, $password ){
    $register_errors = array();
    if( filter_var ( $email, FILTER_VALIDATE_EMAIL ) == false ){
        $register_errors['email'] = 'invalid email address';
    }
    if( strlen( $password )< 8){
        $register_errors['password'] = 'minimum 8 characters';
    }

    if (count($register_errors) == 0){
        //hash the password
        $hash = password_hash( $password, PASSWORD_DEFAULT );
        //generate account id
        $id = $this -> createAacountId();
        //query to insert into database
        $qurey = " 
        INSERT INTO account ( acount_id,email,password,created,accessed,updated)
        VALUES ( ?,?, ?,NOW(),NOW(),NOW() )
        " ;
        try{
         $statement =  $this ->connection->prepare($qurey);
         if( $statement == false ){
            throw(new Exemption('query failed'));
        }
        $statement -> bind_param('sss', $id, $email, $hash);
        if( $statement -> execute() == false){
            throw( new Exemption('execute failed'));
        }
        else{
        //acount is created
        $register_response['errors'] = $register_errors;
      }
     }
     catch(Excemption $exc ){
         echo $exc -> getMessage();
         error_log( $exc -> getMessage());
     }
    }
     else{
         //return error message
         $register_response['errors'] = $register_errors;
         $refister_response['success'] = $fasle;
      }
      return $register_response;
    }


    public function createAacountId(){
        if ( function_exists('random_bytes')){
            $bytes = random_bytes(8);
        }
        else{
            $bytes = openssl_random_pseudo_bytes(8);
        }
        return bin2hex($bytes);
    }   



    public function login( $email, $password ){

    }
}
?>
