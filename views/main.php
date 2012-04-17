
<script type="text/javascript">
    $(function(){
  
        // show/hide report filters and layers boxes on home page map
        $("a.toggle").toggle(
        function() { 
            $($(this).attr("href")).show();
            $(this).addClass("active-toggle");
        },
        function() { 
            $($(this).attr("href")).hide();
            $(this).removeClass("active-toggle");
        }
    );
  
    });

</script>
<!-- main body -->
<div id="main" class="clearingfix">
    <div id="mainmiddle">

        <?php if ($site_message != '') { ?>
            <div class="green-box">
                <h3><?php echo $site_message; ?></h3>
            </div>
        <?php } ?>

        <!-- right column -->
        <div id="report-map-filter-box" class="clearingfix">
            <a class="btn toggle" id="filter-menu-toggle" class="" href="#the-filters"><?php echo Kohana::lang('ui_main.filter_reports_by'); ?><span class="btn-icon ic-right">&raquo;</span></a>

            <!-- filters box -->
            <div id="the-filters" class="map-menu-box">

                <!-- report category filters -->
                <div id="report-category-filter">
                    <h3><?php echo Kohana::lang('ui_main.category'); ?></h3>

                    <ul id="category_switch" class="category-filters">
                        <li><a class="active" id="cat_0" href="#"><span class="swatch" style="background-color:<?php echo "#" . $default_map_all;?>" ></span><span class="category-title"><?php echo Kohana::lang('ui_main.all_categories'); ?></span></a></li>
                        <?php
                        foreach ($categories as $category => $category_info) {
                            $category_title = $category_info[0];
                            $category_color = $category_info[1];
                            $category_image = '';
                            $color_css = 'class="swatch" style="background-color:#' . $category_color . '"';
                            if ($category_info[2] != NULL) {
                                $category_image = html::image(array(
                                            'src' => $category_info[2],
                                            'style' => 'float:left;padding-right:5px;'
                                        ));
                                $color_css = '';
                            }
                            echo '<li><a href="#" id="cat_' . $category . '"><span ' . $color_css . '>' . $category_image . '</span><span class="category-title">' . $category_title . '</span></a>';
                            // Get Children
                            echo '<div class="hide" id="child_' . $category . '">';
                            if (sizeof($category_info[3]) != 0) {
                                echo '<ul>';
                                foreach ($category_info[3] as $child => $child_info) {
                                    $child_title = $child_info[0];
                                    $child_color = $child_info[1];
                                    $child_image = '';
                                    $color_css = 'class="swatch" style="background-color:#' . $child_color . '"';
                                    if ($child_info[2] != NULL) {
                                        $child_image = html::image(array(
                                                    'src' => $child_info[2],
                                                    'style' => 'float:left;padding-right:5px;'
                                                ));
                                        $color_css = '';
                                    }
                                    echo '<li style="padding-left:10px;"><a href="#" id="cat_' . $child . '"><span ' . $color_css . '>' . $child_image . '</span><span class="category-title">' . $child_title . '</span></a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</div></li>';
                        }
                        ?>
                    </ul>

                </div>
                <!-- / report category filters -->

                <!-- report type filters -->
                <div id="report-type-filter" class="filters">
                    <h3><?php echo Kohana::lang('ui_main.type'); ?></h3>
                    <ul>
                        <li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
                        <li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
                        <li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
                        <li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
                        <li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
                    </ul>
                    <div class="floatbox">
                        <?php
// Action::main_filters - Add items to the main_filters
                        Event::run('ushahidi_action.map_main_filters');
                        ?>
                    </div>
                    <!-- / report type filters -->
                </div>

            </div>
            <!-- / filters box -->

            <?php
            if ($layers) {
                ?>
                <div id="layers-box">
                    <a class="btn toggle" id="layers-menu-toggle" class="" href="#kml_switch"><?php echo Kohana::lang('ui_main.layers'); ?> <span class="btn-icon ic-right">&raquo;</span></a>
                    <!-- Layers (KML/KMZ) -->
                    <ul id="kml_switch" class="category-filters map-menu-box">
                        <?php
                        foreach ($layers as $layer => $layer_info) {
                            $layer_name = $layer_info[0];
                            $layer_color = $layer_info[1];
                            $layer_url = $layer_info[2];
                            $layer_file = $layer_info[3];
                            $layer_link = (!$layer_url) ?
                                    url::base() . Kohana::config('upload.relative_directory') . '/' . $layer_file :
                                    $layer_url;
                            echo '<li><a href="#" id="layer_' . $layer . '"
  						onclick="switchLayer(\'' . $layer . '\',\'' . $layer_link . '\',\'' . $layer_color . '\'); return false;"><span class="swatch" style="background-color:#' . $layer_color . '"></span>
  						<span class="category-title">' . $layer_name . '</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <!-- /Layers -->
                <?php
            }
            ?>


            <?php
            if (isset($shares)) {
                ?>
                <div id="other-deployments-box">
                    <a class="btn toggle" id="other-deployments-menu-toggle" class="" href="#sharing_switch"><?php echo Kohana::lang('ui_main.other_ushahidi_instances'); ?> <span class="btn-icon ic-right">&raquo;</span></a>
                    <!-- Layers (Other Ushahidi Layers) -->
                    <ul id="sharing_switch" class="category-filters map-menu-box">
                        <?php
                        foreach ($shares as $share => $share_info) {
                            $sharing_name = $share_info[0];
                            $sharing_color = $share_info[1];
                            echo '<li><a href="#" id="share_' . $share . '"><span class="swatch" style="background-color:#' . $sharing_color . '"></span>
  						<span class="category-title">' . $sharing_name . '</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <!-- /Layers -->
                <?php
            }
            ?>


            <!-- additional content -->
            <?php
            if (Kohana::config('settings.allow_reports')) {
                ?>
                <a class="btn toggle" id="how-to-report-menu-toggle" class="" href="#how-to-report-box"><?php echo Kohana::lang('ui_main.how_to_report'); ?> <span class="btn-icon ic-question">&raquo;</span></a>
                <div id="how-to-report-box" class="map-menu-box">

                    <div>

                        <!-- Phone -->
                        <?php if (!empty($phone_array)) { ?>
                            <div style="margin-bottom:10px;">
                                <?php echo Kohana::lang('ui_main.report_option_1'); ?>
                                <?php foreach ($phone_array as $phone) { ?>
                                    <strong><?php echo $phone; ?></strong>
                                    <?php if ($phone != end($phone_array)) { ?>
                                        <br/>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- External Apps -->
                        <?php if (count($external_apps) > 0) { ?>
                            <div style="margin-bottom:10px;">
                                <strong><?php echo Kohana::lang('ui_main.report_option_external_apps'); ?>:</strong><br/>
                                <?php foreach ($external_apps as $app) { ?>
                                    <a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a><br/>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- Email -->
                        <?php if (!empty($report_email)) { ?>
                            <div style="margin-bottom:10px;">
                                <strong><?php echo Kohana::lang('ui_main.report_option_2'); ?>:</strong><br/>
                                <a href="mailto:<?php echo $report_email ?>"><?php echo $report_email ?></a>
                            </div>
                        <?php } ?>

                        <!-- Twitter -->
                        <?php if (!empty($twitter_hashtag_array)) { ?>
                            <div style="margin-bottom:10px;">
                                <strong><?php echo Kohana::lang('ui_main.report_option_3'); ?>:</strong><br/>
                                <?php foreach ($twitter_hashtag_array as $twitter_hashtag) { ?>
                                    <span>#<?php echo $twitter_hashtag; ?></span>
                                    <?php if ($twitter_hashtag != end($twitter_hashtag_array)) { ?>
                                        <br />
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- Web Form -->
                        <div style="margin-bottom:10px;">
                            <a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a>
                        </div>

                    </div>

                </div>
            <?php } ?>
            <!-- / additional content -->

            <?php
// Action::main_sidebar - Add Items to the Entry Page Sidebar
            Event::run('ushahidi_action.main_sidebar');
            ?>

        </div>
        <!-- / right column -->

        <!-- content column -->
        <div id="content" class="clearingfix">


            <?php
// Map and Timeline Blocks
            echo $div_map;
            echo $div_timeline;
            ?>
        </div>
    </div>
    <!-- / content column -->

</div>
</div>
<!-- / main body -->

<!-- content -->
<div class="content-container">

    <!-- content blocks -->
    <div class="content-blocks clearingfix">
        <ul class="content-column">
            <?php blocks::render(); ?>
        </ul>
    </div>
    <!-- /content blocks -->

    <div class="content-block content-blocks clearingfix" id="press-logos">
        <h5 class="right">قالوا عنا</h5>

        <table class="table-list"><tr><td>
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/3in_logo.jpg" />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/acutimes.jpg"  />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/al masry al youm_logo.jpg"  />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/cbc_logo.jpg"  />
        
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/al rahma_logo.jpg"  />
        
        <a title="برنامج عز الشباب" href="https://www.youtube.com/watch?v=s5kiRSBTvSQ&feature=BFa&list=PL56CBED9A80EC8CE8&lf=mh_lolz">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/ezz elshabab_logo.jpg"  />
		</a>
		<a title="Mashallah News" href="http://blog.zabatak.com/zabatak-in-mashallanews/">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/Mashallah_Logo.png"  />
		</a>
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/misr25_logo.jpg"  />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/youm7_logo.jpg"  />
		
        <a title="ON TV" href="https://www.youtube.com/watch?v=9--arSWItyc&feature=BFa&list=PL56CBED9A80EC8CE8&lf=mh_lolz">
		<img src="<?php echo url::site(); ?>themes/zabatak/images/logos/on_tv_logo.png"  />
		</a>
		
		<a title="TedXTanta" href="https://www.youtube.com/watch?v=3FQyRsx-dNY&feature=BFa&list=PL56CBED9A80EC8CE8&lf=mh_lolz">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/TEDxTanta_logo.png"  />
		</a>
        
        
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/Cairo_ICT_logo.jpg"  />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/eed_logo.jpg"  />
        
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/190328_10150113049035838_590230837_6591559_6632911_n.jpg"  />
        <a title="الجزيرة مباشر" href="http://www.youtube.com/watch?v=tQ8mcxquKDE&list=PL56CBED9A80EC8CE8">
		<img src="<?php echo url::site(); ?>themes/zabatak/images/logos/aljazeera_mu_logo.jpg"  />
		</a>
		
		<a title="قناة روتانا مصرية" href="http://www.youtube.com/watch?v=SKo_9QhJ_AU&context=C3076065ADOEgsToPDskIa9Ors_AiyuvTWDs-MsQNu">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/big-masriya.jpg"  />
		</a>
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/imagesCA5Y7QXC.jpg"  />
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/m.jpg"  />
		<a title="قناة النيل الثقافية" href="http://www.youtube.com/watch?v=yDxIc1744LY">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/nile_sakafia.jpg"  />
		</a>
        <a title="برنامج العاشرة مساءا" href="http://www.youtube.com/watch?v=g7q-5Rdb-Uc">
		<img src="<?php echo url::site(); ?>themes/zabatak/images/logos/P6O55772.jpg"  />
		</a>
		
		<a title="قناة التحرير" href="http://www.youtube.com/watch?list=PL56CBED9A80EC8CE8&feature=player_detailpage&v=ynTsnNPuWu0#t=6275s">
        <img src="<?php echo url::site(); ?>themes/zabatak/images/logos/t_2.jpg"  />
		</a>
		
		<a title="جريدة الحرية والعدالة" href="http://blog.zabatak.com/%d8%b8%d8%a8%d8%b7%d9%83-%d9%81%d9%8a-%d8%a7%d9%84%d8%ad%d8%b1%d9%8a%d8%a9-%d9%88%d8%a7%d9%84%d8%b9%d8%af%d8%a7%d9%84%d8%a9/">
		<img src="<?php echo url::site(); ?>themes/zabatak/images/logos/horya.jpg"  />
		</a>
		
        
        </td></tr></table>
        
    </div>

</div>
<!-- content -->
