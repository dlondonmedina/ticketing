<?php
class Retrieve {
    private $user;
    private $conn;

    /**
    *
    * Constructor function sets user variable and loads db connection
    * @param connection is db connection
    */
    public function __construct($conn) {
        $this->conn = $conn;
        $this->user = $_SERVER['REMOTE_USER'];
    }

    /**
    *
    * Administrator function to get reports from db
    * @param target is the userid for a particular user
    * @return results of db query
    */
    public function admin_retrieve($target = null) {
        // define db connection
        $conn = $this->conn;
        if(!in_array($this->user, ADMIN_USERS)) {
            header(TEMPLATES . 'access-denied.html');
        } else {
            $results = $this->get_results($target);
            return $results;
        }
    }

    /**
    * User function to get reports from db
    * @return results from db query
    */
    public function user_retrieve() {
        $conn = $this->conn;
        if(!in_array($this->user, REG_USERS) || !isset($this->user)) {
            header(TEMPLATES . 'access-denied.html');
        } else {
            $results = $this->get_results($this->user);
            return $results;
        }

    }

    /**
    *
    * Get results from database with or without target
    * @param target is the user whose results we should get.
    * @return results object from db query.
    */
    private function get_results($target = null) {
        //define db connection
        $conn = $this->conn;
        if ($target == null) {
            $results = $conn->prepare("SELECT * FROM results");
        } else {
            $results = $conn->prepare("SELECT * FROM results where netid=:netid");
            $results->bindParam(":netid", $target, PDO::PARAM_STR);
        }
        $results->execute();
        return $results;
    }

}
