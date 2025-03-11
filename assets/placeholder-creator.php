<?php
/**
 * Create a placeholder image
 *
 * @package    Emar
 * @subpackage Emar/assets
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create a simple placeholder image with text
 */
function emar_create_placeholder_image() {
    // Define the path
    $plugin_dir = plugin_dir_path(dirname(__FILE__));
    $image_dir = $plugin_dir . 'assets/images';
    $image_path = $image_dir . '/placeholder.jpg';
    
    // Create directory if it doesn't exist
    if (!file_exists($image_dir)) {
        wp_mkdir_p($image_dir);
    }
    
    // Skip if the image already exists
    if (file_exists($image_path)) {
        return;
    }
    
    // Check if GD library is available
    if (!function_exists('imagecreatetruecolor')) {
        // If GD is not available, create a simple file
        file_put_contents($image_path, '');
        return;
    }
    
    // Create image
    $width = 800;
    $height = 600;
    $image = imagecreatetruecolor($width, $height);
    
    // Colors
    $bg_color = imagecolorallocate($image, 233, 30, 99); // #E91E63 (pink - matches theme)
    $text_color = imagecolorallocate($image, 255, 255, 255); // White
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add text
    $text = "Timeline Slider";
    $font_size = 5; // Largest built-in font
    
    // Center the text
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    $text_x = ($width - $text_width) / 2;
    $text_y = ($height - $text_height) / 2;
    
    imagestring($image, $font_size, $text_x, $text_y, $text, $text_color);
    
    // Add secondary text
    $secondary_text = "Placeholder Image";
    $secondary_font_size = 3;
    
    $secondary_text_width = imagefontwidth($secondary_font_size) * strlen($secondary_text);
    $secondary_text_x = ($width - $secondary_text_width) / 2;
    $secondary_text_y = $text_y + $text_height + 20;
    
    imagestring($image, $secondary_font_size, $secondary_text_x, $secondary_text_y, $secondary_text, $text_color);
    
    // Save image
    imagejpeg($image, $image_path, 90);
    imagedestroy($image);
}

// Create the placeholder image
emar_create_placeholder_image();