<?php
function autoloadClass($className) {
    $filename = "Classes/Class" . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}
function autoloadMain($className) {
    $filename = $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}
spl_autoload_register("autoloadClass");
spl_autoload_register("autoloadMain");

?>