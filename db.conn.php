<?php 

# server name
$sName = "localhost:3306";
# user name
$uName = "wraithme_MetaAdmin";
# password
$pass = "r9V0aHUnNsuAF9vW2Z";

# database name
$db_name = "wraithme_company";

#creating database connection
try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}