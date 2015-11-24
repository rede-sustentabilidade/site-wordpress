<?php
class JKOF_Recently_Uploaded_Widget extends WP_Widget
{
    /**
	 * Sets up the widgets name etc
	 */
    private $wpdb;
    
    public function __construct() {
        global $wpdb;

        $this->wpdb = &$wpdb;
        parent::__construct(
            'jkof_recently_uploaded_widget', // Base ID
            'Onyx Files Recently Uploaded', // Name
            array( 'description' => 'Display recently uploaded files.' ) // Args
        );
    }

    /**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
    public function widget( $args, $instance ) {
        extract($args);
        extract($instance);

        $title       =    apply_filters('widget_title', $title);
        $file_count  =    empty($instance['file_count']) ? 5 : intval($instance['file_count']);
        echo $before_widget;
        echo $before_title . $title . $after_title;
        // Begin File Display
        $topFiles    =    $this->wpdb->get_results(
            "SELECT * FROM " . $this->wpdb->prefix . "of_files ORDER BY `id` DESC LIMIT " . $file_count
        );

        foreach ( $topFiles as $topFile ){
            $file_url    =    get_permalink($topFile->ofid);
?>
<div class="jkof_singleDownloadItemCtr">
    <a href="<?php echo $file_url; ?>" class="jkof_pull-right"><?php echo $topFile->thumbnail; ?></a>
    <div class="jkof_singleDownloadItemInfo">
        <strong><a href="<?php echo $file_url; ?>" style="line-height: 1.5em;"><?php echo $topFile->title; ?></a></strong><br>
        <small>
            <em><?php echo FileSizeConvert($topFile->file_size); ?> - <?php echo $topFile->downloads; ?> Download(s)</em>
        </small>
    </div>
</div>
<div style="clear:both;"></div>
<?php
        }
        //End File Display
        echo $after_widget;
    }

    /**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
    public function form( $instance ) {
        $default     =    array(
            'title'           =>    'Recently Uploaded',
            'file_count'      =>    5
        );
        $instance    =    wp_parse_args( (array) $instance, $default );

        $file_count  =    $instance['file_count'];
        $title       =    $instance['title'];

?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' );?>">Title:</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' );?>"
           name="<?php echo $this->get_field_name( 'title' );?>" type="text" 
           value="<?php echo esc_attr( $title ); ?>" />
<p>
    <label for="<?php echo $this->get_field_id( 'file_count' );?>">File Display Count:</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'file_count' );?>"
           name="<?php echo $this->get_field_name( 'file_count' );?>" type="number" 
           value="<?php echo esc_attr( $file_count ); ?>" />
</p>
<?php
    }

    /**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
    public function update( $new_instance, $old_instance ) {
        $instance                    =    $old_instance;

        $instance['file_count']      =    strip_tags( $new_instance['file_count'] );
        $instance['title']           =    strip_tags( $new_instance['title'] );

        return $instance;
    }
}
?>