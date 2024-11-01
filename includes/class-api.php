<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WP2GPT_API {
    /**
     * Register the hooks.
     */
    public static function register() {
        add_action('rest_api_init', array('WP2GPT_API', 'register_rest_routes'));
    }

    /**
     * Register REST API routes.
     */
    public static function register_rest_routes() {
        register_rest_route('wp2gpt/v1', '/posts', array(
            'methods' => 'GET',
            'callback' => array('WP2GPT_API', 'handle_endpoint'),
            'permission_callback' => '__return_true'
        ));
    }

    /**
     * Handle the endpoint for getting posts.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public static function handle_endpoint(WP_REST_Request $request) {

        // Get parameters
        $id = absint($request->get_param('id'));
        $slug_param = $request->get_param('slug');
        $slug = $slug_param !== null ? sanitize_title($slug_param) : '';
        $search = sanitize_text_field($request->get_param('search'));
        $per_page = absint($request->get_param('per_page'));
        $page = absint($request->get_param('page'));

        // Default fields.
        $fields = 'id,title,slug,date,link';

        if (!empty($slug) || !empty($id) || $per_page == 1) {
            // Fetching a single full post.
            $fields .= ',content';
        } else {
            // Fetching multiple posts with excerpts.
            $fields .= ',excerpt';
        }

        // Get the current site's URL.
        $site_url = get_site_url();

        // URL request to the WordPress REST API
        $url = $site_url . '/wp-json/wp/v2/posts?_fields=' . $fields;

        // Define parameters.
        $params = [
            'include' => $id,
            'slug' => $slug,
            'search' => urlencode($search),
            'page' => $page,
            'per_page' => $per_page ? $per_page : 10
        ];

        // Append parameters to URL.
        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $url .= '&' . $key . '=' . $value;
            }
        }

        // Get response.
        $response = wp_remote_get($url);

        // Handle error.
        if (is_wp_error($response)) {
            return new WP_Error('api_request_failed', 'API request failed', array('status' => 500));
        }

        // JSON decode the response.
        $posts = json_decode(wp_remote_retrieve_body($response), true);

        // Filter content if a single post is fetched.
        if (!empty($slug) || !empty($id) || $per_page == 1) {
            if (!empty($posts)) {
                $posts[0]['content'] = self::filter_content($posts[0]['content']['rendered']);
            }
        }

        // Return the data.
        return new WP_REST_Response($posts, 200);
    }

    /**
     * Filter and remove attributes to shorten content.
     * @param string $content The content to filter.
     * @return string
     */
    public static function filter_content($content) {

        // Temporarily replace <script> tags inside <code> with placeholders.
        $content = preg_replace_callback(
            '/<code>.*?<\/code>/is',
            function ($matches) {
                return str_replace(['<script>', '</script>'], ['[SCRIPT_START]', '[SCRIPT_END]'], $matches[0]);
            },
            $content
        );

        // Remove attributes.
        $content = preg_replace('/\s(?:style|class|id|onclick|onerror|onload)="[^"]*"/i', '', $content);

        // Remove all <script> tags.
        $content = preg_replace('/<script\b[^>]*>(?:.*?)<\/script>/is', '', $content);

        // Restore <script> tags inside <code>.
        $content = str_replace(['[SCRIPT_START]', '[SCRIPT_END]'], ['<script>', '</script>'], $content);

        return $content;
    }
}

WP2GPT_API::register();
