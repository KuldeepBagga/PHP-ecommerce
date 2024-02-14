<?php
require '../lib/config.php';
session_destroy();
header('location:index.php');