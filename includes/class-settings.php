<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WP2GPT_Settings {
    /**
     * Register the hooks.
     */
    public static function register() {
        add_action('admin_menu', array('WP2GPT_Settings', 'add_admin_menu'));
    }

    /**
     * Add submenu item to the WordPress admin menu.
     */
    public static function add_admin_menu() {
        add_submenu_page(
            'options-general.php',
            'Sync to GPT',
            'Sync to GPT',
            'manage_options',
            'wp2gpt_settings',
            array('WP2GPT_Settings', 'settings_page')
        );
    }

    /**
     * Display the settings page.
     */
    public static function settings_page() {
      $site_url = get_site_url();

      $openapi_schema = 'openapi: 3.1.0
info:
  title: WordPress ChatGPT Integration API
  version: 1.0.0
servers:
  - url: ' . $site_url . '
paths:
  /wp-json/wp2gpt/v1/posts:
    get:
      operationId: getPosts
      parameters:
        - name: id
          in: query
          description: The ID of a specific post to fetch.
          required: false
          schema:
            type: integer
            format: int64
        - name: slug
          in: query
          description: The slug of a specific post to fetch.
          example: \'my-awesome-post\'
          required: false
          schema:
            type: string
        - name: search
          in: query
          description: The search term to match posts by.
          required: false
          schema:
            type: string
        - name: per_page
          in: query
          description: The number of posts to return per page.
          required: true
          schema:
            type: integer
            format: int32
            default: 10
            minimum: 1
            maximum: 100
        - name: page
          in: query
          description: The next page number when fetching more posts.
          required: false
          schema:
            type: integer
            format: int32
            default: 1
      responses:
        \'200\':
          description: Successful retrieval of posts.
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: \'#/components/schemas/Posts\'
        \'400\':
          description: Bad Request
        \'401\':
          description: Unauthorized
        \'403\':
          description: Forbidden
        \'404\':
          description: Not Found
        \'500\':
          description: Failed to fetch posts
components:
  schemas:
    Posts:
      type: object
      properties:
        id:
          type: integer
          format: int64
        title:
          type: object
          properties:
            rendered:
              type: string
        slug:
          type: string
        link:
          type: string
        date:
          type: string
          format: date-time
        content:
          type: object
          properties:
            rendered:
              type: string
        excerpt:
          type: object
          properties:
            rendered:
              type: string';

    $gpt_instructions = '
Actions:

- Fetch posts from JSON to use in responses.
- Initiate a search when user queries include topic-related terms or retrieve multiple posts for analysis.
- If no results, retry with a more general term.
- Default to 10 posts, and ask if the user wants more.
- Select the most relevant post(s) by analyzing titles and content.
- Fetch the full content of a post when it is relevant to a search query or selected by the user.';
?>

    <div class="text-center max-w-4xl pr-3 md:pr-5 mx-auto">
          <div class="my-6">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2">Sync to GPT</h1>
            <p class="text-lg max-w-2xl text-gray-500 mx-auto">Create custom versions of ChatGPT that use your WordPress posts as knowledge.</p>
          </div>

          <div class="max-w-xl mx-auto my-6 border-b-2 pb-4">
            <div class="flex pb-3">
              <div class="flex-1">
              </div>

              <div id="wp2gpt-step-1" class="wp2gpt-tab flex-1 cursor-pointer">
                <div class="w-10 h-10 bg-green-500 border-2 border-gray-200 mx-auto rounded-full text-lg text-white flex items-center">
                  <span class="text-white text-center w-full">1</span>
                </div>
              </div>

              <div class="w-1/4 align-center items-center align-middle content-center flex">
                <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                  <div class="text-xs leading-none py-1 text-center text-gray-400 rounded " style="width: 100%"></div>
                </div>
              </div>

              <div id="wp2gpt-step-2" class="wp2gpt-tab flex-1 cursor-pointer">
                <div class="w-10 h-10 bg-white border-2 border-gray-200 mx-auto rounded-full text-lg text-white flex items-center">
                  <span class="text-gray-400 text-center w-full">2</span>
                </div>
              </div>

              <div class="w-1/4 align-center items-center align-middle content-center flex">
                <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                  <div class="text-xs leading-none py-1 text-center text-gray-400 rounded " style="width: 100%"></div>
                </div>
              </div>

              <div id="wp2gpt-step-3" class="wp2gpt-tab flex-1 cursor-pointer">
                <div class="w-10 h-10 bg-white border-2 border-gray-200 mx-auto rounded-full text-lg text-white flex items-center">
                  <span class="text-gray-400 text-center w-full">3</span>
                </div>
              </div>

              <div class="flex-1">
              </div>
            </div>

            <div class="flex text-xs content-center text-center">
              <div class="w-1/2 pr-3">
                OpenAPI Schema
              </div>

              <div class="w-1/2">
                Instructions
              </div>

              <div class="w-1/2 pl-3">
                Sample GPT Prompts
              </div>
            </div>
          </div>

          <div id="wp2gpt-content-1" class="wp2gpt-content">
            <h2 class="text-2xl font-semibold mb-2">OpenAPI Schema</h2>
              <p class="mb-4">You can make your WordPress posts available to your GPT with the following details about how the model should use them. <br class="lg:block hidden" /> Copy the following OpenAPI schema to your GPT's actions configuration.</p>
              <textarea id="openapi-schema" rows="15" disabled class="w-full p-4 border border-gray-200 rounded-md" ><?php echo esc_textarea($openapi_schema); ?></textarea>
          </div>

          <div id="wp2gpt-content-2" class="wp2gpt-content" style="display:none;">
              <h2 class="text-2xl font-semibold mb-2">Instructions</h2>
              <p class="mb-4">Add the following to the end of your GPT instructions and modify as needed for your specific use case.</p>
              <textarea rows="15" disabled class="w-full p-4 border border-gray-200 rounded-md"><?php echo esc_textarea($gpt_instructions); ?></textarea>
          </div>

          <div id="wp2gpt-content-3" class="wp2gpt-content" style="display:none;">
              <h2 class="text-2xl font-semibold mb-2">Sample GPT Prompts</h2>
              <p class="mb-4">Below are prompt ideas that can be used with your GPT:</p>
              <div class="text-lg max-w-lg mx-auto">
                  "I need ideas to boost engagement on my blog."<br />
                  "Create a draft for a newsletter featuring 5 latest posts."<br />
                  "Draft a social media post for my latest article."<br />
                  "Predict trends in my industry."<br />
                  "Summarize the most recent post about [topic]."<br />
                  "Create a graph for my post [Post Title].<br />
                  "Generate a chart of sentiments for posts over the past month, labeling them as positive, negative, or neutral.
              </div>
          </div>
      </div>
    <?php
  }
}

WP2GPT_Settings::register();
