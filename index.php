<?php
include_once('./config.php');
include_once('./model.php');

?>
<!DOCTYPE html>
<html lang="en-gb">
<head>

    <?php
    echo '<title>' . 'Wanted: Disrupted & Alive' . '</title>';
    ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
                    <div class="title3">Add a category to Wanted</div>
                    <form class="brief" action="./controller.php" method="POST">
                        <input name="do" type="hidden" value="area_create" />
                        <div class="controls">
                            <input name="author" class="input-block-level" type="email" placeholder="Your email"
                                <?php
                                    if (isset($_SESSION['email']))
                                    {
                                        echo 'value="' . $_SESSION['email'] . '"';
                                    }
                                ?>
                            />
                            <input name="title" class="input-block-level"  type="text" placeholder="New category" />                    
                        </div>                                             
                        <button class="btn btn-primary pull-right" type="submit">Submit</button>   
                    </form>
                    <div class="title3">Recently added</div>
                    <div class="children">
                        <?php log_list_all(); ?>
                    </div>
                </div>

                <?php area_list_all(); ?>
            </div> 
        </div>
    </div>

</body>
</html>
