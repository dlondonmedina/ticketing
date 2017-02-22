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

        $str = '<table class="table table-striped"><thead><tr><th></th>';
        $headings = array_keys($results[0]);
        foreach ($headings as $heading) {
            $str .= '<th>' . $heading . '</th>';
        }
        $str .= '</tr></thead>' . "\n" .'<tbody>';

        foreach ($results as $row) {
            $str .= '<tr class="'. $row['status'] . '">';
            foreach ($row as $v) {
                $str .= '<td>' . $v . '</td>';
            }
            $str .= '</tr>' . "\n";
        }
        $str .= '</tbody></table>';

        return $str;
    }

    /**
    * Create a dropdown menu. Intended to be used with the get_users function.
    * @param results takes associative array
    * @return str is html markup to be rendered.
    */
    public function display_dropdown($results)
    {
        $str = '';
        foreach ($results as $v) {
            $str .= '<option value="'. $v . '">' . $v . '</option>';
        }
        return $str;
    }

    /**
    * Create results table with results array keys as headings.
    * @param results is associative array
    * @return str is html to be rendered.
    */
    public function display_admin($results) {
        $str = '<table id="myTable" class="table table-striped">
            <thead><tr><th></th></tr>' . "\n";

        $headings = array_keys($results[0]);
        foreach ($headings as $heading) {
            $str .= '<th>' . $heading .'</th>';
        }
        $str .= '</tr></thead>' . "\n" . '<tbody>';

        foreach ($results as $row) {
            if($row['status'] === 'unresolved') {
                $str .= '
                    <tr onclick="displayModal(' . $result['id'] . ')" id="ticket_'
                    . $result['id'] . '" class="table-row click-me" data-toggle="modal"
                    data-target="#myModal">';
            } else {
                $str .= '<tr class="table-row">';
            }

            foreach ($row as $v) {
                $str .= '<td>' . $v . '</td>';
            }

            $str .= '</tr>' . "\n";
        }

        $str .= '</tbody></table>';

        return $str;

    }

}
