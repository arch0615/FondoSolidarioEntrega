<?php

if (!function_exists('export_clean')) {
    /**
     * Limpia una cadena para exportación, asegurando la codificación UTF-8 correcta.
     *
     * @param string|null $string
     * @return string
     */
    function export_clean($string)
    {
        if ($string === null) {
            return '';
        }
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}