<?php
/**
* This is a view class that displays results in a table format.
* Constructor class takes results.
*/
class Table
{

    /**
    * Create results table with results array keys as headings.
    * @param results is associative array
    * @return str is html to be rendered.
    */
    public function display_results($results){
        if(!empty($results)) {
            $str = '<table class="table table-striped table-hover"><thead><tr>';
            $headings = array_keys($results[0]);
            foreach ($headings as $heading) {
                $str .= '<th>' . $heading . '</th>';
            }
            $str .= '</tr></thead>' . "\n" .'<tbody>';

            foreach ($results as $row) {
                $str .= '<tr class="'. $row['status'] . ' collapse in">';
                foreach ($row as $v) {
                    $str .= '<td>' . $v . '</td>';
                }
                $str .= '</tr>' . "\n";
            }
            $str .= '</tbody></table>';
        } else {
            $str = '<div class="well">No Tickets! Yay!</div>';
        }

        return $str;
    }

    /**
    * Create a dropdown menu. Intended to be used with the get_users function.
    * @param results takes associative array
    * @return str is html markup to be rendered.
    */
    public function display_dropdown($results){
        if(!empty($results)) {
            $str = '';
            foreach ($results as $v) {
                $str .= '<option value="'. $v . '">' . $v . '</option>';
            }
        } else {
            $str = '<div class="well">No Results.</div>';
        }
        return $str;
    }

    /**
    * Create results table with results array keys as headings.
    * @param results is associative array
    * @return str is html to be rendered.
    */
    public function display_admin($results) {
        if (!empty($results)) {
            $str = '<table id="myTable" class="table table-striped">
            <thead>';

            $headings = array_keys($results[0]);
            foreach ($headings as $heading) {
                $str .= '<th>' . $heading .'</th>';
            }
            $str .= '</tr></thead>' . "\n" . '<tbody>';

            foreach ($results as $row) {
                if($row['status'] === 'unresolved') {
                    $str .= '
                    <tr onclick="fillModal(' . $row['id'] . ')" id="ticket_'
                    . $row['id'] . '" class="table-row click-me ' . $row['status'] .
                    ' collapse in" data-toggle="modal"
                    data-target="#myModal">';
                } else {
                    $str .= '<tr class="table-row ' . $row['status'] . ' collapse in">';
                }

                foreach ($row as $v) {
                    $str .= '<td>' . $v . '</td>';
                }

                $str .= '</tr>' . "\n";
            }

            $str .= '</tbody></table>';
        } else {
            $str = '<div class="well">No Tickets! Yay!</div>';
        }

        return $str;

    }

}
