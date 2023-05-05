<?php

namespace Aabr\Abstracts;

abstract class LoadAssets
{
    public function __construct($assets)
    {
        if (!$assets) {
            return;
        }

        foreach ($assets as $type => $asset) {
            switch ($type) {
                case 'css':
                    // load styles
                    $this->enqueueStyles($assets['directory'], $asset);
                    break;

                case 'js':
                    // load scripts
                    $this->enqueueScripts($assets['directory'], $asset);
                    break;
            }
        }
    }

    private function enqueueStyles($directory, $assets)
    {
        foreach ($assets as $asset) {
            $handle = $asset;
            $file   = $this->resourceUrl($asset, 'css');

            if (wp_script_is($handle)) {
                continue;
            } else {
                wp_enqueue_style(
                    $handle,
                    $file
                );
            }
        }
    }

    private function resourceUrl($asset, $type): string
    {
        if (strpos($asset, '*') !== false) {
            $asset = str_replace('*', '', $asset);
        }

        return \Roots\asset("/{$type}/{$asset}")->uri();
    }

    private function enqueueScripts($directory, $assets)
    {
        foreach ($assets as $asset) {
            $handle = $asset;
            $file   = $this->resourceUrl($asset, 'js');

            if (wp_script_is($handle)) {
                continue;
            } else {
                wp_enqueue_script(
                    $handle,
                    $file
                );
            }
        }
    }
}
