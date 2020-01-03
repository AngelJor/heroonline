<?php
session_start();
// autoload classes based on a 1:1 mapping from namespace to directory structure.
function autoload($className)
{
//list comma separated directory name
    $directory = array('../', '../Controller/', '../Model/','../Query/','../View');

//list of comma separated file format
    $fileFormat = array('%s.php', '%s.class.php');

    foreach ($directory as $current_dir)
    {
        foreach ($fileFormat as $current_format)
        {

            $path = $current_dir.sprintf($current_format, $className);
            if (file_exists($path))
            {
                include $path;
                return ;
            }
        }
    }
}
spl_autoload_register('autoload');


define ("_SERVER_PATH_REAL", substr(__FILE__, 0, -(strlen('public/'.basename(__FILE__)))));
define ("_SERVER_PATH", substr($_SERVER['SCRIPT_NAME'],  0, -(strlen('public/'.basename($_SERVER['SCRIPT_NAME'])))));
$path = explode("/",str_replace(_SERVER_PATH,'',$_SERVER['REQUEST_URI']));

$target = (isset($path[0])?$path[0]:null);
$action = (isset($path[1])?$path[1]:null);
if(isset($_GET['target']) && isset($_GET['action'])){
    WebResponse::run($_GET['target'], $_GET['action']);
} elseif(isset($target) && isset($action)){
    WebResponse::run($target, $action);
}
WebResponse::print();
