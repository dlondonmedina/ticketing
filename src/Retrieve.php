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
        if(!in_array($this->user, ADMIN_USERS)) {
            header('404.php');
        } else {
            $out= $this->get_results($target);
            return $out;
        }
    }

    /**
    *
    * Get list of users who have submitted tickets.
    * @param all_users sets whether to get users with open tickets
    * or all users.
    * @return users associative array of users from table.
    */
    public function get_users($all_users = true) {
        if (!in_array($this->user, ADMIN_USERS)) {
            header('404.php');
        } else {
            // define db connection
            $conn = $this->conn;
            if($all_users) {
                $stmt = $conn->prepare("SELECT DISTINCT netid FROM hd_reports");
            } else {
                $unresolved = "unresolved";
                $stmt = $conn->prepare(
                "SELECT DISTINCT netid FROM hd_reports where status=:status"
            );
            $stmt->bindParam(":status", $unresolved, PDO::PARAM_STR);
        }
        $stmt->execute();
        $out = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $out;

        }
    }

    /**
    * User function to get reports from db
    * @return results from db query
    */
    public function user_retrieve() {

        if (!isset($this->user)) {
            header('Location: index.php');
        } elseif (in_array($this->user, ADMIN_USERS)) {
            $out = $this->admin_retrieve();
        } elseif (in_array($this->user, REG_USERS)) {
            $out = $this->get_results($this->user);
        } else {
            header('404.php');;
        }

        return $out;

    }

    /**
    *
    * Get results from database with or without target
    * @param target is the user whose results we should get.
    * @return results associative array of all rows in table.
    */
    private function get_results($target = null) {
        //define db connection
        $conn = $this->conn;
        if (!$target) {
            $stmt = $conn->prepare("SELECT * FROM hd_reports");
        } else {
            $stmt = $conn->prepare("SELECT * FROM hd_reports where netid=:netid");
            $stmt->bindParam(":netid", $target, PDO::PARAM_STR);
        }
        $stmt->execute();
        $out = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $out;
    }

    /**
    *
    * Get publications with or without a target
    * @param target is the user whose pubs you want.
    * @return results associative array of all rows of data.
    */
    private function get_publications($target = null) {
        // define db connection
        $conn = $this->conn;
        if (!$target) {
            $stmt = $conn->prepare("SELECT * from publications");
        } else {
            $stmt = $conn->prepare("SELECT * FROM publications WHERE netid=:netid");
            $stmt->bindParam(":netid", $target, PDO::PARAM_STR);
        }
        $stmt->execute();
        $out = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $out;

    }


    private function get_author($target) {
        $conn = $this->conn;
        try {
            $stmt = $conn->prepare("SELECT Last, First, Middle from people WHERE uwnetid=:netid");
            $stmt->bindParam(":netid", $target, PDO::PARAM_STR);
            $stmt->execute();
            $out = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Something went wrong getting authors: " . $e->getMessage();
            die();
        }
        return $out;

    }

    private function get_overflow_authors($target) {
        $conn = $this->conn;
        try {
            $stmt = $conn->prepare("SELECT fname, lname from author_overflow
                                    WHERE pub_id=:id");
            $stmt->bindParam(":id", $target, PDO::PARAM_INT);
            $stmt->execute();
            $out = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Something went wrong: " . $e->getMessage();
            die();
        }
        return $out;
    }

    public function retrieve_pubs($filter=null) {
        $results = [];


        $pubs = $this->get_publications($filter);
        foreach ($pubs as $pub) {
            $over_auths = $this->get_overflow_authors($pub['id']);
            $auth = $this->get_author($pub['netid']);
            array_push($results, [$auth, $over_auths, $pub]);
        }


        return $results;
    }

}
