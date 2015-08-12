<?php
class EasyTreeCategoryWalker extends Walker_Category {
	
	protected $displayed_posts = array();
	
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
			'category' 	=> $page->cat_ID,
            'post_status'   => $post_status,
		));
		
		$is_single = is_single();
		
		$html = '';
		if($posts) {
			$html = '<ul>';
			foreach($posts as $p) {
				if( !in_array($p->ID, $this->displayed_posts) ) {
					$html .= '<li class="post_item post-item-'.$p->ID.' '.($is_single && $p->ID==$post->ID?'current_post_item':'').' post-status-'.get_post_status($p->ID).'"><a href="'.get_permalink( $p->ID ).'">'.$p->post_title.'</a></li>';
					$this->displayed_posts[] = $p->ID;
				}
			}
			$html .= '</ul>';
		}
		$output .= $html;
	}
}
