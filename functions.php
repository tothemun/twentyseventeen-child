 <?php
 add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
 function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
 }

add_post_type_support( 'page', 'excerpt' );

function filter_ptags($content){
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<script.*>*.<\/script>)\s*<\/p>/iU', '\1', $content);
  $content = preg_replace_callback('/<p>\s*(<iframe.*>*.<\/iframe>)\s*<\/p>/iU', function($matches) {
        return '<div class="embedContainer">' . $matches[0] . '</div>';
  }, $content);
	
  return $content;
}

add_filter('the_content', 'filter_ptags');

function signup_newsletter( $data ) {
  return 'hello';
}

add_action('rest_api_init', function() {
  register_rest_route('mailchimp/v1', '/signup', array(
    'methods' => 'POST',
    'callback' => 'signup_newsletter',
  ));
});
