<!DOCTYPE html>

<html>
    <head>
            <title>Task3</title>
    </head>



    <body>

    <?php
      
      session_start();
      include "DataBaseFile/Database.php";

        if(isset($_POST['CreateDataBase']))
        { 
            $DbObj=Database::CreateDB($_POST['UserName'],$_POST['Password'],$_POST['Dbname']);
            $_SESSION['dbName']=$_POST['Dbname'];
            $Dbobj=Database::getInstance($_POST['Dbname']);
            $Dbobj->CreateTable($_POST['TableName']);
            header("location:ImportCSV.php");
        } 

    ?>
        

         <form method='POST'>    
         <div align="center">

            <p> please enter your desired database username, password,name and table name</p>
            <input type="text"   name="UserName"  placeholder="UserName"required>
            <input type="text"   name="Password"  placeholder="Password">
            <input type="text"   name="Dbname"  placeholder="DataBase Name"required>
            <input type="text"   name="TableName"  placeholder="Table Name" required>
            <input type="submit" name="CreateDataBase"value="CreateDataBase"/>
            
         </div>
     </form>
    </body>