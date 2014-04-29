<?php
include_once('./config.php');
include_once('./model.php');
if (!isset($_GET['url']) && !isset($_GET['id']))
{
    header("Location: ./index.php");
}
elseif (isset($_GET['id']))
{
    get_area_from_id($_GET['id']);
}
else
{
    get_area_from_url($_GET['url']);
}
?>
<!DOCTYPE html>
<html lang="en-gb">
<head>

    <?php
    echo '<title>' . $area_title . '</title>';
    ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="./assets/css/reset.css" rel="stylesheet"/>    
    
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./assets/css/bootstrap-responsive.min.css" rel="stylesheet"/>

    <script src="./assets/js/masonry.pkgd.min.js"></script>

    <link href="./assets/css/style.css" rel="stylesheet"/>    

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" href="assets/img/favicon.ico"/>
    
    <!--?php include_once('analyticstracking.php') ?-->    
    <?php include_once('./assets/js/social.js') ?>

</head>
<body>
    <div class="row-fluid">
        <div class="header">
            <div class="span3"></div>
            <div class="span6">
                <div class="text-center">
                    <a href="./index.php"><img class="img-circle main-logo" src="./assets/img/wanted.png" /></a>
                </div>
                <div class="text-center">
            <strong>WANTED</strong><br />disrupted and alive.
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span3"></div>
        <div class="span6">            
            <div class="all-wanted js-masonry" data-masonry-options='{ "columnWidth": 100, "itemSelector": ".brick" }'>
                <div class="brick thumbnail">
                    <div class="title3">Add a website to <?php echo $area_title;?></div>
                    <form class="brief" action="./controller.php" method="POST">
                        <input name="do" type="hidden" value="description_create" />
                        <input name="areaid" type="hidden" value="<?php echo $area_id;?>" />
                        <div class="controls">
                            <input name="author" class="input-block-level" type="email" placeholder="Thine email" 
                                <?php
                                    if (isset($_SESSION['email']))
                                    {
                                        echo 'value="' . $_SESSION['email'] . '"';
                                    }
                                ?>
                            />
                            <input name="url" class="input-block-level" type="url" placeholder="Some other example" />                    
                        </div>                                             
                        <button class="btn btn-primary pull-right" type="submit">Submit</button>   
                    </form>
                    <div class="title3">Recently added</div>
                    <div class="children">
                    	<?php log_list_of($area_id); ?>
                    </div>
                </div>

                <?php description_list_all($area_id); ?>
            </div>
        </div>
    </div>
    
</body>
</html>
