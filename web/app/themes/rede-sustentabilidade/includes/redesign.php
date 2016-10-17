<?php

/**
 * Redesign related functions and theme customization.
 *
 * @author Gustavo Straube, gustavo@creativeduo.com.br
 * @version 2015-05-14
 */


/**
 * Add category class to body or post classes if is single page or in the loop.
 *
 * @param array $classes
 * @return array
 */
function rs_cat_class($classes)
{
    global $post;
    if (is_single() || in_the_loop()) {
        foreach ((get_the_category($post->ID)) as $category) {
            $classes[] = 'cat-'.$category->category_nicename;
        }
        if (get_post_meta($post->ID, '_focus', true)) {
            $classes[] = 'focus';
        }
    }

    return $classes;
}

add_filter('post_class', 'rs_cat_class');
add_filter('body_class', 'rs_cat_class');


/**
 * Registers the sidebar.
 *
 */
function rs_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'rs_sidebar',
        'description'   => 'Sidebar widgets',
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}

add_action('widgets_init', 'rs_widgets_init');


/**
 * Agenda widget class.
 */
class rs_Widget_Agenda extends WP_Widget
{

    /**
     * Construct a new widget.
     */
    function __construct()
    {
        parent::__construct('rs_Widget_Agenda', 'Eventos', 'Exibe uma lista com os próximos eventos.');
    }

    /**
     * Renders the widget on front end.
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<ul>';
        $events = get_posts(array('post_type' => 'event', 'numberposts' => -1, 'meta_query' => array(array('key' => '__event_date', 'value' => date('Y-m-d'), 'compare' => '>=')), 'meta_key' => '__event_date', 'order' => 'ASC', 'orderby' => 'meta'));
        foreach ($events as $post) {
            setup_postdata($post);
            $date = get_post_meta(get_the_ID(), '__event_date', true);
            echo '<li><a class="front-link" href="' . get_permalink() . '"><strong>' . date_i18n('d/m', strtotime($date)) . '</strong> ' . get_the_title() . '</a></li>';
        }
        wp_reset_postdata();
        echo '</ul>';
        echo $args['after_widget'];
    }

    /**
     * Widget admin.
     *
     * @param array $instance
     */
    public function form($instance)
    {
        $title = '';
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

    /**
     * Updates widget data.
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

/**
 * Registers the agenda widget
 *
 */
function rs_load_widget()
{
	register_widget('rs_Widget_Agenda');
}

add_action('widgets_init', 'rs_load_widget');


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function rs_meta_box()
{
  add_meta_box('rs_focus', 'Destaque na home', 'rs_focus', 'post', 'side');
  add_meta_box('rs_author', 'Autor', 'rs_author', 'post', 'side');
  add_meta_box('rs_author', 'Autor', 'rs_author', 'post_region', 'side');
  add_meta_box('rs_author', 'Autor', 'rs_author', 'event', 'side');
}

add_action('add_meta_boxes', 'rs_meta_box');

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function rs_focus($post)
{
  wp_nonce_field('rs_meta_box', 'rs_meta_box_nonce');
  $value = get_post_meta($post->ID, '_focus', true);
  echo '<label for="rs_focus"><input type="checkbox" name="rs_focus" id="rs_focus" value="1" ' . (!empty($value) ? 'checked' : '') . '> Post destacado</label>';
}

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function rs_author($post)
{
  wp_nonce_field('rs_meta_box', 'rs_meta_box_nonce');
  $value = get_post_meta($post->ID, '_author', true);
  echo '<label for="rs_author" class="screen-reader-text">Autor</label> <input type="text" name="rs_author" id="rs_author" value="' . $value . '">';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function rs_save_post_meta($post_id)
{
  if (!isset($_POST['rs_meta_box_nonce'])
          || !wp_verify_nonce($_POST['rs_meta_box_nonce'], 'rs_meta_box')
          || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
    return;
  }
  update_post_meta($post_id, '_focus', !empty($_POST['rs_focus']));
  update_post_meta($post_id, '_author', !empty($_POST['rs_author']) ? $_POST['rs_author'] : null);
}

add_action('save_post', 'rs_save_post_meta');


/**
 * Use custom author name, if available.
 *
 * @param string $display_name The author display name.
 * @return string The filtered author display name.
 */
function rs_the_author($display_name)
{
    if (null !== $display_name) {
        $custom_author = get_post_meta(get_the_ID(), '_author', true);
        if (!empty($custom_author)) {
            $display_name = trim($custom_author);
        }
    }
    return $display_name;
}

add_filter('the_author', 'rs_the_author');
