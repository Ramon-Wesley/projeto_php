<?php

session_start();
session_unset();
session_destroy();
header("Location: /projeto_php/controllers/login");
exit();
