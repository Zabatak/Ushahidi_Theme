<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $site_name; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet" type="text/css">
            <?php echo $header_block; ?>
            <?php
            // Action::header_scripts - Additional Inline Scripts from Plugins
            Event::run('ushahidi_action.header_scripts');
            ?>
            <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-71480-8']);
  _gaq.push(['_setDomainName', 'zabatak.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </head>


    <?php
    // Add a class to the body tag according to the page URI
    // we're on the home page
    if (count($uri_segments) == 0) {
        $body_class = "page-main";
    }
    // 1st tier pages
    elseif (count($uri_segments) == 1) {
        $body_class = "page-" . $uri_segments[0];
    }
    // 2nd tier pages... ie "/reports/submit"
    elseif (count($uri_segments) >= 2) {
        $body_class = "page-" . $uri_segments[0] . "-" . $uri_segments[1];
    };
    ?>

    <body id="page" class="<?php echo $body_class; ?>" />

    <?php echo $header_nav; ?>

    <!-- top bar-->
    <div id="top-bar">
        <!-- searchbox -->
        <div id="searchbox">

            <!-- languages -->
<?php echo $languages; ?>
            <!-- / languages -->

            <!-- searchform -->
            <?php echo $search; ?>
            <!-- / searchform -->

        </div>
    </div>
    <!-- / searchbox -->


    <!-- wrapper -->
    <div class="rapidxwpr floatholder">

        <!-- header -->
        <div id="header">

            <!-- logo -->
<?php if ($banner == NULL) { ?>
                <div id="logo">
                    <h1><a href="<?php echo url::site(); ?>"><?php echo $site_name; ?></a></h1>
                    <span><?php echo $site_tagline; ?></span>
                </div>
<?php } else { ?>
                <a href="<?php echo url::site(); ?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
<?php } ?>
            <!-- / logo -->

            <!-- submit incident -->
            <?php echo $submit_btn; ?>
            <!-- / submit incident -->

        </div>
        <!-- / header -->
        <!-- / header item for plugins -->
<?php
// Action::header_item - Additional items to be added by plugins
Event::run('ushahidi_action.header_item');
?>
        <!-- main body -->
        <div id="middle">
            
            <div class="background layoutleft">
                
                <!-- mainmenu -->
                <div  id="top-menu">
                <h1>
                    <ul>
<?php nav::main_tabs($this_page); ?>
                    </ul>

                </h1>
                </div>
                <!-- / mainmenu -->
