<?php


if ( ! apply_filters('ope_show_post_meta',true)) {
    return;
}

?>


<!-- <div class="post-header single-post-header"> -->
<div class="post-meta small muted">
  
  <!-- <i class="font-icon-post fa fa-user"></i> -->
  by <?php echo the_author_posts_link(); ?>

  <!-- <i class="font-icon-post fa fa-folder-o"></i> -->
  on <?php the_category(' ', ' ');?>

  <!-- <i class="font-icon-post fa fa-calendar"></i> -->
  - <span class="post-date"><?php echo the_time(get_option('date_format')); ?></span>
  
  
  &nbsp;|&nbsp;<i class="font-icon-post fa fa-comment-o"></i>
  <span><?php echo get_comments_number(); ?></span>
</div>