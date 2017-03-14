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
        ];

        if ($this->items && array_key_exists($id, $this->items)) {
            $storedItem = $this->items[$id];
        }

        $storedItem['quantity'] += $quantity;
        $storedItem['price'] = $item->price * $storedItem['quantity'];
        $this->items[$id] = $storedItem;
        $this->totalQuantity += $quantity;
        $this->totalPrice += $item->price * $quantity;
    }
}
