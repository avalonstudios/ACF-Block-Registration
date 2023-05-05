<?php

namespace Aabr;

class BodyClass
{
    public function __construct()
    {
        $current_theme = wp_get_theme();

        if ('sage' === $current_theme->get('Template') || 'sage' === $current_theme->get('Stylesheet')) {
            add_filter('body_class', [
                $this,
                'bodyClass',
            ]);
        }
    }

    public function bodyClass($classes): array
    {
        global $post;

        if (!is_object($post)) {
            return [];
        }

        $blocks = parse_blocks($post->post_content);

        $get_all_acf_blocks = $this->parseBlocks($blocks);

        $acf_block_titles = $this->getBlockTitleOnly($get_all_acf_blocks);

        foreach ($acf_block_titles as $block) {
            $classes[] = $block;
        }

        return $classes;
    }

    private function parseBlocks($blocks): array
    {
        $blocks_array = [];

        foreach ($blocks as $block) {
            $blocks_array[] = $block;

            if (!empty($block['innerBlocks'])) {
                $this->parseBlocks($block['innerBlocks']);
            }
        }

        return $blocks_array;
    }

    private function getBlockTitleOnly($blocks): array
    {
        $blocks = collect($blocks)
            ->flatten()
            ->toArray();

        $acf_blocks = [];

        foreach ($blocks as $block) {
            if (str_contains($block, 'acf/')) {
                if (!empty($block)) {
                    $strip_acf_slash = str_replace('acf/', '', $block);

                    if (!in_array($strip_acf_slash, $acf_blocks)) {
                        $acf_blocks[] = $strip_acf_slash;
                    }
                }
            }
        }

        return $acf_blocks;
    }
}

new BodyClass();
