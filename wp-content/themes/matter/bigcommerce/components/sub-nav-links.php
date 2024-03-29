<?php

/**
 * Template for rendering sub-navigation links
 *
 * @var array[] $links An array of associative arrays of links with 'url', 'label', and 'current' keys
 */

?>
<aside class="bc-subnav account-bar">
	<ul class="bc-subnav__list">
		<?php foreach ( $links as $link ) { ?>
			<li class="bc-subnav__list-item <?php echo esc_attr( $link[ 'current' ] ? 'bc-subnav__list-item--current' : '' ); ?>">
				<a class="bc-link bc-subnav__link" href="<?php echo esc_url( $link[ 'url' ] ); ?>" title="<?php echo esc_attr( $link[ 'label' ] ); ?>"><?php echo esc_html( $link[ 'label' ] ); ?></a>
			</li>
		<?php } ?>
	</ul>
	<div class="logout">
		<a class="btn btn-checkout" href="<?php echo wp_logout_url(); ?>">LOG OUT</a>
	</div>
</aside>
