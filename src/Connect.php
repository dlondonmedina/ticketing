<?php
/**
* Class connects to databases using default config file if not otherwise specified
*/
class Connect {
   public $connection;
   protected $host;
   protected $db;
   protected $uname;
   protected $pword;

   /**
   * Constructor sets credentials for the object
   *
   * @param credentials takes an array of credentials
   * $credentials = array(
   *    'mysql_host' => '',
   *    'mysql_database' => '',
   *    'mysql_username' => '',
   *    'mysql_password' => ''
   * )
   *
   */
   public function __construct($credentials = null) {
     // Check for alternate db credentials array
     if (!empty($credentials)) {
       $this->host = $credentials['mysql_host'];
       $this->db = $credentials['mysql_database'];
       $this->uname = $credentials['mysql_username'];
       $this->pword = $credentials['mysql_password'];
     } else { //use default credentials
       $this->host = MYSQL_HOST;
       $this->db = MYSQL_DATABASE;
       $this->uname = MYSQL_USERNAME;
       $this->pword = MYSQL_PASSWORD;
     }
   }

   /**
   * Connect to the database
   *
   * @param credentials is an array of credentials if you want to use another db
   * @return bool false on failure / PDO object instance on success
   */
   public function connect() {
     // Try and connect to the database.
     if(!isset($this->connection)) {
       try {
          // Establish connection
          $this->connection = new PDO('mysql:host='. $this->host.';dbname='. $this->db.';charset=utf8mb4',
           $this->uname, $this->pword, array(
             PDO::ATTR_EMULATE_PREPARES => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

       } catch (PDOException $ex) {
          echo "Connection failed!";
          echo "<br />Error message: " . $ex->getMessage();
          die();
      } catch (Exception $e) {
          echo "General Error: " . $e->getMessage();
      }
     }
     return $this->connection;
   }



}
