<?php get_header(); ?>



							<?php	if ( isset($_GET['cr_scan1']) || isset($_GET['cr_scan2']) ):
								$loop = get_3d_file_search();
								if (($loop != null ) && $loop->have_posts() ):
									
									?>

<section id="faq">
	<header class="title">
		<h1>Found it!</h1>
	</header>

	<div class="wrap">
		<div class="layout">
	<?php
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$meta_image = my_attachment_gallery(get_the_ID(), '3d_thumb');
	?>

							<article class="faq-item clearfix">
								<aside><img src="<?php echo $meta_image[0][0]; ?>"; ?></aside>
								<h2><?php echo ucwords(get_the_title()); ?></h2>

								<?php
									$args = array(
										'post_type' => 'attachment',
										'numberposts' => -1,
										'post_status' => null,
										'post_mime_type' => 'application/zip', // set the mime type to get all zips
										'post_parent' => get_the_ID()
										); 
									$attachments = get_posts($args);
									if ($attachments) :
										foreach ($attachments as $post) :
											setup_postdata($post); 
									?>
								<p class="np"><a class="btn btn-secondary" href="<?php echo wp_get_attachment_url($post->ID); ?>">Download Your 3D Scan File!<i></i></a></p>
								<p>***To view your file after downloading it, please install a copy of <a href="http://meshlab.sourceforge.net/">MeshLab</a>***</p>
								<p>Filename: <?php echo basename(get_attached_file($post->ID)); ?> <br/>
								Filesize: <?php  echo formatSizeUnits(filesize( get_attached_file( $post->ID )) ) ;?></p>

							<?php 
									endforeach; 
								endif;
							?>
							</article>
							<?php
									endwhile;
									?>
						</div>
					</div>
				</section>
							<?php	else:	?>
	<section id="contact">
		<header class="title">
			<h1>Download Your 3D Scan!</h1>
		</header>
		<div id="quotables">
		</div>
		<div class="wrap">
			<div class="layout clearfix">
				<aside>
					<p>Find your 3D Scan by entering the email or twitter handle you provided us on sign-up.</p>
					<p class="info"><a href="http://twitter.com/my3dscan" target="_blank" title="My3DScan Twitter">@My3DScan</a></p>
					<p class="info"><a href="http://twitter.com/draftprint3d" target="_blank" title="Draft Print 3D Twitter">@DraftPrint3D</a></p>
					<p class="info"><a href="http://twitter.com/peopleandcode" target="_blank" title="People &amp; Code Twitter">@PeopleAndCode</a></p>
				</aside>
				<div id="connect">
					<hgroup>
						<h2>Couldn't Find Your Scan. Please try again.</h2>
					</hgroup>
						<form action="<?php the_permalink(); ?>" id="contactForm" class="form-stacked" method="get">
							<div class="row">
								<div class="input span1">
									<label>Email</label>
									<div class="input-wrap"><input class="span4" name ="cr_scan2" type="text" value=""></div>
								</div>
							</div>
							<div class="row">
								<h2>OR</h2>
							</div>
														<div class="row">

								<div class="input span1">
									<label>Twitter</label>
									<div class="input-wrap"><input class="span4" name ="cr_scan1" type="text" value=""></div>
								</div>
							</div>
							<div class="row">
								<div class="action">
									<button type="submit" class="btn btn-primary">Find my 3D scan!</button>
									<input type="hidden" name="submitted" id="submitted" value="true" />
								</div>
							</div>
						</form>
					</div>

			</div>
		</div>
	</section>

								<?php
								endif;
							?>

						<?php else: ?>
	<section id="contact">
		<header class="title">
			<h1>Download Your 3D Scan!</h1>
		</header>
		<div id="quotables">
		</div>
		<div class="wrap">
			<div class="layout clearfix">
				<aside>
					<p>Find your 3D Scan by entering the email or twitter handle you provided us on sign-up.</p>
					<p class="info"><a href="http://twitter.com/my3dscan" target="_blank" title="My3DScan Twitter">@My3DScan</a></p>
					<p class="info"><a href="http://twitter.com/draftprint3d" target="_blank" title="Draft Print 3D Twitter">@DraftPrint3D</a></p>
					<p class="info"><a href="http://twitter.com/peopleandcode" target="_blank" title="People &amp; Code Twitter">@PeopleAndCode</a></p>
				</aside>
				<div id="connect">
					<hgroup>
						<h2>Find your 3D Scan By:</h2>
					</hgroup>
						<form action="<?php the_permalink(); ?>" id="contactForm" class="form-stacked" method="get">
							<div class="row">
								<div class="input span1">
									<label>Email</label>
									<div class="input-wrap"><input class="span4" name ="cr_scan2" type="text" value=""></div>
								</div>
							</div>
							<div class="row">
								<h2>OR</h2>
							</div>
														<div class="row">

								<div class="input span1">
									<label>Twitter</label>
									<div class="input-wrap"><input class="span4" name ="cr_scan1" type="text" value=""></div>
								</div>
							</div>
							<div class="row">
								<div class="action">
									<button type="submit" class="btn btn-primary">Sign up!</button>
									<input type="hidden" name="submitted" id="submitted" value="true" />
								</div>
							</div>
						</form>
					</div>

			</div>
		</div>
	</section>

							<?php endif; ?>



<?php get_footer(); ?>