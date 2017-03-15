<?php
class PopUp {
    /**
    * This is a view class that creates modal windows.
    */

    /**
    * Alert popup.
    * @param alert is the bolded section of the alert
    * @param message is the custom message to display.
    * @param class is the modal class defaults to blue alert
    * @return out is html string to be rendered.
    */
    public function alert_popup($alert, $message, $class="alert-info") {
        $str = '<div class="alert ' . $class . '" role="alert">';
        $str .= '<strong>' . $alert . '</strong>' . $message . '</div>';

        return $str;
    }

    /**
    * Modal window popup
    * @param title is the modal window title
    * @param body is html for body section
    * @param header is html string for header section
    * @param modal id default myModal
    * @param form is html form
    * @param buttons are specialized buttons
    *
    */
    public function modal_popup($title, $body, $form, $id = 'myModal', $header) {
        $str = '<div id="' . $id . '" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">';
        if (isset($header)) {
            $str .= $header;
        } else {
            $str .= '<div class="modal-header">
                        <h5 class="modal-title">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }

        $str .= '<div class="modal-body">';
        $str .= isset($body) ? $body : '';
        $str .= isset($form) ? $form : '';
        $str .= '</div>';

        $str .= '<div class="modal-footer"><button type="button" class="btn btn-secondary"
                data-dismiss="modal">Close</button>';
        // if (isset($buttons) && $buttons != "none") {
        //     $str .= $buttons;
        // } elseif ($buttons == "none") {
        //     $str .= '';
        // } else {
        //     // generic buttons here
        //     $str .= '<button type="button" class="btn btn-secondary"
        //             data-dismiss="modal">Close</button>';
        // }
        $str .= '</div>';
        $str .= '</div></div></div>';

        return $str;
    }
}
