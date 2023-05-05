<?php

namespace Aabr;

/**
 * This class initializes ACF and registers custom blocks.
 */
class AcfInit
{
    /**
     * Constructor.
     * Adds a hook to initialize ACF and register custom blocks.
     */
    public function __construct()
    {
        // Check if ACF is installed and the required function exists.
        if (function_exists('acf_register_block_type')) {
            // Add an action to initialize ACF and register custom blocks.
            add_action('acf/init', [
                $this,
                'acfInit',
            ]);
        }
    }

    /**
     * Initializes ACF and registers custom blocks.
     * Gets all the custom block directories and registers them as blocks.
     * Uses glob() to get all directories in the custom block directory.
     */
    public function acfInit(): void
    {
        // Get all the directories in the custom block directory.
        $block_dirs = glob(get_template_directory() . '/app/blocks/*', GLOB_ONLYDIR);

        // Check if the glob() function returned any directories.
        if ($block_dirs === false) {
            return;
        }

        // Register each custom block as a block type.
        foreach ($block_dirs as $block_dir) {
            register_block_type($block_dir);
        }
    }
}

new AcfInit();
