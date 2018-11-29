<?php

namespace store\clientEntities;

use store\clientEntities\storage\CookieStorage;
use store\clientEntities\storage\StorageInterface;
use store\entities\Genre;
use store\entities\NotePack;
use store\entities\SaleOffer;
use yii\caching\CacheInterface;
use yii\caching\TagDependency;

/**
 * Class Cart
 * @package store\clientEntities
 *
 * @property CookieStorage $storage
 * @property SaleOffer[] $items
 * @property \yii\caching\FileCache $cache
 */
class Cart
{
    private $storage;
    private $items;
    private $cache;

    public function __construct(StorageInterface $storage, CacheInterface $cache)
    {
        $this->storage = $storage;
        $this->cache = $cache;
    }

    private function saveItems(): void
    {
        TagDependency::invalidate($this->cache, 'cart');
        $this->storage->save(array_map(function(SaleOffer $saleOffer){
            return $saleOffer->id;
        }, $this->items));
    }

    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = SaleOffer::find()
                ->where(['id' => $this->storage->load()])
                ->all();
        }
    }

    /**
     * @return SaleOffer[]
     */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    /**
     * @return NotePack[]
     */
    public function getGenres(): array
    {
        $this->loadItems();
        $genres = [];
        foreach ($this->getNotePacks() as $notePack) {
            $genres = array_merge($genres, $notePack->getGenres());
        }
        return $genres;
    }

    public function getNotePacks()
    {
        $this->loadItems();
        $notePacks = [];
        foreach ($this->items as $item) {
            if ($item->isNotePack()) {
                $notePacks[] = $item->offer;
            }
        }
        return $notePacks;
    }

    /**
     * @return NotePack[]
     */
    public function getRecommended(): array
    {
        $this->loadItems();
        $genreIds = array_map(function (Genre $genre) {
            return $genre->id;
        }, $this->getGenres());
        $notePackIds = array_map(function (NotePack $notePack) {
            return $notePack->id;
        }, $this->getNotePacks());
        $notePacks = NotePack::find()
            ->alias('n')
            ->joinWith(['arrangements.song.genres as genre'])
            ->where([
                'genre.id' => $genreIds
            ])
            ->andWhere([
                'not in', 'n.id', $notePackIds
            ])
            ->limit(20)
            ->all();
        return $notePacks;
    }

    public function clearItems(): void
    {
        $this->items = [];
        $this->saveItems();
    }

    public function getCount(): int
    {
        $this->loadItems();
        return count($this->items);
    }

    public function add(SaleOffer $item): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->id == $item->id) {
                throw new \DomainException('Item already set in cart');
            }
        }
        $this->items[] = $item;
        $this->saveItems();
    }

    public function remove($id): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $saleOffer) {
            if ($saleOffer->id == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function itemIsSet(SaleOffer $saleOffer): bool
    {
        $this->loadItems();
        foreach ($this->items as $item) {
            if ($item->id == $saleOffer->id) {
                return true;
            }
        }
        return false;
    }

    public function getPrice(): int
    {
        $this->loadItems();
        $price = 0;
        foreach ($this->items as $saleOffer) {
            $price += $saleOffer->price;
        }
        return $price;
    }
}
