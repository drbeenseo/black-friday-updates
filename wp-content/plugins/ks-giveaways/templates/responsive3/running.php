<div class="row text-center">
  <div class="small-12 columns">
    <h4 class="timer">
      <div id="countdown" data-until="<?php echo ks_giveaways_get_date_end() ?>"></div>
    </h4>
  </div>
</div>

<?php if (ks_giveaways_has_contestant()): ?>
  <script type="text/javascript">
    var ks_giveaways_globals = {};
    ks_giveaways_globals.ajax_url = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
    ks_giveaways_globals.contestant_id = <?php echo ks_giveaways_get_contestant_id(); ?>;
    ks_giveaways_globals.giveaway_id = <?php echo ks_giveaways_get_giveaway_id(); ?>;
  </script>
<div class="row text-center">
  <div class="small-12 columns">
    <br>
    <h4><?php _e('You have'); ?> 
      <strong id="total-entries"><?php echo ks_giveaways_get_my_entries() ?>
      <?php if (ks_giveaways_is_confirmed_contestant()): ?><?php _e('confirmed', KS_GIVEAWAYS_TEXT_DOMAIN); ?> <?php endif ?>
      <?php if (ks_giveaways_get_my_entries() > 1 || !ks_giveaways_get_my_entries()): ?><?php echo _e('entries', KS_GIVEAWAYS_TEXT_DOMAIN); ?><?php else: ?><?php _e('entry', KS_GIVEAWAYS_TEXT_DOMAIN); ?><?php endif ?>
      </strong>
    </h4>
    <?php if (ks_giveaways_contestant_needs_confirmation()): ?>
      <p>
        <?php _e('Your number of contest entries will display once you have confirmed your email address. Please check your inbox to confirm now.', KS_GIVEAWAYS_TEXT_DOMAIN); ?>
      </p>
    <?php endif ?>
  </div>
</div>
<?php if (ks_giveaways_show_youtube_section()): ?>
  <div class="row text-center" id="youtube-subscribe-section">
    <div class="small-12 columns">
      <h5>Get <strong><?php echo ks_giveaways_get_entries_per_youtube_subscribe() ?> more <?php if (ks_giveaways_get_entries_per_youtube_subscribe() > 1): ?>entries<?php else: ?>entry<?php endif ?></strong> for subscribing to our<br />YouTube channel!</h5>
        <a class="youtube-subscribe-link" data-original-url="<?php echo ks_giveaways_get_youtube_channel_url(); ?>" href="<?php echo add_query_arg('sub_confirmation', 1, ks_giveaways_get_youtube_channel_url()); ?>" target="_blank"><?php _e('Subscribe', KS_GIVEAWAYS_TEXT_DOMAIN); ?></a>
    </div>
  </div>
<?php endif; ?>

<div class="row text-center">
  <div class="small-12 columns">
    <h5>Get <strong><?php echo ks_giveaways_get_entries_per_friend() ?> more <?php if (ks_giveaways_get_entries_per_friend() > 1): ?>entries<?php else: ?>entry<?php endif ?></strong> for every friend you refer</h5>
  </div>
</div>

<div class="row text-left sharing">
  <div class="medium-6 small-12 columns">
    <span class="step">1</span> <a class="share-fb" title="Share it on Facebook" href="javascript:void(0)" onclick="ks_giveaways_fb('<?php echo esc_js(ks_giveaways_get_lucky_url()) ?>', '<?php echo esc_js(ks_giveaways_get_share_message()) ?>')">Facebook</a>
  </div>
  <div class="medium-6 small-12 columns">
    <span class="step">2</span> <a class="share-tw" title="Tweet it on Twitter" href="javascript:void(0)" onclick="ks_giveaways_tw('<?php echo esc_js(ks_giveaways_get_lucky_url()) ?>', '<?php echo esc_js(ks_giveaways_get_share_message()) ?>', '<?php echo esc_js(get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA)) ?>')">Twitter</a>
  </div>
  <div class="medium-6 small-12 columns">
    <span class="step">3</span> <a class="share-li" title="Share it on LinkedIn" href="javascript:void(0)" onclick="ks_giveaways_li('<?php echo esc_js(ks_giveaways_get_lucky_url()) ?>', '<?php echo esc_js(ks_giveaways_get_share_message()) ?>')">LinkedIn</a>
  </div>
  <div class="medium-6 small-12 columns">
    <span class="step">4</span> <a class="share-pi" title="Share it on Pinterest" href="javascript:void(0)" onclick="ks_giveaways_pi('<?php echo esc_js(ks_giveaways_get_lucky_url()) ?>', '<?php echo esc_js(ks_giveaways_get_share_message()) ?>', '<?php echo esc_js(ks_giveaways_get_prize_image_url()) ?>')">Pinterest</a>
  </div>
</div>
<div class="row text-left sharing">
  <div class="medium-6 small-12 columns">
    <span class="step">5</span> Share Lucky URL
  </div>
  <div class="medium-6 small-12 columns">
    <input type="text" value="<?php echo esc_attr(ks_giveaways_get_lucky_url()) ?>" onclick="this.select();" />
  </div>
</div>
<div class="row text-left sharing">
  <?php if (get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA)): ?>
  <div class="medium-6 small-12 columns">
    <span class="step">6</span>
    <a href="https://twitter.com/<?php echo esc_attr(get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA)) ?>" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @<?php echo get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA) ?></a>
  </div>
  <?php endif ?>
  <?php if (get_option(KS_GIVEAWAYS_OPTION_FACEBOOK_PAGE)): ?>
  <div class="medium-6 small-12 columns">
    <span class="step">7</span>
    <div class="fb-like" data-href="<?php echo esc_attr(get_option(KS_GIVEAWAYS_OPTION_FACEBOOK_PAGE)) ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="90"></div>
  </div>
  <?php endif ?>
</div>
<?php /*
<hr />
<h4>Earn additional entries for following us!</h4>
<div class="row text-left sharing">
  <?php if (ks_giveaways_show_youtube_section()): ?>
  <div class="medium-12 small-12 columns youtube-subscribe-section">
    <span class="step">&nbsp;</span>
    <a class="youtube-subscribe-link sm" data-original-url="<?php echo ks_giveaways_get_youtube_channel_url(); ?>" href="<?php echo add_query_arg('sub_confirmation', 1, ks_giveaways_get_youtube_channel_url()); ?>" target="_blank"><?php _e('Subscribe', KS_GIVEAWAYS_TEXT_DOMAIN); ?></a> - <?php printf(__("Subscribe for <strong>%s</strong> more %s!", KS_GIVEAWAYS_TEXT_DOMAIN), ks_giveaways_get_entries_per_youtube_subscribe(), (ks_giveaways_get_entries_per_youtube_subscribe() == 1 ? __('entry') : __('entries'))) ?>
  </div>
  <?php endif ?>
  <?php if (ks_givewaways_show_twitter_follow()): ?>
  <div class="medium-12 small-12 columns twitter-follow-section">
    <span class="step">&nbsp;</span>
    <a href="https://twitter.com/<?php echo esc_attr(get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA)) ?>" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false" data-size="large">Follow @<?php echo get_option(KS_GIVEAWAYS_OPTION_TWITTER_VIA) ?></a> - <?php printf(__("Follow us for <strong>%s</strong> more %s!", KS_GIVEAWAYS_TEXT_DOMAIN), ks_giveaways_get_entries_per_twitter_follow(), (ks_giveaways_get_entries_per_twitter_follow() == 1 ? __('entry') : __('entries'))) ?>
  </div>
  <?php endif ?>
  <?php if (ks_giveaways_show_facebook_like()): ?>
  <div class="medium-12 small-12 columns facebook-like-section">
    <span class="step">&nbsp;</span>
    <div class="fb-like" data-href="<?php echo esc_attr(get_option(KS_GIVEAWAYS_OPTION_FACEBOOK_PAGE)) ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="90" data-size="large"></div>
    - <?php printf(__("Like our page for <strong>%s</strong> more %s!", KS_GIVEAWAYS_TEXT_DOMAIN), ks_giveaways_get_entries_per_facebook_like(), (ks_giveaways_get_entries_per_facebook_like() == 1 ? __('entry') : __('entries'))) ?>
  </div>
  <?php endif ?>
</div>
*/ ?>

<?php else: ?>

<div class="row text-left">
  <div class="small-12 columns">
    <?php echo ks_giveaways_get_description() ?>
  </div>
</div>
<!-- Contest Question -->
<div class="row text-center contest-question">
  <div class="small-12 columns">
    <h4><span class="step">1</span> <?php _e('Answer correctly to qualify', KS_GIVEAWAYS_TEXT_DOMAIN); ?></h4>
  </div>
  <div class="small-1 columns">&nbsp;</div>
  <div class="small-10 columns">
    <?php echo ks_giveaways_question() ?>
    <small class="error" style="display:none;"><?php _e('Incorrect answer, try again!', KS_GIVEAWAYS_TEXT_DOMAIN); ?></small>
  </div>
  <div class="small-1 columns">&nbsp;</div>
</div>
<!-- End Contest Question -->

<!-- Contest Entry -->
<div class="row text-center contest-entry">
  <div class="small-12 columns">
    <h4><span class="step">2</span> Enter your
      <?php if(get_option(KS_GIVEAWAYS_OPTION_GIVEAWAYS_ASK_NAME)): ?>
        details
      <?php else: ?>
        <?php _e('email address', KS_GIVEAWAYS_TEXT_DOMAIN); ?>
      <?php endif; ?>
    </h4>
  </div>
  <div class="small-12 columns">
    <form id="giveaways_form" action="" method="post" data-abide>
      <?php wp_nonce_field('ks_giveaways_form', 'giveaways_nonce') ?>
      <?php if (isset($_REQUEST['lucky'])): ?>
      <input type="hidden" name="lucky" value="<?php echo $_REQUEST['lucky'] ?>" />
      <?php endif ?>
      <?php if(get_option(KS_GIVEAWAYS_OPTION_GIVEAWAYS_ASK_NAME)): ?>
        <input type="hidden" name="first_name_field_active" id="first_name_field_active" value="true" />
      <?php else: ?>
        <input type="hidden" name="first_name_field_active" id="first_name_field_active" value="false" />
      <?php endif; ?>
      <div class="row collapse" id="giveaways_first_name_container">
        <div class="small-1 columns">&nbsp;</div>
        <div class="small-3 columns">
          <label class="prefix" for="giveaways_first_name"><?php _e('First Name', KS_GIVEAWAYS_TEXT_DOMAIN); ?></label>
        </div>
        <div class="small-7 columns">
          <input type="text" required name="giveaways_first_name" id="giveaways_first_name" value="<?php echo esc_attr(ks_giveaways_cookie_first_name()) ?>" />
          <small class="error"><?php _e('Please enter your first name', KS_GIVEAWAYS_TEXT_DOMAIN); ?>.</small>
        </div>
        <div class="small-1 columns">&nbsp;</div>
      </div>
      <div class="row collapse">
        <div class="small-1 columns">&nbsp;</div>
        <div class="small-3 columns">
          <label class="prefix" for="giveaways_email"><?php _e('Email', KS_GIVEAWAYS_TEXT_DOMAIN); ?></label>
        </div>
        <div class="small-7 columns">
          <input type="email" required name="giveaways_email" id="giveaways_email" value="<?php echo esc_attr(ks_giveaways_cookie_email()) ?>" />
          <small class="error"><?php _e('An email address is required', KS_GIVEAWAYS_TEXT_DOMAIN); ?>.</small>
        </div>
        <div class="small-1 columns">&nbsp;</div>
      </div>
      <div class="row">
        <div class="small-12 columns text-center">
          <div id="giveaways_email_hint" style="display:none"><p><?php _e('Did you mean', KS_GIVEAWAYS_TEXT_DOMAIN); ?> <a href="javascript:void(0)"></a>?</p></div>
        </div>
      </div>
      <?php if (get_option(KS_GIVEAWAYS_OPTION_CAPTCHA_SITE_KEY)): ?>
      <div class="row collapse">
        <div class="small-1 columns">&nbsp;</div>
        <div class="small-10 columns text-center">
          <div class="g-recaptcha" data-sitekey="<?php echo get_option(KS_GIVEAWAYS_OPTION_CAPTCHA_SITE_KEY) ?>"></div>
        </div>
        <div class="small-1 columns">&nbsp;</div>
      </div>
      <?php endif ?>
      <div class="row">
        <div class="small-12 columns text-center">
          <button type="submit" class="button large radius"><?php _e('Enter', KS_GIVEAWAYS_TEXT_DOMAIN); ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End Contest Entry -->

<?php endif ?>
