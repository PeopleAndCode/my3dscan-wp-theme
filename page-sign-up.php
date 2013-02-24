<?php	get_header(); ?>

	<section id="contact">
		<header class="title">
			<h1>Sign up and get 3D scanned!</h1>
		</header>
		<div class="wrap">
			<div class="layout clearfix">
				<aside>
					<p>Fill out this info so we can let you know when your 3D file is ready and to get cool 3D printed Swag! We don't use this for anythign else.</p>
					<p class="info">@DraftPrint3D</p>
					<p class="info">@PeopleAndCode</p>
				</aside>
				<div id="connect">
					<hgroup>
						<h2>3D Scanning Sign-up form</h2>
					</hgroup>
					<form id="contactForm" class="form-stacked" action="" method="post">
						<div class="row">
							<div class="input span1">
								<label>Name<span class="red">*</span></label>
				                <span class="nameError error">Please enter your name.</span>
								<div class="input-wrap"><input id="fname" name="fname" value="" type="text"></div>
							</div>
							<div class="input span1">
								<label>Email<span class="red">*</span></label>
				                <span class="emailError error">Please enter your email.</span>
								<div class="input-wrap"><input id="femail" name="femail" value="" type="text"></div>
							</div>
							<div class="input span1 last">
								<label>Twitter<span class="red">*</span></label>
				                <span class="phoneError error">Please enter your twitter handle.</span>
								<div class="input-wrap"><input id="ftwitter" name="ftwitter" value="" type="text"></div>
							</div>
						</div>
						<div class="row">
							<div class="action">
								<div class="required"><span class="red">*</span> Required</div>
								<button id="fsend" class="btn btn-primary">Send</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>