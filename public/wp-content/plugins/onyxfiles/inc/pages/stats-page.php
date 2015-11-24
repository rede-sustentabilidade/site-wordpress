<?php

function jkof_display_stats_page(){
    global $wpdb;
    $jkof_settings    =    get_option( 'jkof_settings' );
    
    $cur_time    =    time();
    $today       =    strtotime("today");
    $yesterday   =    strtotime("yesterday");
    $month       =    strtotime("first day of month");
    $year        =    strtotime("first day of year");

    $todayCount  =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads WHERE time_downloaded>'" . $today . "'");
    $yestCount   =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads 
                                      WHERE time_downloaded<'" . $today . "'
                                      AND time_downloaded>'" . $yesterday . "'");
    $monthCount  =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads WHERE time_downloaded>'" . $month . "'");
    $yearCount   =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads WHERE time_downloaded>'" . $year . "'");
    $allCount    =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads");
    
    $chartArr    =    array();
    $labelArr   =   array();
    $chartTime   =    strtotime("tomorrow");
    for($i = 0; $i < 14; $i++){
        $dlCount    =    $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "of_downloads
                                         WHERE time_downloaded<'" . ($chartTime - (86400 * $i)) . "'
                                         AND time_downloaded>'" . ($chartTime - (86400 * ($i+1))) . "'");
        array_push($chartArr, $dlCount);
        array_push($labelArr,@date("n/j/Y", $chartTime));
        $chartTime    -=    86400;
    }
    $chartJSON    =    json_encode($chartArr);
    $labelJSON      =   json_encode($labelArr);

?>
<div class="wrap">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-clipboard"></i> <?php _e('Basic Download Statistics', 'onyxfiles'); ?></div>
        <div class="panel-body">
            <table class="table table-responsive table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center"><?php _e('Today', 'onyxfiles'); ?></th>
                        <th class="text-center"><?php _e('Yesterday', 'onyxfiles'); ?></th>
                        <th class="text-center"><?php _e('Past 30 Days', 'onyxfiles'); ?></th>
                        <th class="text-center"><?php _e('Past Year', 'onyxfiles'); ?></th>
                        <th class="text-center"><?php _e('All time', 'onyxfiles'); ?></th>
                        <th class="text-center"><?php _e('Total Earnings', 'onyxfiles'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $todayCount; ?></td>
                        <td><?php echo $yestCount; ?></td>
                        <td><?php echo $monthCount; ?></td>
                        <td><?php echo $yearCount; ?></td>
                        <td><?php echo $allCount; ?></td>
                        <td>$<?php echo $jkof_settings["paypal"]["earnings"]; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-area-chart"></i> <?php _e('Last 14 days', 'onyxfiles'); ?></div>
        <div class="panel-body">
            <canvas id="latestDownloadsCharts" width="1000" height="400" class="center-block"></canvas>
            <script>
                jQuery(function($){
                    var ctx = $("#latestDownloadsCharts").get(0).getContext("2d");

                    var data = {
                        labels: <?php echo $labelJSON; ?>,
                        datasets: [
                            {
                                label: "Downloads",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: <?php echo $chartJSON; ?>
                            }
                        ]
                    };

                    var myLineChart = new Chart(ctx).Line(data, {
                        responsive: false
                    });
                });
            </script>
        </div>
    </div>
</div>
<?php
}