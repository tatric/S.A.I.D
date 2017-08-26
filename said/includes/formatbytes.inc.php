<?PHP

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1010);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

function get_dir_size($dir_name){
        $dir_size =0;
           if (is_dir($dir_name)) {
               if ($dh = opendir($dir_name)) {
                  while (($file = readdir($dh)) !== false) {
                        if($file !='.' && $file != '..'){
                              if(is_file($dir_name."/".$file)){
                                   $dir_size += filesize($dir_name."/".$file);
                             }
                             /* check for any new directory inside this directory */
                             if(is_dir($dir_name."/".$file)){
                                $dir_size +=  get_dir_size($dir_name."/".$file);
                              }
                           }
                     }
             }
       }
closedir($dh);
return $dir_size;
}
?>
