<?php

namespace store\clientEntities;

use store\clientEntities\storage\CookieStorage;
use store\clientEntities\storage\StorageInterface;
use store\entities\NotePack;

/**
 * @property CookieStorage $storage
 * @property NotePack[] $items
 */
class NotePackViewed
{
    private $storage;
    private $items;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    private function saveItems(): void
    {
        $this->storage->save(array_map(function(NotePack $notePack) {
            return $notePack->id;
        }, $this->items));
    }

    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = NotePack::find()
                ->where(['id' => $this->storage->load()])
                ->all();
        }
    }

    /**
     * @return NotePack[]
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
        return count($this->getItems());
    }

    public function add(NotePack $item): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $notePack) {
            if ($notePack->id == $item->id) {
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
        foreach ($this->items as $i => $notePack) {
            if ($notePack->id == $id) {
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
        foreach ($this->items as $i => $notePack) {
            if ($notePack->id == $id) {
                return true;
            }
        }
        return false;
    }
}
