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
    * @return success of recording ticket.
    */
    public function record_report($vals, $resolved = "unresolved") {
        $conn = $this->conn;
        try {
            $stmt = $conn->prepare("INSERT INTO reports (netid, message, topic,
                                    urgency, status) values (:netid, :message,
                                    :topic, :urgency, :status);");
            $stmt->bindParam(':netid', $this->user, PDO::PARAM_STR);
            $stmt->bindParam(':message', $vals['message'], PDO::PARAM_STR);
            $stmt->bindParam(':topic', $vals['topic'], PDO::PARAM_STR);
            $stmt->bindParam(':urgency', $vals['urgency'], PDO::PARAM_STR);
            $stmt->bindParam(':status', $resolved, PDO::PARAM_STR);
            $stmt->execute();
            $info = array(
                'user' => $this->user,
                'message' => $vals['message'],
                'topic' => $vals['topic'],
                'urgency' => $vals['urgency'],
            );
            $this->email_report($info);
        } catch (Exception $e) {
            echo "Failed to save message with error: " . $e->getMessage();
            die();
        }
    }

    /**
    * Send email of new report to tech staff.
    * @param array info for email.
    */
    private function email_report($info = array()) {
        $to = '';
        foreach ( ADMIN_USERS as $admin ) {
            $to .= $admin . '@uw.edu, ';
        }
        // remove final comma and space
        $to = substr($to, 0, -2);

        $subject = 'Urgency[' . $info['urgency'] . '] ' . $info['topic'];
        $message = '
        <html>
        <head>
            <title>Helpdesk Message from ' . $info['user'] . '</title>
        </head>
        <body>
            <p>
            Dear IT Team,

            I hope you\'re having a wonderful day! I\'m having an issue with ' .
            $info['topic'] . ' and I would love it if you could help me at your
            nearest convenience.
            </p>
            <p>
                '. $info['message'] .'
            </p>
        </body>
        </html>';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html, charset=iso-8859-1';
        $headers[] = 'To: ' . $to;
        $headers[] = 'From: ' . $info['user'] . '@uw.edu';

        // Mail it
        try {
            mail($to, $subject, $message, implode("\r\n", $headers));
        } catch (Exception $e) {
            echo "I'm sorry, that didn't work. Failed with Error: " . $e->getMessage();
        }

    }

    /**
    * Resolve ticket or update ticket with note.
    * @param vals is an array of resolution info.
    * vals = (resolved=>'', 'ticket'=>'ticket_id', 'note'=> '')
    */
    public function resolve_ticket($vals) {
        $conn = $this->conn;
        if (in_array($this->user, ADMIN_USERS)) {
            if(isset($vals['resolved'])) {
                $res = date('m/d/y @ h:m');
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

    /**
    * Reports an event.
    * @param vals is the array of values from the form
    */
    public function record_event($vals) {
        $conn = $this->conn;
        try {

        } catch (PDOException $e) {
            echo "Failed to save event with error: " . $e->getMessage();
            die();
        } catch (Exception $e) {
            echo "Something else went wrong with error: " . $e->getMessage();
            die();
        }
    }

    /**
    *
    * Report a publication
    * @param vals is an array of values from the form
    */
    public function record_publication($vals) {
        $con = $this->conn;
        $edition = !empty($vals['edition']) ? $vals['edition'] : 0;
        $volume = !empty($vals['volume']) ? $vals['volume'] : 0;
        $number = !empty($vals['number']) ? $vals['number'] : 0;
        try {
            $stmt = $con->prepare("INSERT INTO publications (
                                    netid,
                                    title,
                                    publication,
                                    edition,
                                    volume,
                                    num,
                                    pub_date,
                                    pages,
                                    type) VALUES (
                                    :netid,
                                    :title,
                                    :publication,
                                    :edition,
                                    :volume,
                                    :num,
                                    :pub_date,
                                    :pages,
                                    :type);");
            $stmt->bindParam(':netid', $this->user, PDO::PARAM_STR);
            $stmt->bindParam(':title', $vals['title'], PDO::PARAM_STR);
            $stmt->bindParam(':publication', $vals['publication'], PDO::PARAM_STR);
            $stmt->bindParam(':edition', $edition, PDO::PARAM_INT);
            $stmt->bindParam(':volume', $volume, PDO::PARAM_INT);
            $stmt->bindParam(':num', $number, PDO::PARAM_INT);
            $stmt->bindParam(':pub_date', $vals['pub_date'], PDO::PARAM_STR);
            $stmt->bindParam(':pages', $vals['pages'], PDO::PARAM_STR);
            $stmt->bindParam('type', $vals['type'], PDO::PARAM_STR);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Failed to save event with error: " . $e->getMessage();
            die();
        } catch (Exception $e) {
            echo "Something else went wrong with error: " . $e->getMessage();
            die();
        }
    }
}
