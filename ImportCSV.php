<!DOCTYPE html>

<html>
    <head>
            <title>Task3</title>
    </head>



    <body>

    <?php
      session_start();
      include "DataBaseFile/Database.php";
        
        if(isset($_POST['submit']))
        {   
            if($_FILES['File']['name'])
            {
                $filename=explode(".", $_FILES['File']['name']);
                $Dbobj=Database::getInstance($_SESSION['dbName']);
                $fields=array("client","deal","hour","accepted","refused");
               
                if($filename[1]=='csv')
                {
                    $handler= fopen($_FILES['File']['tmp_name'],"r");
                    fgetcsv($handler);
                    while($data=fgetcsv($handler))
                    {
                            $values=array($data[0],$data[1],$data[2],$data[3],$data[4]);
                            $Dbobj->insert('user',$fields,$values);
                    }

                    fclose($handler);
                    echo "import Done";
                    header("location:ShowTable.php");
                 }
            }
        }
    ?>
    
         <form method='POST' enctype="multipart/form-data">
         <div align="center">
            
            <p> Upload CSV:</p>
            <input type="file"   name="File" required>
            <input type="submit" name="submit"value="Import"/>
            

         </div>
     </form>
    </body>