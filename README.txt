Based on your request for a README.txt file, here's a comprehensive documentation file for the Emar Timeline Slider plugin:

# Emar Timeline Slider

## Description
Emar Timeline Slider is a custom WordPress plugin that adds a beautiful, responsive timeline slider to your website using Elementor. This plugin creates an interactive slider that displays your posts or custom post types in a chronological timeline format, perfect for showcasing events, projects, news, or any time-based content.

## Features
- Fully responsive timeline slider
- Works with posts and custom post types
- Filter by categories and tags
- Customizable appearance and behavior
- Interactive timeline markers
- Play button for media content
- Smooth animations and transitions
- RTL support
- Elementor integration

## Requirements
- WordPress 5.8 or higher
- PHP 7.4 or higher
- Elementor 3.5.0 or higher

## Installation
1. Upload the `emar` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure Elementor is installed and activated
4. Edit a page with Elementor and find the 'Emar Timeline Slider' widget in the Emar category

## Usage
1. Edit a page with Elementor
2. Search for "Timeline" in the widgets panel or find the widget in the "Emar" category
3. Drag and drop the Timeline Slider widget onto your page
4. Configure the widget settings:
   - Content Settings: Choose your data source, filters, number of items, etc.
   - Slider Settings: Configure autoplay, animation, navigation, and layout options
   - Style: Customize the appearance of all elements including slides, titles, buttons, and navigation

## Widget Options

### Content Settings
- **Data Source**: Choose from available post types
- **Categories/Tags**: Filter your content (for post type 'post')
- **Number of Items**: Set how many items to display
- **Order By**: Date, Title, Random, or Menu Order
- **Order**: Ascending or Descending
- **Show/Hide**: Toggle title, excerpt, and read more button
- **Excerpt Length**: Control how much text to show
- **Read More Text**: Customize the button text

### Slider Settings
- **Autoplay**: Enable/disable automatic sliding
- **Autoplay Speed**: Control the time between slides
- **Animation Type**: Choose between Slide, Fade, or Zoom
- **Animation Speed**: Control the transition speed
- **Show Arrows/Dots**: Toggle navigation elements
- **Pause on Hover**: Pause autoplay when hovering
- **Draggable**: Allow mouse drag/swipe
- **Items to Show**: Control how many slides appear at once
- **Center Mode**: Emphasize the active slide

### Style Settings
Comprehensive styling options for:
- Slider container
- Individual slides
- Titles and excerpts
- Read more buttons
- Timeline markers
- Navigation arrows
- Play buttons
- Thumbnails

## Troubleshooting

### Common Issues
- **Slider not appearing**: Make sure Elementor is updated to version 3.5.0 or higher
- **JavaScript errors**: Check for conflicts with other plugins using Slick Carousel
- **Vertical slider instead of horizontal**: Clear your browser cache and check for CSS conflicts
- **Missing images**: Ensure your posts have featured images set

### Debug Mode
To enable debug mode, add the following to your wp-config.php:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```
Then check the debug.log file in your wp-content directory for any errors.

## Uninstallation
1. Deactivate the plugin through the 'Plugins' menu in WordPress
2. Delete the plugin through the 'Plugins' menu in WordPress

## Credits
- Uses [Slick Carousel](https://kenwheeler.github.io/slick/) for the slider functionality
- Compatible with [Elementor](https://elementor.com/) page builder

## License
This plugin is licensed under the GPL v2 or later.

## Support
For support questions, bug reports, or feature requests, please contact us at support@example.com or visit our website at https://example.com/emar/

## Changelog

### 1.0.0
- Initial release

## Upcoming Features
- Additional animation effects
- More timeline marker styles
- Video integration options
- Additional filtering options
- Import/export of slider configurations