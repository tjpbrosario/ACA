<?php
    mb_internal_encoding('utf-8');
    mb_http_output('utf-8');
    mb_http_input('utf-8');
    mb_language('uni');
    mb_regex_encoding('utf-8');
    ob_start('mb_output_handler');
?>
