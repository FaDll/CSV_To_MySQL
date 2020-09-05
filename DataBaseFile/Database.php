<?php

class Database{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $conn;
    public static $instance;

    private function __construct($sn , $us , $pw , $dbn){
        $this->servername = $sn;
        $this->username = $us;
        $this->password = $pw;
        $this->dbname = $dbn;
        if(self::$instance == NULL){
            self::$instance = $this;
            $this->startConnection();
        }
    }

    function startConnection(){
        if($this->conn == NULL){
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        }

        if(!$this->conn){
            echo "Database Connection Failed";
        }
        else{
            //echo "Database Connection Succeeded";
        }
    }

    public static function getInstance($dbname){
        if(self::$instance == NULL){
            $db = new Database("localhost", "root", "", $dbname);
        }
        return self::$instance;
    }

    function insert($tableName , $fieldsName , $data){
        $fields = "";
        $values = "";
        for($i = 0 ; $i < count($fieldsName) ; $i++){
            $fields = $fields.$fieldsName[$i].",";
            $values = $values."'".$data[$i]."',";
        }

        $fields = substr($fields , 0 , strlen($fields) - 1);
        $values = substr($values , 0 , strlen($values) - 1);

        $sql = "insert into ".$tableName." (".$fields.") values (".$values.") "; 
        //echo "Sql = ".$sql;
        
        if(mysqli_query($this->conn, $sql)){
            //echo "Insertion Succeeded";
            return true;
        }
        else{
            //echo "Insertion Failed";
            return false;
        }
    }

    function selectWhere($tableName)
    {
        echo "<style>
        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100%;
          border: 1px solid #ddd;
        }
        
        th, td {
          text-align: left;
          padding: 16px;
        }
        
        tr:nth-child(even) {
          background-color: #f2f2f2;
        }
        </style>";

        
            $sql = "select * from ".$tableName.'';
            $result = mysqli_query($this->conn, $sql);
            $resul_per_page=10;
            $number_of_results=mysqli_num_rows($result);
            
            $number_of_pages= $number_of_results/$resul_per_page;
             
             if(!isset($_GET['page']))
             {
                 $page=1;

             }
             else
             {
                 $page=$_GET['page'];
             }

            $this_page_first_result=($page-1)*$resul_per_page;
            $sql2="SELECT * FROM ".$tableName.' '.'LIMIT'.' '.$this_page_first_result.','.$resul_per_page;
            $result2= mysqli_query($this->conn, $sql2);


            echo "
                <table id = 'tbl' class = 'table table-striped table-light'>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Deal</th>
                    <th>Hour</th>
                    <th>Accepted</th>
                    <th>Rejected</th>
                    </tr>
                    </thead>
                    <tbody>";
            while($row2=mysqli_fetch_array($result2))
            {
                echo "<tr>
                <td>".$row2['id']."</td>
                <td>".$row2['client']."</td>
                <td>".$row2['deal']."</td>
                <td>".$row2['hour']."</td>
                <td>".$row2['accepted']."</td>
                <td>".$row2['refused']."</td>
                </tr>";
            }
            echo "</tbody>
            </table>";

            //$starting_limit_number=($page_number-1)*$resul_per_page;


             for($page=1; $page<=$number_of_pages; $page++)
             {
                 echo '<a href="ShowTable.php?page='. $page . '">'. $page . '</a> ';
             }

    }

    function CreateDB($Username,$Password,$dbname)
    {

            $servername = "localhost";
            $username = $Username;
            $password = $Password;

            // Create connection
            $conn = new mysqli($servername, $username, $password);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

            // Create database
            $sql = "CREATE DATABASE ".$dbname."";
            if ($conn->query($sql) === TRUE)
            {
                echo "Database created successfully";
            }
            else
            {
                echo "Error creating database: " . $conn->error;
            }

            $conn->close();

            
            

    }

    function CreateTable($tableName)
    {
        $sql="CREATE TABLE ".$tableName." (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            client VARCHAR(30) NOT NULL,
            deal VARCHAR(30) NOT NULL,
            hour DATETIME,
            accepted INT,
            refused TINYINT)";

        echo $sql;

        $result = mysqli_query($this->conn, $sql);

        return $result;
          
    }

    function DropDatabase($dbname)
    {
        $sql = "DROP DATABASE".' '.$dbname;
        $result = mysqli_query($this->conn, $sql);
   
        if(!$result)
        {
           die('Could not delete database');
        }
        else
        {
            echo "Database deleted successfully\n";
            echo "<script>window.location.replace('Home.php');</script>";
        }

    }     

    

    function closeConnection()
    {
        $this->conn->close();
    }
}
?>