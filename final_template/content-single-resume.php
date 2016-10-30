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
<a id="print-it" href="<?php echo add_query_arg( 'download', true, get_permalink( $post->ID ) ); ?>	">
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

		// First the table with resume
		$table = $section->addTable();

		// a new row at the table
		$table->addRow(200);

		// profile name
		$table->addCell(3600)->addText("Beraterprofil: " . get_the_title());

		// profile image
		$logo = get_the_candidate_photo( $post );
		$logo = job_manager_get_resized_image( $logo, 'medium' );

		if(!empty($logo)) {
			$table->addCell(3600)->addImage($logo, array('width' => 200, 'height' => 200));
		} else {
			$table->addCell(3600)->addText("Profile image not found.");
		}

		// a new row at the table
		$table->addRow(200);

		// german translate
		$table->addCell(4800)->addText("Personliche Daten des Beraters");

		// a new row at the table
		$table->addRow(200);

		// Jahrgang
		$table->addCell(3600)->addText("Jahrgang");
		$table->addCell(3600)->addText(get_post_meta( $post->ID, '_candidate_jahrgang', true ));

		// a new row at the table
		$table->addRow(200);

		// Projekterfahrung seit
		$table->addCell(3600)->addText("Projekterfahrung seit");
		$table->addCell(3600)->addText(get_post_meta( $post->ID, '_candidate_projects_since', true ));

		// a new row at the table
		$table->addRow(200);

		// Staatsbürgerschaft
		$table->addCell(3600)->addText("Staatsbürgerschaft");
		$table->addCell(3600)->addText(get_post_meta( $post->ID, '_candidate_staatsbuergerschaft', true ));

		$section->addTextBreak(1);

		// ZUSAMMENFASSUNG
		$section->addText('ZUSAMMENFASSUNG', $titleStyle);
		$content = get_the_content();
		$section->addText($content);

		// LEISTUNGBILANZ
		$section->addText('LEISTUNGBILANZ', $titleStyle);
		$content = get_post_meta( $post->ID, '_candidate_performance_track', true );
		$section->addText($content);

		// Education
		$section->addText(__( 'Education', 'wp-job-manager-resumes' ), $titleStyle);

		$educationItems = get_post_meta( $post->ID, '_candidate_education', true );

		if(!empty($educationItems)) {
			foreach($educationItems as $item) {

				$section->addTextBreak(1);

				if(!empty($item['date'] )) {
					$section->addListItem('Date: ' . esc_html( $item['date'] ), 0, null);
				}

				if(!empty($item['location'] )) {
					$section->addListItem('Location: ' . esc_html( $item['location'] ), 0, null);
				}
				
				if(!empty($item['qualification'] )) {
					$section->addListItem('Qualification: ' . esc_html( $item['qualification'] ), 0, null);
				}

				if(!empty($item['notes'] )) {
					$section->addListItem('Notes: ' . wpautop( wptexturize( $item['notes'] ) ), 0, null);
				}
			}
		}

		// Experience
		$section->addText(__( 'Experience', 'wp-job-manager-resumes' ), $titleStyle);

		$experienceItems = get_post_meta( $post->ID, '_candidate_experience', true );

		if(!empty($experienceItems)) {
			foreach($experienceItems as $item) {

				$section->addTextBreak(1);

				if(!empty($item['date'] )) {
					$section->addListItem('Date: ' . esc_html( $item['date'] ), 0, null);
				}

				if(!empty($item['job_title'] )) {
					$section->addListItem('Job Title: ' . esc_html( $item['job_title'] ), 0, null);
				}
				
				if(!empty($item['employer'] )) {
					$section->addListItem('Employer: ' . esc_html( $item['employer'] ), 0, null);
				}

				if(!empty($item['project_description'] )) {
					$section->addListItem('Project Description: ' . wpautop( wptexturize( $item['project_description'] ) ), 0, null);
				}
				
				if(!empty($item['notes'] )) {
					$section->addListItem('Notes: ' . wpautop( wptexturize( $item['notes'] ) ), 0, null);
				}
			}
		}

		// store the resume at a public folder
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('wp-content/uploads/resumes/resume.docx');
?>

<script type="text/javascript">
	var resumeUrl = "<?php echo wp_upload_dir()['baseurl']; ?>/resumes/resume.docx";

	window.location.href = resumeUrl;
</script>
<?php } ?>

<!-- Begin Download resume as .docx -->