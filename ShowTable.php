<body>
<?php

session_start();
include "DataBaseFile/Database.php";
$Dbobj=Database::getInstance($_SESSION['dbName']);
$Dbobj->selectWhere('user');

    if(isset($_POST['DropDataBase']))
    { 
        $Dbobj->DropDatabase($_SESSION['dbName']);
        session_unset();
    } 
?>
    

<form method='POST'>    

     <div align="center">

        <p>if you want to drop the database please click here</p>
        <input type="submit" name="DropDataBase"value="DropDataBase"/>

     </div>
 </form>
</body>