<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php get_header(); ?>
<?php if (get_option('blog_public') == '1' || (get_option('blog_public') == '0' && current_user_can_for_blog($blog_id, 'read'))): ?>

				<?php edit_post_link( __( 'Edit', 'pressbooks' ), '<span class="edit-link">', '</span>' ); ?>
			<h2 class="entry-title"><?php
				if ( $chapter_number = pb_get_chapter_number( $post->post_name ) ) echo "<span>$chapter_number</span>  ";
				the_title();
				?></h2>
					<?php pb_get_links(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( pb_get_section_type( $post ) ); ?>>
					
					<div class="entry-content">
					  <?php if ($subtitle = get_post_meta($post->ID, 'pb_subtitle', true)): ?>
					    <h2 class="chapter_subtitle"><?php echo $subtitle; ?></h2> 
				    <?php endif;?>
				    <?php if ($chap_author = get_post_meta($post->ID, 'pb_section_author', true)): ?>
				       <h2 class="chapter_author"><?php echo $chap_author; ?></h2>
			      <?php endif; ?>
									
					<?php if ( get_post_type( $post->ID ) !== 'part' ) {
						$content = apply_filters ( 'the_content', get_the_content() );
						$s = 1;
						while ( strpos( $content, '<h1>' ) !== false ) {
						    $content = preg_replace('/<h1>/', '<h1 id="section-' . $s++ . '">', $content, 1);
						}
						echo $content;
					} else {
						echo apply_filters( 'the_content', get_post_meta( $post->ID, 'pb_part_content', true ) );
			} ?>

					</div><!-- .entry-content -->
				</div><!-- #post-## -->

			
				</div><!-- #content -->
			
				<?php 
				$chapter_buttons = get_option( 'pressbooks_theme_options_web' );
				if ( 1 === $chapter_buttons['social_media'] || ! isset( $chapter_buttons['social_media'] ) ) {
					get_template_part( 'content', 'social-footer' ); 
				}
				?> 
			
				<?php comments_template( '', true ); ?>
<?php else: ?>
<?php pb_private(); ?>
<?php endif; ?>
<?php get_footer(); ?>
<?php endwhile;?>
