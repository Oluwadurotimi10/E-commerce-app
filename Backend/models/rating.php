<?php
    class Rating{
        //DB stuff
        private $conn;
        private $table = 'ratings';

        // rating Properties/ Attributes
        public $id;
        public $user_id;
        public $product_id;
        public $rating;
        public $created_at;

        public function __construct($db){
            $this->conn = $db;
        }

        public function rate(){
            //Create query
        $query = 'INSERT INTO
                '. $this->table .'
                SET 
                user_id = :user_id,
                product_id = :product_id,
                rating = :rating';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->product_id = htmlspecialchars(strip_tags($this->product_id));
    $this->rating = htmlspecialchars(strip_tags($this->rating));
    //$this->created_at = null;
   // $this->modified_at = null;

    //Bind data
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':product_id', $this->product_id);
    $stmt->bindParam(':rating', $this->rating);

    //Execute query
    if($stmt->execute()){
        return true; 
    }
    //Print error if something goes wrong
    printf("Error: %s.\n",$stmt->error);

    return false;
}

//getting the ratings users gave an item
public function display($product_id){
    $query = 'SELECT 
            user_id,
            rating
            FROM 
            '. $this->table .'
            WHERE 
            product_id = ?';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute([$product_id]);

    return $stmt;
    
    //fetching statemrnt
    //$row = $stmt->fetch(PDO::FETCH_ASSOC);
    //extract($row);
  
    //$this->user_id = $user_id;
    //$this->rating = $rating;

    }
}
    