<?php

function sqli_filter($string) {
    $filtered_string = $string;
    $filtered_string = str_replace("--","",$filtered_string);
    $filtered_string = str_replace("'","",$filtered_string);
    $filtered_string = str_replace(";","",$filtered_string);
    $filtered_string = str_replace("/*","",$filtered_string);
    $filtered_string = str_replace("*/","",$filtered_string);
    $filtered_string = str_replace("//","",$filtered_string);
    $filtered_string = str_replace(" ","",$filtered_string);
    $filtered_string = str_replace("#","",$filtered_string);
    $filtered_string = str_replace("|","",$filtered_string);
    $filtered_string = str_replace("admin'","",$filtered_string);
    $filtered_string = str_replace("UNION","",$filtered_string);
    $filtered_string = str_replace("COLLATE","",$filtered_string);
    $filtered_string = str_replace("DROP","",$filtered_string);
    $filtered_string = str_replace("*","",$filtered_string);
    $filtered_string = str_replace("SELECT","",$filtered_string);
    $filtered_string = str_replace("select","",$filtered_string);
    return $filtered_string;

}
?>