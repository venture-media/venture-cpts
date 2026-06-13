# Venture CPTs

Simple WordPress plugin that registers five custom post types with category taxonomies and pretty permalinks.

## Post Types
- **Business Sectors** – with `Sector Categories`
- **Client Contacts** – with `Contact Categories`
- **Events** – with `Event Categories`
- **Traders** – with `Trader Categories`
- **Ministries** - with `Ministry Categories`

## Features
- Hierarchical categories for each post type
- Pretty permalinks (e.g. `/events/conferences/my-event/`)
- Gutenberg and REST API ready
- Clean `venture_` function prefixes

### Elementor Integration
- **Venture Events Grid** widget:
  - Display Events with Featured Image, Title, and Event Date
  - Adjustable number of columns
  - Sort by event date (newest/oldest first)
  - Option to hide past events
- **Event Date & Time** widget with built-in date/time picker
- Custom `_event_datetime` meta field support for the Events CPT

## Installation
1. Upload the **Venture CPTs** plugin to WordPress.
2. Activate **Venture CPTs** in the WordPress admin
3. Go to `WordPress admin → Settings → Permalinks` and click **Save Changes** (required for custom permalinks)
4. Go to `WordPress admin → Elementor → Editor → Settings → General` and check the boxes for the new post types. Then click **Save Changes**.

## Modifications
- This plugin has an [MIT Lisence](https://github.com/venture-media/venture-cpts/blob/5917c963fa009e81dab45cb47635db38b67aa9f0/LICENSE).
- To add additional CPTs, you may modify the files to include them.
