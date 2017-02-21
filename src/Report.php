<?php
/**
* This class is the report object. It has methods to create a new ticket.
* It also has a method to resolve tickets.
*/

class Report {
    private $conn;
    private $user;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->user = $_SERVER['REMOTE_USER'];
    }

    /**
    * Create a new report in the databases.
    * @param vals is an array of values from the form.
    * @param resolved is the resolution state of the ticket. Default unresolved.
    */
    public function record_report($vals, $resolved = "unresolved") {
        $conn = $this->conn;
        try {
            $stmt = $conn->prepare("INSERT INTO reports (netid, message, topic, urgency, status) values (:netid, :message, :topic, :urgency, :status);");
            $stmt->bindParam(':netid', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':message', $vals['message'], PDO::PARAM_STR);
            $stmt->bindParam(':topic', $vals['topic'], PDO::PARAM_STR);
            $stmt->bindParam(':urgency', $vals['urgency'], PDO::PARAM_STR);
            $stmt->bindParam(':status', $resolve, PDO::PARAM_STR);
            $stmt->execute();
            // would be good to flash a success message here.
        } catch (Exception $e) {
            echo "Failed to save message with error: " . $e->getMessage();
            die();
        }
    }

    /**
    * Resolve ticket or update ticket with note.
    * @param vals is an array of resolution info.
    * vals = (resolved=>'', 'ticket'=>'ticket_id', 'note'=> '')
    */
    public function resolveTicket($vals) {
        $conn = $this->conn;
        if (in_array($this->id, ADMIN_USERS)) {
            if(isset($vals['resolved'])) {
                $res = date('m/d/y @ h:m');
                $stmt = $conn->prepare('UPDATE reports SET status=REPLACE(status, "unresolved", :res) WHERE id=:id' );
                $stmt->bindParam(':res', $res, PDO::PARAM_STR);
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
