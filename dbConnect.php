<?php
    function connectDB()
    {
	    $host="localhost";
	    $db="Project2";
	    $user="phpuser";
	   	$pwd="password123";

	    //$db="u450059702_Project2";
	    //$user="u450059702_ericluke";
	    //$pwd="Thunder23$!";


	    $attr="mysql:host=$host;dbname=$db";
	    $opts=[
		    PDO::ATTR_ERRMODE			=>PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES	=>False
	    ];
        try{
  		    $pdo=new PDO($attr,$user,$pwd, $opts);
  		    return $pdo;
        }
        catch(PDOException $e)	
  	    {
  		    throw new Exception($e->getMessage(), (int)$e->getCode()); 	
  	    }
    }
	

?>