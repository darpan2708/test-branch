<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();
?>

<div id="tribe-events-content" class="tribe-events-single">

	<?php if ( Avada()->settings->get( 'ec_all_events_link' ) ) : ?>
		<p class="tribe-events-back">
			<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"><span><?php printf( esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></span></a>
		</p>
	<?php endif; ?>

	<!-- Notices -->
	<?php
	if ( function_exists( 'tribe_the_notices' ) ) {
		tribe_the_notices();
	} else {
		tribe_events_the_notices();
	}
	?>

	<?php while ( have_posts() ) :  the_post(); ?> 
	<!-- events details start -->
	 <?php
			$event_name = get_field('event_name');
			$event_date = get_field('event_date');
			$event_location = get_field('event_location');
			//get acf field
			$link_to_info = get_field('link_to_additional_information');
			$upload_file = get_field('upload_file_or_image_');
			$add_additional_info = get_field('add_additional_information');
			$additional_input_field = get_field('additional_input_field_');
		?>
	<!-- events details end -->
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( has_post_thumbnail() ) :  ?>
				<div class="fusion-events-featured-image">
					<div class="fusion-ec-hover-type hover-type-<?php echo Avada()->settings->get( 'ec_hover_type' ); ?>">

						<?php avada_singular_featured_image(); ?>

						<?php Avada_EventsCalendar::render_single_event_title(); ?>
					</div>
			<?php else : ?>
				<div class="fusion-events-featured-image fusion-events-single-title">
					<?php Avada_EventsCalendar::render_single_event_title(); ?>
			<?php endif; ?>
				</div>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ); ?>
			<div class="tribe-events-single-event-description tribe-events-content entry-content description">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>
			<!-- Display ACF Fields -->
		<div class="event-additional-info">
		   
		   <?php if ( $link_to_info ) : ?>
			   <p><strong>Additional Information:</strong> <a href="<?php echo esc_url($link_to_info); ?>" target="_blank">Click here</a></p>
		   <?php endif; ?>

		  
		   <?php if ( $upload_file ) : ?>
			   <p><strong>Download File:</strong> <a href="<?php echo esc_url($upload_file['url']); ?>" target="_blank"><?php echo esc_html($upload_file['title']); ?></a></p>
		   <?php endif; ?>

		   <?php if ( $add_additional_info === 'Yes' ) : ?>
			   <?php if ( $additional_input_field ) : ?>
				   <div class="additional-info-section">
					   <h3>Additional Information:</h3>
					   <p><?php echo nl2br(esc_html($additional_input_field)); ?></p>
				   </div>
			   <?php else : ?>
				   <div class="additional-info-section">
					   <h3>Additional Information:</h3>
					   <p>No additional information provided.</p>
				   </div>
			   <?php endif; ?>
		   <?php endif; ?>
	   </div>

	        <!-- RSVP Button and Form -->
        <!-- RSVP Button -->
<button id="rsvp-button" onclick="toggleRSVPForm()">RSVP Now</button>

<!-- Event details (hidden initially) -->
<div id="event-details" style="display: none;">
    <p>Event Name: <span id="event-name"><?php echo esc_html($event_name); ?></span></p>
    <p>Date: <span id="event-date"><?php echo esc_html($event_date); ?></span></p>
    <p>Location: <span id="event-location"><?php echo esc_html($event_location); ?></span></p>
</div>



<!-- RSVP Form -->
<div id="rsvp-form" style="display: none;">
    <h3>RSVP for This Event</h3>
    <form method="POST" id="rsvpf" enctype="multipart/form-data">
	<input type="hidden" name="rsvp_nonce" value="<?php echo wp_create_nonce('rsvp_nonce_action'); ?>" />

        <input type="hidden" name="action" value="rsvp_form_submission" />
        <input type="hidden" name="event_name" id="hidden-event-name" value="<?php echo esc_attr($event_name); ?>" />
        <input type="hidden" name="event_date" id="hidden-event-date" value="<?php echo esc_attr($event_date); ?>" />
        <input type="hidden" name="event_location" id="hidden-event-location" value="<?php echo esc_attr($event_location); ?>" />
        
        <label for="first_name">First Name <span>*</span></label>
        <input type="text" id="first_name" name="first_name" required />

        <label for="last_name">Last Name <span>*</span></label>
        <input type="text" id="last_name" name="last_name" required />

        <label for="num_people">How many people will you be bringing, including yourself? <span>*</span></label>
        <input type="number" id="num_people" name="num_people" required />

        <label for="email_address">Email Address <span>*</span></label>
        <input type="email" id="email_address" name="email_address" required />
        
        <label for="upload_file">Upload File</label>
        <input type="file" id="upload_file" name="upload_file" />

        <label for="special_requests">Do you have any special requests or needs?</label>
        <textarea id="special_requests" name="special_requests"></textarea>

        <button class="event-rsvp" type="submit">RSVP</button>
    </form>
</div>

<script>
    function toggleRSVPForm() {
        var form = document.getElementById('rsvp-form');
        var eventDetails = document.getElementById('event-details');
        
        // Toggle form visibility
        if (form.style.display === 'none') {
            form.style.display = 'block';
            eventDetails.style.display = 'block';  
        } else {
            form.style.display = 'none';
            eventDetails.style.display = 'none';  
        }

		
         
        document.getElementById('event-name').textContent = '<?php echo esc_js($event_name); ?>';
        document.getElementById('event-date').textContent = '<?php echo esc_js($event_date); ?>';
        document.getElementById('event-location').textContent = '<?php echo esc_js($event_location); ?>';
        document.getElementById('hidden-event-name').value = '<?php echo esc_js($event_name); ?>';
        document.getElementById('hidden-event-date').value = '<?php echo esc_js($event_date); ?>';
        document.getElementById('hidden-event-location').value = '<?php echo esc_js($event_location); ?>';
    }
</script>

			<!-- Event meta -->
			<?php
			$columns = 1;
			$layout_class = '';

			if ( tribe_has_organizer() ) {
				$columns += 1;
			} else {
				$layout_class = ' fusion-event-meta-no-organizer';
			}

			$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );

			if ( tribe_get_venue_id() ) {
				// If we have no map to embed and no need to keep the venue separate...
				if ( ! $set_venue_apart && ! tribe_embed_google_map() ) {
					$layout_class .= ' fusion-event-meta-venue';
					$columns += 1;
				} elseif ( ! $set_venue_apart && ! tribe_has_organizer() && tribe_embed_google_map() ) {
					$layout_class .= ' fusion-event-meta-venue-map';
					$columns += 2;
				} else {
					$set_venue_apart = true;
				}
			}

			if ( $set_venue_apart )	{
				$layout_class .= ' fusion-event-meta-venue-apart';
				$columns = 4;
			}

			if ( 'below_content' === Avada()->settings->get( 'ec_meta_layout' ) ) :
			?>
				<?php do_action( 'tribe_events_single_event_before_the_meta' ); ?>
				<div class="fusion-content-widget-area fusion-event-meta-columns fusion-event-meta-columns-<?php echo esc_attr( $columns ) . esc_attr( $layout_class ); ?>">
					<div class="fusion-event-meta-wrapper">
						<?php tribe_get_template_part( 'modules/meta' ); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ); ?>
		</div> <!-- #post-x -->

		<?php avada_render_social_sharing( 'events' ); ?>

		<?php
		if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) {

			add_filter( 'comments_template', 'add_comments_template' );

			function add_comments_template() {
				return Avada::$template_dir_path . '/comments.php';
			}

			comments_template();
		}
		?>
	<?php endwhile;
	?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( __( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '%title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title%' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
