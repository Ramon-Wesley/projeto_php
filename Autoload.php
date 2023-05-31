<?php
spl_autoload_register(function ($archive_name) {
    if (file_exists("controllers/" . $archive_name . ".php")) {
        require "controllers/" . $archive_name . ".php";
    } else if (file_exists("models/" . $archive_name . ".php")) {
        require "models/" . $archive_name . ".php";
    } else if (file_exists("core/" . $archive_name . ".php")) {
        require "core/" . $archive_name . ".php";
    }
});
