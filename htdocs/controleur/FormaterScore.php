<?php
function formaterScore($resultat) {
    switch ($resultat) {
        case -3:
            return "0-3";
        case -2:
            return "1-3";
        case -1:
            return "2-3";
        case 0:
            return "0-0";
        case 1:
            return "3-2";
        case 2:
            return "3-1";
        case 3:
            return "3-0";
        default:
            return "";
    }
}
?>