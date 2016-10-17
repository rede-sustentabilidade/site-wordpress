<?php

/*
 * Basic setup
 */

function rs_setup()
{
  add_image_size('regional-thumb', 312, 9999);
}

add_action('after_setup_theme', 'rs_setup');


/*
 * Custom post type
 */


function rs_custom_type()
{
  $gte_3_8 = version_compare(get_bloginfo('version'), '3.8.0', '>=');

	$args = array(
		'public' => true,
		'label' => __('Eventos', 'rede-sustentabilidade'),
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
		'capability_type' => 'event',
		'map_meta_cap' => true,
	);
	if ($gte_3_8) {
	  $args['menu_icon'] = 'dashicons-calendar';
	}
	register_post_type('event', $args);
}

add_action('init', 'rs_custom_type');


function rs_post_class($classes)
{
  global $post;
  if (in_array($post->post_type, array('event'))) {
    $classes[] = 'type-post';
    $classes[] = 'post';
  }
  return $classes;
}

add_filter('post_class', 'rs_post_class');

/*
 * Post restrictions.
 */

function rs_post_capabilities()
{
  add_role('editor_region', __('Editor regional', 'rede-sustentabilidade'), array(
    'read_post_region' => true,
    'delete_others_post_regions' => true,
    'delete_post_regions' => true,
    'delete_private_post_regions' => true,
    'delete_published_post_regions' => true,
    'edit_others_post_regions' => true,
    'edit_post_regions' => true,
    'edit_private_post_regions' => true,
    'edit_published_post_regions' => true,
    'publish_post_regions' => true,
    'read_private_post_regions' => true,

    'read_event' => true,
    'delete_others_events' => true,
    'delete_events' => true,
    'delete_private_events' => true,
    'delete_published_events' => true,
    'edit_others_events' => true,
    'edit_events' => true,
    'edit_private_events' => true,
    'edit_published_events' => true,
    'publish_events' => true,
    'read_private_events' => true,

    'read' => true,
    'unfiltered_html' => true,
    'upload_files' => true,
  ));
  add_role('contributor_region', __('Colaborador regional', 'rede-sustentabilidade'), array(
    'read_post_region' => true,
    'delete_post_regions' => true,
    'edit_post_regions' => true,

    'read_event' => true,
    'delete_events' => true,
    'edit_events' => true,

    'read' => true,
    'upload_files' => true,
  ));

  $role = get_role('administrator');
  $caps = array(
    'read_post_regions',
    'delete_others_post_regions',
    'delete_post_regions',
    'delete_private_post_regions',
    'delete_published_post_regions',
    'edit_others_post_regions',
    'edit_post_regions',
    'edit_private_post_regions',
    'edit_published_post_regions',
    'publish_post_regions',
    'read_private_post_regions',

    'read_event',
    'delete_others_events',
    'delete_events',
    'delete_private_events',
    'delete_published_events',
    'edit_others_events',
    'edit_events',
    'edit_private_events',
    'edit_published_events',
    'publish_events',
    'read_private_events',
  );
  foreach ($caps as $cap) {
  	$role->add_cap($cap);
  }
}

add_action('init', 'rs_post_capabilities');


/*
 * Event listing.
 */

function rs_event_listing_rewrite()
{
  add_rewrite_rule('agenda/regional/([a-z]+)/?$', 'index.php?state=$matches[1]&post_type=event&only_event=1', 'top');
}

add_action('init', 'rs_event_listing_rewrite');

function rs_event_listing_query($query_vars)
{
  $query_vars[] = 'only_event';
  return $query_vars;
}

add_filter('query_vars', 'rs_event_listing_query');


/*
 * Event meta data.
 */

function rs_meta()
{
  add_meta_box('rs_event_meta', __('Detalhes', 'rede-sustentabilidade'), 'rs_event_meta', 'event', 'side');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-ui-style', 'http://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css');
}

add_action('add_meta_boxes', 'rs_meta');

function rs_event_meta($post)
{
  wp_nonce_field('rs_event_meta', 'rs_event_meta_nonce');
  $date = get_post_meta($post->ID, '__event_date', true);
  $time = get_post_meta($post->ID, '__event_time', true);
  $place = get_post_meta($post->ID, '__event_place', true);
  ?>
  <p>
    <label for="myplugin_new_field"><?php _e('Data', 'rede-sustentabilidade'); ?></label><br />
    <input type="text" id="rs_event_date" name="event_date" value="<?php if (!empty($date)) echo esc_attr(date('d/m/Y', strtotime($date))); ?>" size="8" />
  </p>
  <p>
    <label for="myplugin_new_field"><?php _e('Hora', 'rede-sustentabilidade'); ?></label><br />
    <input type="text" id="rs_event_time" name="event_time" value="<?php echo esc_attr($time); ?>" size="8" />
  </p>
  <p>
    <label for="myplugin_new_field"><?php _e('Local', 'rede-sustentabilidade'); ?></label><br />
    <textarea id="rs_event_place" name="event_place" cols="25" rows="3"><?php echo esc_html($place); ?></textarea>
  </p>
  <?php
}

function rs_event_js()
{
	global $current_screen;
	if ($current_screen->id != 'event' || $current_screen->post_type != 'event') {
		return;
	}
	?>
	<script type="text/javascript">

	  // Set cursor jQuery plugin
	  new function($) {
      $.fn.setCursorPosition = function(pos) {
        if (this.setSelectionRange) {
          this.setSelectionRange(pos, pos);
        } else if (this.createTextRange) {
          var range = this.createTextRange();
          range.collapse(true);
          range.moveEnd('character', pos);
          range.moveStart('character', pos);
          range.select();
        }
      }
    }(jQuery);

		jQuery(document).ready(function () {
		  jQuery('#rs_event_date').datepicker({
		    dateFormat: 'dd/mm/yy'
	    });
	    jQuery('#rs_event_time').on('keyup', function () {
	      var
	      $self = jQuery(this),
	      value = $self.val().replace(/[^0-9]+/, '').substr(0, 4);
	      if (value.length > 2) {
  	      $self.val(value.substr(0, 2) + ':' + value.substr(2, 4));
	      }
	    });
    });
	</script>
	<?php
}

add_action('admin_footer', 'rs_event_js');

function rs_save_post($post_id)
{

  if (!isset($_POST['rs_event_meta_nonce'])
      || !wp_verify_nonce($_POST['rs_event_meta_nonce'], 'rs_event_meta')
      || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      || !current_user_can('edit_post', $post_id)) {
    return $post_id;
  }

  if (isset($_POST['event_date'])
      || isset($_POST['event_time'])
      || isset($_POST['event_place'])) {
    $date = sanitize_text_field($_POST['event_date']);
    $time = sanitize_text_field($_POST['event_time']);
    $place = sanitize_text_field($_POST['event_place']);

    $date = date_create_from_format('d/m/Y', $date);
    if ($date) {
      $date = $date->format('Y-m-d');
    } else {
      $date = '';
    }

    update_post_meta($post_id, '__event_date', $date);
    update_post_meta($post_id, '__event_time', $time);
    update_post_meta($post_id, '__event_place', $place);
  }
}

add_action('save_post', 'rs_save_post');


/*
 * Custom taxonomy (categories)
 * Each category represents a state
 */

function rs_custom_tax()
{
	$args = array(
		'label' => __('Estado', 'rede-sustentabilidade'),
		'rewrite' => array('slug' => 'regional'),
		'hierarchical' => true,
		'show_admin_column' => true,
		'capabilities' => array(
			'manage_terms' => 'manage_states',
			'edit_terms' => 'manage_states',
			'delete_terms' => 'manage_states',
			'assign_terms' => 'edit_post_regions',
		),
	);
	register_taxonomy('state', 'post_region', $args);
	register_taxonomy_for_object_type('state', 'event');
}

add_action('init', 'rs_custom_tax');

function rs_archive_tax($wp_query)
{
  if (is_tax('state') && empty($wp_query->query_vars['post_type'])) {
    set_query_var('post_type', 'post_region');
  }
}

add_action('pre_get_posts', 'rs_archive_tax');

function rs_body_class($classes)
{
  if (is_singular()) {
    $custom_terms = get_the_terms(0, 'state');
    if ($custom_terms) {
      foreach ($custom_terms as $custom_term) {
        $classes[] = 'tax-state';
        $classes[] = 'term-'.$custom_term->slug;
      }
    }
  }
  return $classes;
}

add_filter('body_class', 'rs_body_class');

/*
 * Taxonomy restrictions.
 */

function rs_tax_capabilities()
{
	$role = get_role('administrator');
	$role->add_cap('manage_states');
}

add_action('admin_init', 'rs_tax_capabilities');

function rs_limit_states($args, $taxonomies)
{
	if (in_array('state', $taxonomies) && empty($args['ignore_state_restriction']) && !current_user_can('manage_states')) {
		$user_states = get_user_meta(get_current_user_id(), '__user_states', true);
		if (!is_array($user_states)) {
			$user_states = array();
		}
		$states = get_terms('state', array('hide_empty' => false, 'exclude' => $user_states, 'ignore_state_restriction' => true, 'fields' => 'ids'));
		$args['exclude'] = array_merge($args['exclude'], $states);
	}
	return $args;
}

add_filter('get_terms_args', 'rs_limit_states', 10, 2);

function rs_posts_filter($query)
{
	global $pagenow;
	$type = 'post';
	if (isset($_GET['post_type'])) {
		$type = $_GET['post_type'];
	}
	if ('post_region' == $type && is_admin() && $pagenow == 'edit.php' && !current_user_can('manage_states')) {
		$user_states = get_user_meta(get_current_user_id(), '__user_states', true);
		if (!is_array($user_states)) {
			$user_states = array();
		}
		if (empty($query->query_vars['tax_query'])) {
			$query->query_vars['tax_query'] = array();
		}
		$query->query_vars['tax_query'][] = array('taxonomy' => 'state', 'field' => 'term_id', 'terms' => $user_states, 'operator' => 'IN');
	}
}

add_filter('parse_query', 'rs_posts_filter');

function rs_posts_edit()
{
    global $post_type;
	$user_states = get_user_meta(get_current_user_id(), '__user_states', true);
	if (count($user_states) == 1 && in_array($post_type, array('post_region', 'event'))) {
?>
<script>
;(function ($) { $(document).ready(function () { $('#in-state-<?php echo $user_states[0]; ?>').attr('checked', 'checked'); }); })(jQuery);
</script>
<?php
    }
}

add_action('admin_head-post-new.php', 'rs_posts_edit', 11);

/*
 * Region/state configuration on user profile.
 */

function rs_user_fields($user)
{
	$states = get_terms('state', array('hide_empty' => false));
	$user_states = get_user_meta($user->ID, '__user_states', true);
	if (!is_array($user_states)) {
		$user_states = array();
	}
	$can_edit = current_user_can('promote_users', $user_id);
	?>
	<h3><?php _e('Região', 'rede-sustentabilidade'); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Estados', 'rede-sustentabilidade'); ?></th>
			<td>
				<fieldset>
					<label for="rs_user_state_all"><input type="checkbox" name="user_state_all" id="rs_user_state_all" value="1" onclick="jQuery('[name=\'user_state[]\']').prop('checked', this.checked);" <?php if (!$can_edit) echo 'disabled="disabled"'; ?> /> <span><strong><?php _e('Selecionar todos', 'rede-sustentabilidade'); ?></strong></span></label><br />
					<?php $i = 0; foreach ($states as $state) : ?>
					<label for="rs_user_state_<?php echo $state->term_id; ?>"><input type="checkbox" name="user_state[]" id="rs_user_state_<?php echo $state->term_id; ?>" value="<?php echo $state->term_id; ?>" <?php if (in_array($state->term_id, $user_states)) echo 'checked="checked"'; ?> <?php if (!$can_edit) echo 'disabled="disabled"'; ?> /> <span><?php echo $state->name; ?> (<?php echo strtoupper($state->slug); ?>)</span></label><br />
					<?php $i++; endforeach; ?>
					<?php if ($can_edit) : ?>
					<span class="description"><?php _e('O usuário terá acesso apenas aos posts regionais relacionados aos estados especificados.', 'rede-sustentabilidade'); ?></span>
					<?php endif; ?>
				</fieldset>
			</td>
		</tr>
	</table>
	<?php
}

add_action('show_user_profile', 'rs_user_fields');
add_action('edit_user_profile', 'rs_user_fields');

function rs_user_columns($columns)
{
	 $columns['user_state'] = __('Estado', 'rede-sustentabilidade');
	 return $columns;
}

add_filter('manage_users_columns', 'rs_user_columns');

function rs_user_values($value, $column_name, $id)
{
	switch ($column_name) {
		case 'user_state':
			$user_states = get_user_meta($id, '__user_states', true);
			if (empty($user_states) || !is_array($user_states)) {
				return '-';
			}
			$states = get_terms('state', array('hide_empty' => false, 'include' => $user_states, 'fields' => 'names'));
			return implode(', ', $states);
	}
}

add_action('manage_users_custom_column', 'rs_user_values', 10, 3);


/*
 * Save region/state configuration on user profile.
 */

function rs_user_save($user_id)
{
	if (!current_user_can('promote_users', $user_id)) {
		return false;
	}

	$states = !empty($_POST['user_state']) ? $_POST['user_state'] : array();
	if (!is_array($states)) {
		$states = array((int) $states);
	}
	update_user_meta($user_id, '__user_states', $states);
}

add_action('personal_options_update', 'rs_user_save');
add_action('edit_user_profile_update', 'rs_user_save');

function getStateFromUserId($user_id) {

  if ( !empty($user_id) ) {
    $user_states = get_user_meta($user_id, '__user_states', true);
    $uf = get_terms('state', array('hide_empty' => false, 'include' => $user_states));

    if ( (is_array($uf)) && (count($uf) == 1) && (property_exists($uf[0], 'slug')) ) {
      return $uf[0]->slug;
    }
  }

  return false;
}
