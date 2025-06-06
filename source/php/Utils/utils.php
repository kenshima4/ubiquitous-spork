<?php
namespace Src\Utils;

class Utils{
    public static function debugToConsole($data){
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log(" . json_encode("Debug: " . $output) . ");</script>";
    }
}


