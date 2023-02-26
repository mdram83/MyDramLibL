<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Svg extends Component
{

    public function __construct(
        public ?string $icon = null,
        public int $width = 24,
        public int $height = 24,
        public string $viewBox = '24 24',
        public string $fill = 'none',
        public string $stroke = 'currentColor',
        public int $strokeWidth = 2,
        public string $id = '',
        public string $class = '',
    )
    {
    }

    public function render(): View
    {
        return view('components.svg');
    }
}
