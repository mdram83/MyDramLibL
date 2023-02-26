<?php

namespace App\Utilities\Librarian;

use App\Models\Item;

class Navigator implements NavigatorInterface
{
    protected array $libraryMap = [
        'itemables' => [
            'Book' => [
                'routeName' => 'books',
                'defaultThumbnail' => 'Book',
                'menuName' => 'Books',
                'svg' => [
                    'default' => 'book',
                ]
            ],
            'Music Album' => [
                'routeName' => 'music',
                'defaultThumbnail' => 'MusicAlbum',
                'menuName' => 'Music Albums',
                'svg' => [
                    'default' => 'music',
                ]
            ],
        ],
        'thumbnails' => [
            'location' => '/images/thumbnails/defaults/',
            'fileExtension' => '.png',
        ],
        'routeSuffix' => [
            'All' => '',
            'Details' => '.show',
            'Add' => '.create',
        ],
    ];

    public function getItemableShowLink(Item $item): string
    {
        $this->verifyItemableType($item->itemable_type);

        return route(
            $this->libraryMap['itemables'][$item->itemable_type]['routeName']
            . $this->libraryMap['routeSuffix']['Details'],
            $item->itemable_id
        );
    }

    public function getItemableDefaultThumbnail(Item $item): string
    {
        $this->verifyItemableType($item->itemable_type);

        return
            $this->libraryMap['thumbnails']['location']
            . $this->libraryMap['itemables'][$item->itemable_type]['defaultThumbnail']
            . $this->libraryMap['thumbnails']['fileExtension'];
    }

    public function getItemableDefaultSvgIcon(string $itemableType): string
    {
        $this->verifyItemableType($itemableType);

        return $this->libraryMap['itemables'][$itemableType]['svg']['default'];
    }

    public function getItemableTypes(): array
    {
        return array_keys($this->libraryMap['itemables']);
    }

    public function getItemableMenuName(string $itemableType): string
    {
        $this->verifyItemableType($itemableType);

        return $this->libraryMap['itemables'][$itemableType]['menuName'];
    }

    public function getItemableAllLink(string $itemableType): string
    {
        $this->verifyItemableType($itemableType);

        return route(
            $this->libraryMap['itemables'][$itemableType]['routeName']
            . $this->libraryMap['routeSuffix']['All']
        );
    }

    public function getItemableAddLink(string $itemableType): string
    {
        $this->verifyItemableType($itemableType);

        return route(
            $this->libraryMap['itemables'][$itemableType]['routeName']
            . $this->libraryMap['routeSuffix']['Add']
        );
    }

    protected function verifyItemableType(string $type): void
    {
        if (!isset($this->libraryMap['itemables'][$type])) {
            throw new NavigatorException('Itemable type not defined');
        }
    }
}
