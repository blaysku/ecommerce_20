<?php

namespace App\Models;

class Cart
{
    public $items = null;
    public $totalQuantity = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $quantity)
    {
        $storedItem = [
            'quantity' => 0,
            'price' => $item->price,
            'item' => $item,
            'restAmount' => 0,
        ];

        if ($this->items && array_key_exists($id, $this->items)) {
            $storedItem = $this->items[$id];
        }

        $storedItem['quantity'] += $quantity;
        $storedItem['price'] = $item->price * $storedItem['quantity'];
        $storedItem['restAmount'] = $item->quantity - $storedItem['quantity'];
        $this->items[$id] = $storedItem;
        $this->totalQuantity += $quantity;
        $this->totalPrice += $item->price * $quantity;
    }

    public function removeItem($id)
    {
        if ($this->items && array_key_exists($id, $this->items)) {
            $this->totalQuantity -= $this->items[$id]['quantity'];
            $this->totalPrice -= $this->items[$id]['price'];
            unset($this->items[$id]);

            return true;
        }

        return false;
    }
}
