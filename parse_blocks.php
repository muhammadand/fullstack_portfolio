<?php
$tokens = token_get_all(file_get_contents('storage/framework/views/31cfbd2bff857b203cfbaa798fa2aff8.php'));
$ifs = 0; $endifs = 0; $braces = 0;
foreach($tokens as $t) {
    if (is_array($t)) {
        if ($t[0] == T_IF) { echo "IF at line ".$t[2]."\n"; $ifs++; }
        if ($t[0] == T_ENDIF) { echo "ENDIF at line ".$t[2]."\n"; $endifs++; }
    } else {
        if ($t == '{') $braces++;
        if ($t == '}') $braces--;
    }
}
echo "IFs: $ifs, ENDIFs: $endifs, Braces: $braces\n";
