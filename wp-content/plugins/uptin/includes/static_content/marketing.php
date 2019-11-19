<?php
function rad_marketing_page(){
	$imageurl = RAD_PLUGIN_IMAGE_DIR;

	$html = <<<BOH
	<div class="marketing_header" style="text-align: center;">
		<!-- <h1>Need More Help Building Out Your Email List?</h1>
		<p>We have the resources to get the most out of your marketing efforts.</p>-->
		<h1>Quick, Easy and Free way to build your Email List</h1>
		<h2>No Design or Coding Skills needed</h2>
		<p style="margin: 20px; color: #373942;">Uptin enables you quickly create and deploy stunning Email Optin Forms, Popups and Widgets.</p>
		<div style="margin: 20px auto; border: 0px; color: #373942; width: 55%; text-align: left;">
			<h2>Key Features</h2>
			<ul style="list-style: disc; margin-left: 20px;">
				<li>100% Free Plugin - get started within minutes</li>
				<li>Create 6 type of Email Optin and List Builders including Slide In, Popup , Widget, In-line Content, Protected Content and below content.</li>
				<li>Monitor conversion and performance statistics of each list builder.</li>
				<li>Create and Manage A/B Tests.</li>
				<li>Connect with all email autoresponders / email service providers</li>
				<li>100’s of Free and Fully Customizable Templates.</li>
				<li>Optin Forms and List Builders optimized for all devices.</li>
			</ul>
			
		</div>
		<div class="rad_dashboard_new_optin">
			<button class="rad_dashboard_icon" style="padding: 15px 20px !important;">new optin</button>
			<input type="hidden" name="action" value="new_optin">
		</div
		<p></p>
		<p style="color: #373942;">Or <a href="http://support.getuptin.com/" target="_target">see instructions first</a></p>
	</div>
	<div class="marketing_wrapper" >
	<div class="uptin_marketing_main" >

		<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/9d8wWcJLnFI" frameborder="0" allowfullscreen></iframe>-->
	<!--
			<div id="video_course">
				<div class="box_header">
					<p>Download Our Free 9-Video Course</p>
				</div>
				<div class="uptin_marketing_content">
					<img src="$imageurl/email-list-building-course.png" name="9_video_course" />
					<div>
						<p>The Ultimate Business Owner’s Guide to List-Building</p>
						<a href = "https://lp.leadpages.net/email-list-building-uptin/" target="_blank">Download</a>
					</div>
				</div>
			</div>

			<div id="live_training">
				<div class="box_header">
					<p>Check Out Our Free Live Training</p>
				</div>
				<div class="uptin_marketing_content">
					<img src="$imageurl/free-live-training.png" name="live-training" />
					<div>
						<p>How to Grow Your List Without Spending All Your Time On Marketing</p>
						<a href = "https://lp.leadpages.net/webinar-uptin/" target="_blank">Download</a>
					</div>
				</div>
			</div>

			<div id="free_images">
				<div class="box_header">
					<p>Download 10 Free Images Designed to Convert</p>
				</div>
				<div class="uptin_marketing_content">
					<img src="$imageurl/10-free-images.png" name="free_images" />
					<div>
						<p>Grow Your List Faster By Testing These 10 Images On Your Popups</p>
						<a href = "https://lp.leadpages.net/10-images-uptin/" target="_blank">Download</a>
					</div>
				</div>
			</div>

			<div id="facebook_course">
				<div class="box_header">
					<p>See Our Free 11-Video Facebook Course</p>
				</div>
				<div class="uptin_marketing_content">
					<img src="$imageurl/facebook-ad-course.png" name="facebook_course" />
					<div>
						<p>Use Facebook to Grow Your List with the Facebook Advertising System</p>
						<a href = "https://lp.leadpages.net/facebook-advertising-uptin/" target="_blank">Download</a>
					</div>
				</div>
			</div>
			-->
	</div>
BOH;

	/* added by mark ramos, to remove the content on Tools &  Resources */

// 	$html = <<<BOH
// 	<div class="marketing_header">
// 		<h1>Need More Help Building Out Your Email List?</h1>
// 		<p>We have the resources to get the most out of your marketing efforts.</p>
// 	</div>
// 	<div class="marketing_wrapper">
// 		<div class="uptin_marketing_main">
// 			<div style="width: 100%; height: 10px;"></div>
// 		</div>
// 	</div>

// BOH;

	return $html; 
}

include_once('marketing_sidebar.php');

$main = rad_marketing_page();
$sidebar = uptin_marketing_sidebar();
echo $main;
echo $sidebar;