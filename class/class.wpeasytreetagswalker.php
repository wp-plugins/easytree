<?php
class EasyTreeTagsWalker extends Walker_Category {
	
	// w tagach nie sprawdzam czy wpis sie powtarza i nie rozwijam ich automatycznie
	
	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		global $post;
		
		$post_status = 'publish';
		if(current_user_can('read_private_posts')) {
			$post_status .= ',private';
		}

		$posts = get_posts(array(
			'posts_per_page'=> -1,
			'orderby' 	=> 'title',
			'order' 	=> 'ASC',
			'tax_query' 	=> array(
				array(
					'taxonomy' 	=> 'post_tag',
					'field' 	=> 'id',
					'terms' 	=> $page->term_taxonomy_id,
				),
			),
            'post_status'   => $post_status,
		));
		
		$is_single = is_single();
		
		$html = '';
		if($posts) {
			$html = '<ul>';
			foreach($posts as $p) {
				$html .= '<li class="post_item post-item-'.$p->ID.' '.($is_single && $p->ID==$post->ID?'current_post_item':'').' post-status-'.get_post_status($p->ID).'"><a href="'.get_permalink( $p->ID ).'" rel="noindex,nofollow">'.$p->post_title.'</a></li>';
			}
			$html .= '</ul>';
		}
		$output .= $html;
	}
}
