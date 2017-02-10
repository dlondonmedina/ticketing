<?php

class Report {
    private $conn;
    private $user;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->user = $_SERVER['REMOTE_USER'];
    }

    public function recordReport($vals) {
        $conn = $this->conn;
        $resolve = "unresolved";
        try {
            $stmt = $conn->prepare("INSERT INTO reports (netid, message, topic, urgency, status) values (:netid, :message, :topic, :urgency, :status);");
            $stmt->bindParam(':netid', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':message', $vals['message'], PDO::PARAM_STR);
            $stmt->bindParam(':topic', $vals['topic'], PDO::PARAM_STR);
            $stmt->bindParam(':urgency', $vals['urgency'], PDO::PARAM_STR);
            $stmt->bindParam(':status', $resolve, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Failed to save message with error: " . $e->getMessage();
            die();
        }
    }

    public function resolveTicket($vals) {
        $conn = $this->conn;
        if (in_array($this->id, ADMIN_USERS)) {
            // replace "resolved" with timestamp
            if(isset($vals['resolved'])) {
                $stmt = $conn->prepare('UPDATE reports SET status=REPLACE(status, "unresolved", "resolved") WHERE id=:id' );
                $stmt->bindParam(':id', $vals['ticket'], PDO::PARAM_INT);
                $stmt->execute();
            }
            if(!empty($vals['note'])) {
                $stmt = $conn->prepare('INSERT INTO notes (ticket, note, staff) VALUES (:ticket, :note, :staff)');
                $stmt->bindParam(':ticket', $vals['ticket'], PDO::PARAM_INT);
                $stmt->bindParam(':note', $vals['note'], PDO::PARAM_STR);
                $stmt->bindParam(':staff', $this->id, PDO::PARAM_STR);
                $stmt->execute();
            }
        } else {
            echo "You are not allowed to do this!";
            die();
        }
    }
}
