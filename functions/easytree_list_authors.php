<?php
function easytree_list_authors( $args=array() ) {
	global $post;
	
	$authors = get_users($args);
	
	$post_status = 'publish';
	if(current_user_can('read_private_posts')) {
		$post_status .= ',private';
	}
	
	$posts = get_posts(array(
		'posts_per_page'=> -1,
		'orderby' 	=> 'title',
		'order' 	=> 'ASC',
        'post_status'   => $post_status,
	));

	$is_single = is_single();
	
	foreach( $authors as $author ) {
		echo '<li class="cat-item '.(is_author($author->ID)?'current-cat':'').'">';
		echo '<a href="' . get_author_posts_url( $author->ID ) . '">' . $author->display_name . '</a>';
		
		$posts_html = '';
		$display_posts = false;
		foreach($posts as $p) {
			if($p->post_author == $author->ID) {
				$posts_html .= '<li class="post_item post-item-'.$p->ID.' '.($is_single && $p->ID==$post->ID?'current_post_item':'').' post-status-'.get_post_status($p->ID).'"><a href="'.get_permalink( $p->ID ).'" rel="noindex,nofollow">' . $p->post_title . '</a></li>';
				$display_posts = true;
			}
		}
		if($display_posts) {
			echo '<ul>';
			echo $posts_html;
			echo '</ul>';
		}
		
		echo '</li>';
	}
}
