<?php
function uptin_marketing_sidebar($remove = false){
	$imageurl = RAD_PLUGIN_IMAGE_DIR;


	if($remove === true){
		$class = ' non_marketing_page';
	}else{
		$class ='';
	}

	$html = <<<boh
	<!--
<div class="uptin_marketing_sidebar$class">
		<div class="signup">
			<p class="header">DON'T MISS OUT</p>
			<p class="signup_tagline">Subscribe and receive regular updates on new releases, upgrades, fixes, list-building tips and more!</p>
			<div id="signup_container">
				<div class="uptin_newsletter_form">
				<p class="error badresponse">Something went wrong please try again later</p>
				<p class='error email'>The email you entered appears to be invalid</p>
				<input type="text" name="email" class="newsletter_email" placeholder="   Enter your email..."/><br>
				<a class="newsletter_submit_button">Subscribe</a><span class="loader"><img src="$imageurl/ajax-loader.gif"/></span>
				</div>
				<div class="signup_thankyou">
					<p>You Signed up for our amazing plugin updates. Thank you!</p>
				</div>
			</div>
			<a class="privacy_link" href="https://www.uptin.com/privacy" target="_blank">Privacy</a>
		</div>


		<div class="quick_links">
			<p class="header">Quick Links</p>
			<ul>
				<li class="quick_link"><a href="https://www.uptin.com" target="_blank">Uptin Home</a></li>
				<li class="quick_link"><a href="https://www.uptin.com/support" target="_blank">Support</a></li>
				<li class="quick_link"><a href="https://www.uptin.com/docs" target="_blank">Documentation</a></li>
				<li class="quick_link"><a href="http://blog.uptin.com" target="_blank">Uptin Blog</a></li>
				<li class="quick_link"><a href="https://github.com/LeadPages/uptin-plugin" target="_blank">Github Repo</a></li>
				<li class="quick_link"><a href="https://www.uptin.com/tou" target="_blank">Terms of Use</a></li>
			</ul>
		</div>
	</div>
	-->
</div>
boh;

	return $html;
}
