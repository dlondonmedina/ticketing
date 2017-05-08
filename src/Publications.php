<?php
/**
*
* Creates displays of publications from the database.
* web_display creates an html string that displays all of the results from the db.
* text_display creates a word document bibliography in MLA format.
*/
class Publications {

    public function web_display($results) {
        $html = '<h2>Results: </h2>';
        foreach ($results as $key => $v) {
            $html .= $this->make_mla($v);
        }
        return $html;
        // foreach ($results as $key => $value) {
        //     $html .= $key . " : " . $value . "<br />";
        // }
        // return $html;
    }

    public function make_mla($result) {
        $str = '<p>';
        $id = $result['netid'];
        $str .= $id . '. ';
        // $str = $result['lname'] . ', ' . $result['fname'] . '. ';
        if (!empty($result['publication'])) {
            $str .= "\"" . $result['title'] . ".\" ";
            $str .= "<i>" . $result['publication'] . ".</i> ";
        } else {
            $str .= "<i>" . $result['title'] . ".</i> ";
        }
        if($result['edition'] != 0) {
            $str .= $result['edition'];
            switch ($result['edition']) {
                case 1:
                    $str .= 'st., ';
                break;

                case 2:
                    $str .= 'nd., ';
                break;

                case 3:
                    $str .= 'rd., ';
                break;

                default:
                    $str .= 'th., ';
                break;
            }
        }

        if ($result['volume'] != 0) {
            $str .= 'vol. ' . $result['volume'] . ', ';
        }

        if ($result['num'] != 0) {
            $str .= 'num. ' . $result['num'] . ', ';
        }

        if (!empty($result['publisher'])) {
            $str .= $result['publisher'] . ', ';
        }

        if ($result['pub_date'] != 0) {
            $str .= $result['pub_date'] . '. ';
        }

        if (!empty($result['pages'])) {
            $str .= strpos($result['pages'], '-') ? 'pp. ' : 'p. ';
            $str .= $result['pages'] . '.';
        }

        $str .= '</p>';

        return $str;

    }

    public function text_display($results) {

    }
}
