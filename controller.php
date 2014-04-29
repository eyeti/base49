<?php
include_once('model.php');

$_SESSION['email'] = $_POST['author'];

if (isset($_POST['do']))
{
    switch ($_POST['do'])
    {
        case 'area_create':
            $stamp = time(NULL);
            $created = area_create($stamp, $_POST['author'], $_POST['title']);

            if ($created != 0)
            {
                //header("Location: ./?board=" . $created);
                do_log($created, 0, 0);
            }
            else
            {
                //header("Location: " . $_POST['url']);
            }
            header("Location: ./area.php?id=" . $created);
            break;

        case 'description_create':
            $stamp = time(NULL);
            $created = description_create($stamp, $_POST['author'], $_POST['areaid'], $_POST['url']);
            if ($created != 0)
            {
                //header("Location: ./?board=" . $created);
                do_log($_POST['areaid'], $created, 0);
            }
            else
            {
                //header("Location: " . $_POST['url']);
            }
            header("Location: ./area.php?id=" . $_POST['areaid']);
            break;


        /*case 'create_post':
            $stamp = time(NULL);
            $created = board_post_create($_POST['boardid'], $_POST['tag'], $_POST['post'], $stamp);
            if ($created != 0)
            {
                set_message('Successful');
            }
            else
            {
                set_message('Failed');
            }
            header("Location: " . $_POST['url']);
            break;

        case 'edit':
            $stamp = time(NULL);
            if (board_edit($_POST['id'], $_POST['title'], $_POST['description'], $_POST['userid'], $stamp))
            {
                set_message('Successful');
            }
            else
            {
                set_message('Failed');
            }
            header("Location: " . $_POST['url']);
            break;

        case 'sms':
            $postid = send_board_post($_POST['boardtitle'], $_POST['postid'], $_POST['posttype']);
            header("Location: ./?post=" . $postid);
            break;*/
    }   
}
else if (isset($_GET['do']))
{
    /*if ($_GET['do'] == 'pin')
    {
        board_post_tag($_GET['id'], TAG_PINNED);
        header("Location: ./?board=" . $_GET['board']);
    }
    elseif ($_GET['do'] == 'unpin')
    {
        board_post_tag($_GET['id'], TAG_UNPINNED);
        header("Location: ./?board=" . $_GET['board']);
    }
    elseif ($_GET['do'] == 'refresh')
    {
        $count = board_refresh($_GET['id']);
        set_message($count . ' new posts.');
        header("Location: ./?board=" . $_GET['id']);
    }*/
}
?>