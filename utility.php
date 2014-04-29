<?php
require_once('config.php');

function get_db_instance($server, $user, $password, $db)
{
    $conn = mysqli_connect($server, $user, $password, $db);
    return $conn;
}

/*function get_db()
{
    global $db;
    global $conn;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);
}
get_db();*/

function getgravatar($email)
{
    $hash = md5(strtolower(trim($email)));
    $full_url = 'http://www.gravatar.com/avatar/' . $hash;
    return $full_url;
}

function getfavicon($url)
{
    $escurl = rawurlencode($url);
    //$default = 'http://olibenu.com/iriki/files/o7-icon.ico'; //rawurlencode('http://olibenu.com/iriki/files/o7-icon.ico');
    $full_url = 'http://g.etfv.co/' . $escurl; // . '?defaulticon=' . $default;
    return $full_url;
}

function set_message($message)
{
    $_SESSION['message'] = $message;
}

function show_message()
{
    if (!empty($_SESSION['message']))
    {
        echo '<div class="paper-bg span12 thumbnail font11 text-center">' . $_SESSION['message'] . '</div>';
        set_message("");
    }
}

function page_url()
{
    $url = 'http://';
    if ($_SERVER['SERVER_PORT'] == 80)
    {
		$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];  
    }
    else
    {
        $url .= $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];  
    }
    return $url;
}

function page_url_without_pars()
{
    $url = 'http://';
    if ($_SERVER['SERVER_PORT'] == 80)
    {
		$url .= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];  
    }
    else
    {
        $url .= $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];  
    }
    return $url;
}

function gethost($url)
{
    if (substr($url, 0, 4) == 'http')
    {
        $url_parts = parse_url($url);
        $host = $url_parts['host'];
        $url = $host;
    }
    return $url;
}


function seo($input){
    $input = str_replace(array("'", "-"), "", $input); 
    //$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); 
    $input = strtolower($input);
    $input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); 
    $input = preg_replace("#(-){2,}#", "$1", $input); 
    $input = trim($input, "-"); 
    return $input; 
}

function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1
        ) {
        return '0 seconds';
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}

?>