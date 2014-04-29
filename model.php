<?php
require_once('./config.php');
include_once('./utility.php');

global $area;
$area['id'] = 0;
$area['stamp'] = 0;
$area['author'] = "";
$area['title'] = "";
$area['url'] = "";

global $description;
$description['id'] = 0;
$description['stamp'] = 0;
$description['author'] = "";
$description['areaid'] = 0;
$description['url'] = "";

global $log;

function area_list_all()
{
    global $db;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT
                id as area_id, author, title, url,
                COALESCE(stamp, (SELECT COUNT(tbldescription.id) FROM tbldescription WHERE tbldescription.areaid = area_id)) AS desc_count
            FROM tblarea
            ORDER BY desc_count DESC"
            );
        //$statement->bind_param('i', $except);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $author, $title, $url, $desc_count);
            $counter = 0;

            while($statement->fetch())
            {
                $counter++; 
                echo '<a class="brick thumbnail" href="' . './area.php?url=' . $url . '">';
                	echo '<div class="title3">' . time_elapsed_string($desc_count) . ' ago</div>';
                    echo '<div class="title"><strong>' . $title . '</strong></div>';
                    echo '<div class="author"><img class="img-circle" src="' . getgravatar($author) . '" /></div>';
                    echo '<div class="children">';
                        description_list_of($id);
                    echo '</div>';
                echo '</a>';
            }            
            $statement->free_result();
        }
    }    
}

function get_area_from_url($url)
{
    global $db;    
    global $area_title;
    global $area_id;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT id, title FROM tblarea WHERE url = ?"
            );
        $statement->bind_param('s', $url);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $title);

            while($statement->fetch())
            {
                $area_id = $id;
                $area_title = $title;
            }            
            $statement->free_result();
        }
    }  
    return;  
}

function get_area_from_id($id)
{
    global $db;    
    global $area_title;
    global $area_id;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT title FROM tblarea WHERE id = ?"
            );
        $statement->bind_param('i', $id);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($title);

            while($statement->fetch())
            {
                $area_id = $id;
                $area_title = $title;
            }            
            $statement->free_result();
        }
    }  
    return;  
}

function area_create($stamp, $author, $title)
{
    $created = 0;
    if (strlen($author) > 0 && strlen($author) <=50 && strlen($title) > 0 && strlen($title) <=100)
    {
        global $db;

        $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

        if($conn->connect_errno <= 0)
        {
            $statement = $conn->prepare("INSERT INTO tblarea (stamp, author, title, url) VALUES (?, ?, ?, ?)");

            $url = seo($title);
        
            $statement->bind_param('isss', $stamp, $author, $title, $url);
        
            if ($result = $statement->execute())
            {
                $statement->free_result();
                $created = $conn->insert_id;
                return $created; //TRUE;
            }
        }
    }
    return $created; //FALSE;
}

function description_list_all($areaid)
{
    global $db;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT
                id, stamp, author, areaid, url
            FROM tbldescription
            WHERE areaid = ?
            ORDER BY stamp DESC"
            );
        $statement->bind_param('i', $areaid);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $stamp, $author, $areaid, $url);
            $counter = 0;

            while($statement->fetch())
            {
                $counter++; 

                echo '<a class="brick thumbnail" href="' . $url . '">';
                	echo '<div class="title3">' . time_elapsed_string($stamp) . ' ago</div>';
                    echo '<div class="title"><strong>' . gethost($url) . '</strong></div>';
                    echo '<div class="author"><img class="img-circle" src="' . getgravatar($author) . '" /></div>';
                    echo '<div class="children">';
                        echo '<img class="img-circle log-icon" src="' . getfavicon($url) . '" />';
                    echo '</div>';
                echo '</a>';
            }            
            $statement->free_result();
        }
    }    
}

function description_list_of($areaid)
{
    global $db;
    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT
                id, stamp, author, areaid, url
            FROM tbldescription
            WHERE areaid = ?
            ORDER BY stamp DESC LIMIT 0,4"
            );
        $statement->bind_param('i', $areaid);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $stamp, $author, $areaid, $url);
            $counter = 0;

            while($statement->fetch())
            {
                $counter++;
                echo '<img class="img-circle log-icon" src="' . getfavicon($url) . '">';
                 
            }            
            $statement->free_result();
        }
    }    
}

function description_create($stamp, $author, $areaid, $url)
{
    $created = 0;
    if (strlen($author) > 0 && strlen($author) <=50)
    {
        global $db;

        $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

        if($conn->connect_errno <= 0)
        {
            $statement = $conn->prepare("INSERT INTO tbldescription (stamp, author, areaid, url) VALUES (?, ?, ?, ?)");
        
            $statement->bind_param('isis', $stamp, $author, $areaid, $url);
        
            if ($result = $statement->execute())
            {
                $statement->free_result();
                $created = $conn->insert_id;
                return $created; //TRUE;
            }
        }
    }
    return $created; //FALSE;
}

function do_log($areaid, $descriptionid, $tag)
{
    $created = 0;
    global $db;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare("INSERT INTO tbllog (areaid, descriptionid, tag) VALUES (?, ?, ?)");
    
        $statement->bind_param('iii', $areaid, $descriptionid, $tag);
    
        if ($result = $statement->execute())
        {
            $statement->free_result();
            $created = $conn->insert_id;
        }
    }
    return $created;
}

function log_list_all()
{
    global $db;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT
                tbllog.id, tbllog.stamp,
                tbllog.areaid, tblarea.url,
                tbllog.descriptionid, tbldescription.author, tbldescription.url,
                tbllog.tag
            FROM tbllog
                INNER JOIN tblarea ON tblarea.id=tbllog.areaid
                INNER JOIN tbldescription ON tbldescription.id=tbllog.descriptionid
            ORDER BY tbllog.stamp DESC
            LIMIT 7"
            );
        //$statement->bind_param('i', $areaid);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $stamp,
                                    $area_id, $area_url,
                                    $description_id, $description_author, $description_url,
                                    $tag);
            $counter = 0;

            while($statement->fetch())
            {
                $counter++; 

                echo '<a href="./area.php?url=' . $area_url . '">';
                    echo '<img class="img-circle log-icon" src="' . getfavicon($description_url) . '" />
                    </a>';

            }            
            $statement->free_result();
        }
    }
}

function log_list_of($areaid)
{
    global $db;

    $conn = get_db_instance($db['server'], $db['user'], $db['password'], $db['db']);

    if($conn->connect_errno <= 0)
    {
        $statement = $conn->prepare(
            "SELECT
                tbllog.id, tbllog.stamp,
                tbllog.areaid, tblarea.url,
                tbllog.descriptionid, tbldescription.author, tbldescription.url,
                tbllog.tag
            FROM tbllog
                INNER JOIN tblarea ON tblarea.id=tbllog.areaid
                INNER JOIN tbldescription ON tbldescription.id=tbllog.descriptionid
            WHERE tbllog.areaid=?
            ORDER BY tbllog.stamp DESC
            LIMIT 7"
            );
        $statement->bind_param('i', $areaid);
        
        if ($result = $statement->execute())
        {
            $statement->bind_result($id, $stamp,
                                    $area_id, $area_url,
                                    $description_id, $description_author, $description_url,
                                    $tag);
            $counter = 0;

            while($statement->fetch())
            {
                $counter++; 

                echo '<a href="' . $description_url . '">';
                    echo '<img class="img-circle log-icon" src="' . getfavicon($description_url) . '" />
                    </a>';

            }            
            $statement->free_result();
        }
    }
}


?>
