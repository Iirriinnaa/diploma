<?php
define('A_BLACK', 1 << 0);
define('A_PUBLIC', 1 << 1);
define('A_APPOINT_RIGHT', 1 << 2);
define('A_READ_RESULT', 1 << 3);
define('A_READ', 1 << 4);
define('A_EDIT', 1 << 5);
define('U_ALL', A_PUBLIC | A_EDIT | A_APPOINT_RIGHT | A_READ_RESULT | A_READ );
?>