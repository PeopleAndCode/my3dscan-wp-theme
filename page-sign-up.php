<?php
	/*
	Template Name: sign-up
	*/
	if(isset($_POST['submitted'])) {
		$email = is_email(trim($_POST['email']));
		$name = sanitize_text_field(trim($_POST['fname']));
		$twitter = sanitize_text_field(trim($_POST['twitter']));
		$twitter = validate_twitterHandle($twitter);

		if( $email === false ) {
			$emailError = 'Please enter a valid email address.';
			$hasError = true;
		}

		if( $fname === '') {
			$fnameError = 'Please enter your name.';
			$hasError = true;
		}

		if ( $twitter === false ) {
			$twitterError = 'Invalid Twitter handle...try again or leave it blank.';
			$hasError = true;
		}

		if(!isset($hasError)) {
			$new_post = array(
				'post_title' => ucwords($name),
				'post_name' => str_replace(" ", "-", $name),
				'post_status' => 'draft',
				'post_author' => 1,
				'post_type' => 'pc_3dscan'
			);
			$scan_id = wp_insert_post($new_post);

			if($scan_id !== 0){
				update_post_meta($scan_id, 'pc_3dscan_email', $email);

				if(empty($twitterError)){
					update_post_meta($scan_id, 'pc_3dscan_twitter', $twitter);
				}

				$subject = $name . " thanks for Signing up for a 3D Scan";
				$body = "Name: $fname \n\nEmail: $email";
				$headers = 'From: My 3D Scan <info@my3dscan.ca>' . "\r\n" . 'Reply-To: info@my3dscan.ca';
				$emailSent = wp_mail($email, $subject, $body, $headers);
			} else {
				$emailSent = false;
				$scan_create = false;
			}
		}

	}

	function validate_twitterHandle($handle) {
		if (preg_match('/^(@?)[A-Za-z0-9_]{1,15}$/', $handle)){
			if(substr($handle, 0, 1) == '@'){
				return substr($handle, 1);
			} else {
				return $handle;
			}
		} else {
			return false;
		}
	}

?>

<?php	get_header(); ?>

	<section id="contact">
		<header class="title">
			<h1>Sign up and get 3D scanned!</h1>
		</header>
		<div id="quotables">
		</div>
		<div class="wrap">
			<div class="layout clearfix">
				<aside>
					<p>Fill out this info so we can let you know when your 3D file is ready and to get cool 3D printed Swag! We don't use this for anythign else.</p>
					<p class="info">@DraftPrint3D</p>
					<p class="info">@PeopleAndCode</p>
				</aside>
				<div id="connect">
					<?php 
						if(isset($emailSent) && $emailSent == true) { ?>
						<div class="thanks">
							<h2>Thanks!</h2>
							<p>Your info was sent! Now swing by our Exhibit in the Microsoft Developer Lounge and get a 3D Scan done!</p>
						</div>
					<?php 
						} else if (isset($emailSent) && $emailSent == false) { 
								if ($scan_create == false){
					?>
						<h2>Wordpress Error.</h2>
						<?php
								} else {
						?>
								<h2><img src="<?php bloginfo('template_url'); ?>/images/vw_logo.png">We're Sorry...</h2>
								<p class="error">We're sorry - your sign-up form couldn't be sent.  Swing by our exhibit anyways and we can still scan you!<p>
						<?php
								}
							?>
					<?php 
					} else { ?>
						<?php if(isset($hasError)) { ?>
						<p class="error">Sorry, an monsterous error occured somewhere...we don't know what it is.<p>
						<?php } ?>
					<hgroup>
						<h2>3D Scanning Sign-up form</h2>
					</hgroup>
						<form action="<?php the_permalink(); ?>" id="contactForm" class="form-stacked" method="post">
							<div class="row">
								<div class="input span1">
									<label>First Name <span class="red">*
									<?php if($fnameError != '') { ?>
										<?=$nameError;?>
									<?php } ?>
									</span></label>
									<div class="input-wrap"><input class="span4" name ="fname" type="text" value="<?php (empty($fname)) ? '' : $fname; ?>"></div>
								</div>
								<div class="input span1">
									<label>Email <span class="red">*
									<?php if($emailError != '') { ?>
										<?=$emailError;?>
									<?php } ?>
									</span></label>
									<div class="input-wrap"><input class="span4" name ="email" type="text" value="<?php (empty($email)) ? '' : $email; ?>"></div>
								</div>
								<div class="input span1">
									<label>Twitter <span class="red">*
									<?php if($twitterError != '') { ?>
										<?=$twitterError;?>
									<?php } ?>
									</span></label>
									<div class="input-wrap"><input class="span4" name ="twitter" type="text" value="<?php (empty($twitter)) ? '' : $twitter; ?>"></div>
								</div>
							</div>
							<div class="row">
								<div class="action">
									<button type="submit" class="btn btn-primary">Sign up!</button>
									<input type="hidden" name="submitted" id="submitted" value="true" />
								</div>
							</div>
						</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>