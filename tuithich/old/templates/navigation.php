<?php
    $ppost = get_previous_post();
    $npost = get_next_post();
?>

<?php if( !empty( $npost ) || !empty( $ppost ) ) : ?>

    <?php /* post navigation */ ?>

	<div class="nav_post">
		<div>
		<?php
			if( !empty( $ppost ) ){
				echo '<a class="prev" href="' . get_permalink( $ppost -> ID ) . '">' . $ppost -> post_title . '</a>';
			}

			if( !empty( $npost ) ){
				echo '<a class="next" href="' . get_permalink( $npost -> ID ) . '">' . $npost -> post_title . '</a>';
			}
		?>
		</div>
	</div>
    
<?php endif; ?>