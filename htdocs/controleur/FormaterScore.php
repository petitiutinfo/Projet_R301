<?php
// Fonction pour formater le score en fonction du résultat numérique
function formaterScore($resultat) {
    // Utilisation d'un switch pour retourner le score en fonction de la valeur de $resultat
    switch ($resultat) {
        case -3:
            // Si $resultat est égal à -3, retourne "0-3"
            return "0-3";
        case -2:
            // Si $resultat est égal à -2, retourne "1-3"
            return "1-3";
        case -1:
            // Si $resultat est égal à -1, retourne "2-3"
            return "2-3";
        case 0:
            // Si $resultat est égal à 0, retourne "0-0"
            return "0-0";
        case 1:
            // Si $resultat est égal à 1, retourne "3-2"
            return "3-2";
        case 2:
            // Si $resultat est égal à 2, retourne "3-1"
            return "3-1";
        case 3:
            // Si $resultat est égal à 3, retourne "3-0"
            return "3-0";
        default:
            // Si $resultat n'est pas dans les valeurs spécifiées, retourne une chaîne vide
            return "";
    }
}
?>