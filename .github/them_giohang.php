<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST["ten"];
    $gia = $_POST["gia"];

    $item = ["ten" => $ten, "gia" => $gia];

    if (!isset($_SESSION["giohang"])) {
        $_SESSION["giohang"] = [];
    }

    $_SESSION["giohang"][] = $item;
}

header("Location: giohang.php");
exit();
