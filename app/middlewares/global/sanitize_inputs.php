<?php
    function sanitizeInputs() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }
    