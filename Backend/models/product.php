<?php
    class Product{
        //DB stuff
        private $conn;
        private $table = 'products';

        // Post Properties/ Attributes

        public $id;
        public $category_id;
        public $admin_id;
        public $brand_id;
        public $category_name;
        public $admin_name;
        public $brand_name;
        public $name;
        public $description;
        public $skin_type;
        public $image;
        public $quantity;
        public $price;
        public $created_at;
        public $modified_at;

        //Constructor with DB (just like init method in python)
        public function __construct($db) {
            $this->conn = $db;
        } 

        //Get Products  (methods)
        public function read(){
            //Create query
        $query = "SELECT 
            c.name as category_name,
            u.username as admin_name,
            br.name as brand_name,
            p.id,
            p.category_id,
            p.admin_id,
            p.brand_id,
            p.name,
            p.description,
            p.skin_type,
            p.image,
            p.price,
            p.created_at,
            p.modified_at
            FROM
            ". $this->table ." p
            LEFT JOIN 
            categories c ON p.category_id = c.id
            LEFT JOIN
            users u ON p.admin_id = u.id
            LEFT JOIN
            brands br ON p.brand_id = br.id
            ORDER BY 
            p.created_at ASC";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }

     //Create Post
     public function create(){
        //Create query
        $query = 'INSERT INTO
            '. $this->table .'
            SET 
            name = :name,
            description = :description,
            skin_type = :skin_type,
            quantity = :quantity,
            image = :image,
            price = :price,
            admin_id = :admin_id,
            brand_id = :brand_id,
            category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->skin_type = htmlspecialchars(strip_tags($this->skin_type));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id)); 
        $this->brand_id = htmlspecialchars(strip_tags($this->brand_id)); 
        $this->category_id = htmlspecialchars(strip_tags($this->category_id)); 
        //$this->created_at = null;
        //$this->modified_at = null;


        //Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':skin_type', $this->skin_type);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':admin_id', $this->admin_id);
        $stmt->bindParam(':brand_id', $this->brand_id);
        $stmt->bindParam(':category_id', $this->category_id);
    
        //Execute query
        if($stmt->execute()){
            return true;
        }
        //Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);

        return false;
    }

    //Update Post
    public function update(){
        //Create query
        $query = 'UPDATE 
                '. $this->table .'
                SET 
                name = :name,
                description = :description,
                skin_type = :skin_type,
                quantity = :quantity,
                image = :image,
                price = :price,
                brand_id = :brand_id,
                category_id = :category_id
                WHERE   
                id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->skin_type = htmlspecialchars(strip_tags($this->skin_type));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->brand_id = htmlspecialchars(strip_tags($this->brand_id)); 
        $this->category_id = htmlspecialchars(strip_tags($this->category_id)); 
        $this->id = htmlspecialchars(strip_tags($this->id));
        //$this->modified_at = null;

        //Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':skin_type', $this->skin_type);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':brand_id', $this->brand_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        
        //Execute query
        if($stmt->execute()){
            return true;
        }else{
        //Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);

        return false; }
    }

     //for reading the details of post to be edited 
     public function readOne(){
  
        $query = "SELECT
                    c.name as category_name,
                    br.name as brand_name,
                    p.name,
                    p.description,
                    p.skin_type,
                    p.quantity,
                    p.price,
                    p.image,
                    p.category_id,
                    p.admin_id,
                    p.brand_id,
                    p.created_at,
                    p.modified_at
                FROM
                    " . $this->table . " p
                LEFT JOIN 
                categories c ON p.category_id = c.id
                LEFT JOIN 
                brands br ON p.brand_id = br.id
                WHERE
                    p.id = ?
                LIMIT
                    0,1";
        //prepare statement
        $stmt = $this->conn->prepare( $query );

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding the first id to the variable
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();
        
        //fetching statemrnt
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
      
        $this->name = $name;
        $this->description = $description;
        $this->brand_name = $brand_name;
        $this->category_name = $category_name;
        $this->skin_type = $skin_type;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->image = $image;
        $this->category_id = $category_id;
        $this->brand_id = $brand_id;
        $this->admin_id = $admin_id;
        $this->created_at = $created_at;
        $this->modified_at = $modified_at;
    } 

    // delete the product
    function delete(){
        
        $query = "DELETE FROM
                " . $this->table . "
                WHERE 
                id = ?";

        //prepare statements
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(1, $this->id);
    
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}