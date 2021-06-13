<?php 

    class Brand{
        //DB stuff
        private $conn;
        private $table = 'brands';

        // category Properties/ Attributes
        public $id;
        public $name;
        public $admin_id;
        public $created_at;
        
        public function __construct($db){
            $this->conn = $db;
        }

         //Create brand
         public function create(){
            //Create query
            $query = 'INSERT INTO
                '. $this->table .'
                SET 
                name = :name,
                admin_id = :admin_id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));  
            $this->created_at = null;

            //Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':admin_id', $this->admin_id);
        
            //Execute query
            if($stmt->execute()){
                return true;
            }
            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);

            return false;
        }
       
        // get category names for the dropdown
        public function read(){
            $query = 'SELECT
                        b.id,
                        b.name
                        FROM 
                        '. $this->table .' b
                        ORDER BY 
                        b.name';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }

        //used to read category name by its ID
        function readName(){
            $query = "SELECT
                     name
                     FROM
                     ". $this->table ." 
                     WHERE 
                     id=? 
                     limit 0,1";
            
            //prepare statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
        } 
    }

?>
