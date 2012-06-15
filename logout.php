<?php

// Continue session
session_start();

// End Session
session_destroy();

// Return to login page
header("Location: ../index.php");

?>