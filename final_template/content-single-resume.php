<?php if ( resume_manager_user_can_view_resume( $post->ID ) ) : ?>
<?php global $post; ?>
<style>
.entry-content-header {display: none;}
</style>
	<table class="job-manager-jobs">
		<thead>
			<tr>
				<th style="vertical-align: top">
				<div style="display: inline-block">
				    Beraterprofil
					<h3><?php the_title(); ?></h3>
				</div>
				</th>
				<th><div style="float:right"><?php the_candidate_photo('medium'); ?></div></th>
			</tr>
		</thead>
		<tbody>
			<tr>
		  		<td colspan="2"><strong>Pers�nliche Daten des Beraters<strong></td>
        	</tr>
        	<tr>
        		<td>Jahrgang</td>
        		<td><?php echo get_post_meta( $post->ID, '_candidate_jahrgang', true );?></td>
        	</tr>
        	<tr>
        		<td>Projekterfahrung seit: </td>	
        		<td><?php echo get_post_meta( $post->ID, '_candidate_projects_since', true );?></td>
        	</tr>
        	<tr>
        		<td>Staatsb�rgerschaft:</td>
        		<td><?php echo get_post_meta( $post->ID, '_candidate_staatsbuergerschaft', true );?></td>
        	</tr>
         </tbody>
        </table>    		
	<div style='padding-bottom:10px;' class='av-special-heading av-special-heading-h3    avia-builder-el-1  el_after_av_layerslider  el_before_av_textblock  avia-builder-el-first '>
		<h3 class='av-special-heading-tag'  itemprop="headline"  >ZUSAMMENFASSUNG</h3>
		<div class='special-heading-border'><div class='special-heading-inner-border' ></div>
	</div>
	<section class="av_textblock_section"  itemscope="itemscope" itemtype="https://schema.org/CreativeWork" >
		<div class='avia_textblock ' itemprop="text" >
			<div class="resume_description">
				<?php echo apply_filters( 'the_resume_description', get_the_content() ); ?>
			</div>
		</div>
	</section>
	<div style='padding-bottom:10px;' class='av-special-heading av-special-heading-h3    avia-builder-el-1  el_after_av_layerslider  el_before_av_textblock  avia-builder-el-first '>
		<h3 class='av-special-heading-tag'  itemprop="headline"  >LEISTUNGBILANZ</h3>
		<div class='special-heading-border'><div class='special-heading-inner-border' ></div>
	</div>
	<section class="av_textblock_section"  itemscope="itemscope" itemtype="https://schema.org/CreativeWork" >
		<div class='avia_textblock ' itemprop="text" >
			<div class="resume_description">
				<?php echo get_post_meta( $post->ID, '_candidate_performance_track', true );?>
			</div>
		</div>
	</section>
	<div class="single-resume-content">
		<?php if ( ( $skills = wp_get_object_terms( $post->ID, 'resume_skill', array( 'fields' => 'names' ) ) ) && is_array( $skills ) ) : ?>
			<h3><?php echo strtoupper(__( 'Skills', 'wp-job-manager-resumes' )); ?></h3>
			<ul class="resume-manager-skills">
				<?php echo '<li>' . implode( '</li><li>', $skills ) . '</li>'; ?>
			</ul>
		<?php endif; ?>
		<?php if ( $items = get_post_meta( $post->ID, '_candidate_education', true ) ) : ?>
			<h3><?php echo strtoupper(__( 'Education', 'wp-job-manager-resumes' )); ?></h3>
			<dl class="resume-manager-education">
			<?php
				foreach( $items as $item ) : ?>

					<dt>
						<small class="date"><?php echo esc_html( $item['date'] ); ?></small>
						<h3><?php printf( __( '%s  %s', 'wp-job-manager-resumes' ), '</strong>', '<strong class="location">' . esc_html( $item['location'] ) . '</strong> :'.' <strong class="qualification">' . esc_html( $item['qualification'] )  ); ?></h3>
					</dt>
					<dd>
						<?php echo wpautop( wptexturize( $item['notes'] ) ); ?>
					</dd>

				<?php endforeach;
			?>
			</dl>
		<?php endif; ?>

		<?php if ( $items = get_post_meta( $post->ID, '_candidate_experience', true ) ) : ?>
			<h3><?php echo strtoupper(__( 'Experience', 'wp-job-manager-resumes' )); ?></h3>
			<dl class="resume-manager-experience">
			<?php
				foreach( $items as $item ) : ?>
					<dt>
						<small class="date"><?php echo esc_html( $item['date'] ); ?></small>
						<h3><?php printf( __( '%s at %s', 'wp-job-manager-resumes' ), '<strong class="job_title">' . esc_html( $item['job_title'] ) . '</strong>', '<strong class="employer">' . esc_html( $item['employer'] ) . '</strong>' ); ?></h3>
					</dt>
					<dd>
						<?php echo wpautop( wptexturize( $item['project_description'] ) ); ?>
					</dd>
					<dd>
						<?php echo wpautop( wptexturize( $item['notes'] ) ); ?>
					</dd>

				<?php endforeach;
			?>
			</dl>
		<?php endif; ?>

		<ul class="meta">
			<?php do_action( 'single_resume_meta_start' ); ?>

			<?php if ( get_the_resume_category() ) : ?>
				<li class="resume-category"><?php the_resume_category(); ?></li>
			<?php endif; ?>

			<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Updated %s ago', 'wp-job-manager-resumes' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date></li>

			<?php do_action( 'single_resume_meta_end' ); ?>
		</ul>

		<?php get_job_manager_template( 'contact-details.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

		<?php do_action( 'single_resume_end' ); ?>
	</div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
<span class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>"><?php the_job_type(); ?></span>
<?php endif; ?>
<?php do_action( 'single_resume_start' ); ?>

<!-- Begin Download resume as .docx -->
<a id="print-it" href="<?php echo add_query_arg( 'download', true, get_permalink( $post->ID ) ); ?>#download">
	<span class="dashicons dashicons-download"></span> <?php _e( 'Download resume as .docx', 'wp-job-manager-resumes' ); ?>
</a>

<?php
	// if user press on download button
	if(!empty($_GET['download'])) {
		require_once "docx-lib/vendor/autoload.php";


		$titleStyle = array('size' => 20, 'bold' => true);

		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		// Adding an empty Section to the document...
		$section = $phpWord->addSection();

		$logo = get_the_candidate_photo( $post );
		$logo = job_manager_get_resized_image( $logo, 'medium' );

		$educationItems = get_post_meta( $post->ID, '_candidate_education', true );
		$experienceItems = get_post_meta( $post->ID, '_candidate_experience', true );

		$content = '<h1>Beraterprofil</h1>';
		$content .= '<p>' . get_the_title() . '</p>';

		if(!empty($logo)) {
			$section->addImage($logo, array('width' => 200, 'height' => 200));
		}

		$content .= '<h1>Personliche Daten des Beraters</h1>';

		$content .= '<h1>Jahrgang</h1>';
		$content .= '<p>' . get_post_meta( $post->ID, '_candidate_jahrgang', true ) . '</p>';

		$content .= '<h1>Projekterfahrung seit</h1>';
		$content .= '<p>' . get_post_meta( $post->ID, '_candidate_projects_since', true ) . '</p>';

		$content .= '<h1>Staatsbürgerschaft</h1>';
		$content .= '<p>' . get_post_meta( $post->ID, '_candidate_staatsbuergerschaft', true ) . '</p>';

		$content .= '<h1>ZUSAMMENFASSUNG</h1>';
		$content .= '<p>' . get_the_content() . '</p>';

		$content .= '<h1>LEISTUNGBILANZ</h1>';
		$content .= '<p>' . get_post_meta( $post->ID, '_candidate_performance_track', true ) . '</p>';

		$content .= '<h1>Education</h1>';

		if(!empty($educationItems)) {
			$content .= '<ul>';
			foreach($educationItems as $item) {
				$content .= '<ol>';

				if(!empty($item['date'] )) {
					$content .= '<li>';
					$content .= "Date: " . esc_html( $item['date'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['location'] )) {
					$content .= '<li>';
					$content .= "Location: " . esc_html( $item['location'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['qualification'] )) {
					$content .= '<li>';
					$content .= "Qualification: " . esc_html( $item['qualification'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['notes'] )) {
					$content .= '<li>';
					$content .= "Notes: " . wpautop( wptexturize( $item['notes'] ) ) . "";
					$content .= '</li>';
				}

				$content .= '</ol>';

			}
			$content .= '</ul>';
		}

		$content .= '<h1>Experience</h1>';

		if(!empty($experienceItems)) {
			$content .= '<ul>';
			foreach($experienceItems as $item) {
				$content .= '<ol>';

				if(!empty($item['date'] )) {
					$content .= '<li>';
					$content .= "Date: " . esc_html( $item['date'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['job_title'] )) {
					$content .= '<li>';
					$content .= "Job Title: " . esc_html( $item['job_title'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['employer'] )) {
					$content .= '<li>';
					$content .= "Employer: " . esc_html( $item['employer'] ) . "";
					$content .= '</li>';
				}

				if(!empty($item['project_description'] )) {
					$content .= '<li>';
					$content .= "Project Description: " . wpautop( wptexturize( $item['project_description'] ) ) . "";
					$content .= '</li>';
				}

				if(!empty($item['notes'] )) {
					$content .= '<li>';
					$content .= "Notes: " . wpautop( wptexturize( $item['notes'] ) ) . "";
					$content .= '</li>';
				}

				$content .= '</ol>';

			}
			$content .= '</ul>';
		}

		\PhpOffice\PhpWord\Shared\Html::addHtml($section, $content);

		// store the resume at a public folder
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('wp-content/uploads/resumes/' . $post->post_name . '.docx');
?>

<a id="download" href="<?php echo wp_upload_dir()['baseurl']; ?>/resumes/<?php echo $post->post_name; ?>.docx" style="display: block; box-shadow: none;">Click here to start the download</a>
<?php } ?>

<!-- Begin Download resume as .docx -->