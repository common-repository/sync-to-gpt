=== Sync to GPT - Connect ChatGPT to Your Posts ===
Contributors: virgildia
Donate link: http://virgiliudiaconu.com
Tags: ai, chatgpt, gpts, ai, openai
Requires at least: 5.8
Tested up to: 6.5.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Sync to GPT allows ChatGPT to interact with your WordPress posts. The plugin is useful for content analysis, article creation, marketing strategies, creating charts, and more—all directly within ChatGPT. Additionally, you can deliver your WordPress content to millions of users on ChatGPT.

= Prompt Examples =

Below are examples of prompts you can use once you've connected your posts in ChatGPT:

"Create a draft for a newsletter featuring my 5 latest posts."
"I need ideas to boost engagement on my blog."
"Provide marketing stategies based on my posts."
"Get the latest article about [topic] and draft an engaging social media post."
"Create a graph for my post, [Post Title]".
"Generate a chart of sentiments for posts over the past month, labeling them as positive, negative, or neutral."

= Features =

 - WordPress REST API: Utilizes a custom endpoint to connect to the WordPress REST JSON API for reading posts.
 - Multiple Post Retrieval: Retrieves 10 or more posts at a time for ChatGPT interactions.
 - Single Post Retrieval: Retrieves the full content of relevant single posts.
 - Post Search: Initiates searches based on search terms derived from user questions in ChatGPT.
 - Pagination: Option to navigate through different sets of posts (next page).
 - HTML Content Cleaning: Automatically cleans full post content before sending to ChatGPT, ensuring concise context for ChatGPT interactions. This is performed through the plugin's custom endpoint.

= Settings =

 - OpenAPI Schema: A generated OpenAPI schema to paste into your GPT's actions configuration.
 - GPT Instructions: Specific instructions for your GPT to interact with your WordPress posts.

== How to Use ==

1. Create a new GPT in ChatGPT.
2. Copy the OpenAPI schema from the Sync to GPT plugin settings and paste it into your GPT's actions configuration.
3. Copy the GPT instructions from the plugin settings and paste it at the end of your GPT's custom instructions. Modify and iterate the instructions based on your needs
4. Enter your privacy policy page URL if your GPT is public.

== Requirements ==

PHP 5.6+ recommended, WordPress 5.8+, self-hosted WordPress website with the WordPress REST API enabled.

== Installation ==

1. From your WordPress dashboard go to **Plugins > Add New**.
2. Search for **Sync to GPT** in the **Search Plugins** box.
3. Click **Install Now** to install the **Sync to GPT** Plugin.
4. Click **Activate** to activate the plugin.
5. **Sync to GPT** will be added as a submenu in **Settings**.
6. Copy the OpenAPI schema from the Sync to GPT plugin settings and paste it into your GPT's actions configuration.
7. Copy the GPT instructions from the plugin settings and paste it at the end of your GPT's custom instructions. Modify and iterate the instructions based on your needs.
8. Interact with your WordPress posts directly from ChatGPT.

If you still need help. visit [WordPress codex](https://wordpress.org/documentation/article/manage-plugins/)

== Screenshots ==

1. Sync to GPT settings.
2. Adding the generated custom OpenAPI schema to ChatGPT settings.
3. Creating a newsletter based on posts from WordPress.
4. Asking for sentiment analysis.

== Frequently Asked Questions ==

= What is are GPTs? =

GPTs are custom versions of ChatGPT that users can tailor for specific tasks or topics by combining instructions, knowledge, and capabilities.

= Is Sync to GPT compatible with any WordPress website? =

Sync to GPT works with any **self-hosted** WordPress website that has the JSON REST API feature enabled for posts.

= How can I access custom post types? =

Currently, Sync to GPT only supports default WordPress posts. Support for custom post types is planned for future updates.

= Can Sync to GPT create or delete posts?

No, the plugin cannot create or delete posts. It can only read the posts that are publicly available in your WordPress site's REST API.

= Does Sync to GPT store any user data and conversations? =

Sync to GPT does not collect or retain any user data or conversations from ChatGPT interactions. If you choose to implement custom logging solutions, it's important to update your privacy policy accordingly to reflect these changes.

---

== Changelog ==

= 1.0 =
First release of the plugin.

= 1.1 =
Style changes.
