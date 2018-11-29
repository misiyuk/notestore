<?php

namespace store\clientEntities;

use store\clientEntities\storage\CookieStorage;
use store\clientEntities\storage\StorageInterface;
use store\entities\Arrangement;

/**
 * @property CookieStorage $storage
 * @property Arrangement[] $items
 */
class ArrangementViewed
{
    private $storage;
    private $items;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    private function saveItems(): void
    {
        $this->storage->save(array_map(function(Arrangement $arrangement) {
            return $arrangement->id;
        }, $this->items));
    }

    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = Arrangement::find()
                ->where(['id' => $this->storage->load()])
                ->all();
        }
    }

    /**
     * @return Arrangement[]
     */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $this->loadItems();
        return count($this->items);
    }

    public function add(Arrangement $item): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $arrangement) {
            if ($arrangement->id == $item->id) {
                unset($this->items[$i]);
                break;
            }
        }
        $this->items[] = $item;
        $this->saveItems();
    }

    public function remove(int $id): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $arrangement) {
            if ($arrangement->id == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function itemIsSet(int $id): bool
    {
        $this->loadItems();
        foreach ($this->items as $i => $arrangement) {
            if ($arrangement->id == $id) {
                return true;
            }
        }
        return false;
    }
}
