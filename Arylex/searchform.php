<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
   <input type="search" name="s" class="search-field" placeholder="<?php echo _x( 'Search', 'placeholder', 'arylex'); ?>" title="<?php echo _x( 'Search for:', 'label', 'arylex' ); ?>">
   <button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'arylex'); ?></span></button>
</form>
