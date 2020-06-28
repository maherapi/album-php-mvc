<?php
    // GLOBAL MIDDLEWARES
    require_once '../app/middlewares/global/sanitize_inputs.php';
    sanitizeInputs();

    // NOT GLOBAL MIDDLEWARES
    require_once '../app/middlewares/not-global/auth.php';
