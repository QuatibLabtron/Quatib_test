<?php
function execPrint($command)
{
    $result = array();
    exec($command, $result);
    foreach ($result as $line) {
        print($line . "<br>");
    }
}
// Print the exec output inside of a pre element
print("<pre>" . execPrint("git pull https://Admin063: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@github.com/Admin063/labotronics.com.git main") . "</pre>");
?>