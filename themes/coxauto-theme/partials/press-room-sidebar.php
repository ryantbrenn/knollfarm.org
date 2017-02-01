<?php
/**
 * Press Room home-page Sidebar
 *
 * @author Jess Green <jgreen@periscope.com>
 * @package Cox_Automotive_Theme
 */
$page_ID = intval(get_option('page_for_posts'));

require locate_template(array('partials/press-room-staff.php'), false, false);
?>

<p><a href="<?php the_field('pr_bios_landing_page_link', $page_ID) ?>" class="btn btn-primary arrow-right">View Leadership</a></p>
<p><a href="<?php the_field('pr_fact_sheet', $page_ID); ?>" class="btn btn-primary arrow-download">Download Fact Sheet</a></p>
<p><a href="<?php the_field('pr_logo_download', $page_ID); ?>" class="btn btn-primary arrow-download">Download Logos</a></p>
