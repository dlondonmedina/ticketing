<?php
class Table
{
    public function display_results($results)
    {
        $str = '';
    // Get the first row and headings
    $result = $results->fetch(PDO::FETCH_ASSOC);
        $headings = array_keys($result);
        $str .= '<table class="table table-striped"><thead><tr><th></th>';
        foreach ($headings as $heading) {
            $str .= '<th>' . $heading . '</th>';
        }
        $str .= '</tr></thead><tbody>';
        $str .= '<tr class="'. $result['status'] . '">';

   // Display the first row
   foreach ($result as $k=>$v) {
       $str .= '<td>' . $v . '</td>';
   }
        $str .= '</tr>';

   // Get the rest of the rows
   while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
       $str .= '<tr class="' . $row['status'] . '">';
       foreach ($row as $k=>$v) {
           $str .= '<td>' . $v . '</td>';
       }
       $str .= '</tr>';
   }
        $str .= '</tbody></table>';

        return $str;
    }

    public function display_dropdown($results)
    {
        $str = '';
        $result = $results->fetchAll(PDO::FETCH_COLUMN);
        foreach ($result as $v) {
            echo '<option value="'. $v . '">' . $v . '</option>';
        }
    }

    public function display_admin($results)
    {
        $str = '';

        $result = $results->fetch(PDO::FETCH_ASSOC);
        $headings = array_keys($result);

    // start table
    $str .= '<table id="myTable" class="table table-striped">
        <thead><tr><th></th></tr>';
        foreach ($headings as $heading) {
            $str .= '<th>' . $heading .'</th>';
        }
        $str .= '</tr></thead><tbody>';
    //Display first row
    if ($result['status'] === 'unresolved') {

        $str .= '
            <tr onclick="displayModal(' . $result['id'] . ')" id="ticket_'
            . $result['id'] . '" class="table-row click-me" data-toggle="modal"
            data-target="#myModal">';

        foreach ($result as $k=>$v) {
            $str .= '<td class="' . $k . '">' . $v . '</td>';
        }

        $str .= '</tr>';
    }

    // Get the rest of the rows and display
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] === 'unresolved') {
            $str .= '
                <tr onclick="displayModal(' . $row['id'] . ')" id="ticket_' .
                $row['id'] . '" class="' . $row['status'] . ' click-me"
                data-toggle="modal" data-target="#myModal">';

            foreach ($row as $k=>$v) {
                $str .= '<td class="' . $k . '">' . $v .'</td>';
            }
            $str .= '</tr>';
        }
    }

        $str .= '</tbody></table>';
        return $str;
    }

    public function display_modal($results)
    {
        if (isset($results)) {
            $report = $results->fetch(PDO::FETCH_ASSOC);
        }
        $str .= '
            <table><tbody><tr><th></th><th>Ticket</th></tr>
            <tr><th>ID:</th><td>' . $report['id'] . '</td></tr>
            <tr><th>Name:</th><td>' . $report['netid'] . '</td></tr>
            <tr><th>Date:</th><td>' . $report['time'] . '</td></tr>
            <tr><th>Status:</th><td>' . $report['status'] . '</td></tr>
            </tbody></table><br />';

        $str .= '<p>' . $report['message'] .'</p>';
        return $str;
    }
}
