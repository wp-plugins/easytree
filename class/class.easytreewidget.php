<?php
class EasyTreeWidget extends WP_Widget {
    
    function EasyTreeWidget() {
        parent::WP_Widget( false, 'EasyTree' );
    }
    
    function widget($args, $instance) {
        echo $args['before_widget'];
            echo $args['before_title'];
            echo $instance['title'];
            echo $args['after_title'];
            echo get_easytree_html();
        echo $args['after_widget'];
    }
    
    function update($new_instance, $old_instance) {
        $new_instance['title'] = htmlspecialchars($new_instance['title']);
        return $new_instance;
    }
    
    function form( $instance ) {
        $title = htmlspecialchars( $instance['title'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e( 'Title:' ); ?>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
            </label>
        </p>
        <?php
    }
    
}
function easytree_widget_init() {
    register_widget('EasyTreeWidget');
}
add_action( 'widgets_init', 'easytree_widget_init' );
