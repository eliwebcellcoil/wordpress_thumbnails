<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WPTR_Thumbnail_Regenerator {

    private $log_file;

    public function __construct() {
        $this->log_file = WPTR_PLUGIN_PATH . 'logs/regeneration-log.txt';
        add_action('wp_ajax_wptr_regenerate_thumbnails', [$this, 'regenerate_thumbnails']);
    }

    public function regenerate_thumbnails() {
        global $wpdb;

        $images = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%'", ARRAY_A);

        if (empty($images)) {
            wp_send_json_error(['message' => __('No images found.', 'wp-thumbnail-regenerator')]);
        }

        $start_time = microtime(true);
        $processed = [];
        
        foreach ($images as $image) {
            $attachment_id = $image['ID'];
            $fullsize_path = get_attached_file($attachment_id);

            if (!$fullsize_path) continue;

            $metadata = wp_generate_attachment_metadata($attachment_id, $fullsize_path);
            if (wp_update_attachment_metadata($attachment_id, $metadata)) {
                $processed[] = [
                    'file'   => basename($fullsize_path),
                    'sizes'  => $metadata['sizes'],
                    'path'   => $fullsize_path
                ];
            }
        }

        file_put_contents($this->log_file, print_r($processed, true));

        $time_taken = round(microtime(true) - $start_time, 2);

        wp_send_json_success([
            'message'   => __('Regeneration complete!', 'wp-thumbnail-regenerator'),
            'processed' => $processed,
            'time'      => $time_taken
        ]);
    }
}

new WPTR_Thumbnail_Regenerator();
