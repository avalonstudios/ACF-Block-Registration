## Usage

1. Create a folder in `{theme}/app/` and call it `blocks`
2. Create a folder for each Gutenberg block and inside create 2 files:
    -	block.json
    -	arbitrary-name-for-template-file-123.php

Add block meta inside the `block.json` file:

    {
      "name": "acf/block-name",
      "title": "Block Title",
      "description": "Displays a block of some sort.",
      "category": "layout",
      "icon": "admin-comments",
      "keywords": [
        "keyword1",
        "keyword2"
      ],
      "supports": {
        "align": true,
        "anchor": true,
        "ariaLabel": true,
        "alignWide": true,
        "className": true,
        "html": true
      },
      "acf": {
        "mode": "preview",
        "renderTemplate": "arbitrary-name-for-template-file-123.php"
      }
    }

We'll come back to `arbitrary-name-for-template-file-123.php` later.
___

Add a `Classes/Blocks` folder in the `{theme}/app/` folder.

Start adding classes. For e.g. in BlockExample.php

    <?php

    namespace App\Classes\Blocks;

    use Aabr\Abstracts\BlockAttributesParser;
    use Aabr\Interfaces\BlocksInterface;

    class CarouselImages extends BlockAttributesParser implements BlocksInterface
    {
        private array $fields;

        public function __construct($block, $fields)
        {
            parent::__construct($block, $fields, $this->loadAssets());
    
            $this->fields = $fields;
        }

        public function getAttributes(): array
        {
            return parent::getBlockAttributes();
        }
    
        public function getFields(): array
        {
            return $this->parseFields($this->fields);
        }

        private function parseFields($fields): array
        {
            return [];
        }

        public function loadAssets()
        {
            return [
                'directory' => '',
                'css'       => [
                    'flickity.min.css*',
                ],
                'js'        => [
                    'flickity.min.js*',
                ],
            ];
        }
    }
___

In `{theme}/resources/views/` add a `blocks` folder. Add a blade view file for e.g. `blade-view-file-example.blade.php`:

    <x-blocks :anchor="$attributes['anchor']"
              :classes="$attributes['classes']"
              moreclasses=" ava-block carousel-images carousel">

		@dump($fields);

    </x-blocks>


Then in

    <?php

    use App\Classes\Blocks\BlockExample;

    $fields = get_fields();

    $maps = new BlockExample($block, $fields);

    echo \Roots\view('blocks.blade-view-file-example', [
	    'attributes' => $maps->getAttributes(),
	    'fields'     => $maps->getFields(),
	    'block'      => $block,
    ]);



That's it!
