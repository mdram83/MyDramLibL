<?php

namespace App\Utilities\Librarian;

use App\Models\Item;

class Navigator implements NavigatorInterface
{
    protected array $libraryMap = [
        'itemables' => [
            'Book' => [
                'routeName' => 'books',
                'defaultThumbnail' => 'Book'
            ],
            'Music Album' => [
                'routeName' => 'music',
                'defaultThumbnail' => 'MusicAlbum'
            ],
        ],
        'thumbnails' => [
            'location' => '/images/thumbnails/defaults/',
            'fileExtension' => '.png',
        ],
    ];

    public function getItemableShowLink(Item $item): string
    {
        $this->verifyItemableType($item);

        return route(
            $this->libraryMap['itemables'][$item->itemable_type]['routeName'] . '.show',
            $item->itemable_id
        );
    }

    public function getItemableDefaultThumbnail(Item $item): string
    {
        $this->verifyItemableType($item);

        return
            $this->libraryMap['thumbnails']['location']
            . $this->libraryMap['itemables'][$item->itemable_type]['defaultThumbnail']
            . $this->libraryMap['thumbnails']['fileExtension'];
    }

    protected function verifyItemableType(Item $item): void
    {
        if (!isset($this->libraryMap['itemables'][$item->itemable_type])) {
            throw new NavigatorException('Itemable type not found');
        }
    }
}
