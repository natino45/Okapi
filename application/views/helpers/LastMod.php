<?php
class Zend_View_Helper_LastMod extends Zend_View_Helper_Abstract
{
function lastMod($directory) {
    // 1. An array to hold the files.
    $last_modified_time = 0;

    // 2. Getting a handler to the specified directory
    $handler = opendir($directory);

    // 3. Looping through every content of the directory
    while ($file = readdir($handler)) {
        // 3.1 Checking if $file is not a directory
        if(is_file($directory.DIRECTORY_SEPARATOR.$file)){
            $files[] = $directory.DIRECTORY_SEPARATOR.$file;
            $filemtime = filemtime($directory.DIRECTORY_SEPARATOR.$file);
            if($filemtime>$last_modified_time) {
                $last_modified_time = $filemtime;
            }
	}
    }

    // 4. Closing the handle
    closedir($handler);

    // 5. Returning the last modified time
    return $last_modified_time;
}
}