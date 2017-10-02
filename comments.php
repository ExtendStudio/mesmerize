<?php
if (post_password_required()):
	return;
endif;
?>

<div class="post-comments">
	<?php if (have_comments()): ?>
    <h2 id="comments">
    	<span class="comments-number">
				<?php comments_number(__( 'No Responses', 'mesmerize' ), __( 'One Response', 'mesmerize' ), __( '% Responses', 'mesmerize' )); ?>
    	</span>
    </h2>

  	<ol class="commentlist">
      <?php 
      		wp_list_comments( array(
			        'avatar_size' => '32'
			    ));
      ?>
  	</ol>

  	<?php 
  		if (get_comment_pages_count() > 1 && get_option('page_comments')):
  	?>
    	<div class="navigation">
    		<div class="prev-posts">
    			<?php previous_comments_link(__('&lt; Older Comments', 'mesmerize')); ?>
    		</div>
    		<div class="next-posts">
    			<?php next_comments_link(__('Newer Comments &gt;', 'mesmerize')); ?>
    		</div>
    	</div>
  	<?php
  		endif;
  	?>
  <?php endif; ?>
 
  <?php
 		if (!comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' )):
	?>
			<p class="no-comments"><?php _e('Comments are closed.', 'mesmerize' ); ?></p>
 	<?php 
    endif; 
  ?>

  <div class="comments-form">
    <div class="comment-form">
     	<?php comment_form(
				array(
					'class_submit'=>'button blue'
				)
			);
		?>
    </div>
  </div>
</div>