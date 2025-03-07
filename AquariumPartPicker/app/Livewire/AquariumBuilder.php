<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class AquariumBuilder extends Component
{
    public $selectedParts = [];
    public $totalPrice = 0;
    public $categories = [];

    public function mount()
    {
        // Load all categories
        $this->categories = Category::orderBy('display_order')->get();

        // Initialize selected parts array
        foreach ($this->categories as $category) {
            $this->selectedParts[$category->id] = null;
        }
    }

    public function selectPart($categoryId, $productId)
    {
        // Update the selected part
        $this->selectedParts[$categoryId] = $productId;

        // Recalculate the total price
        $this->calculateTotalPrice();

        // You could trigger compatibility checking here
        // $this->checkCompatibility();
    }

    public function removePart($categoryId)
    {
        // Remove a selected part
        $this->selectedParts[$categoryId] = null;

        // Recalculate the total price
        $this->calculateTotalPrice();
    }

    protected function calculateTotalPrice()
    {
        $this->totalPrice = 0;

        foreach ($this->selectedParts as $categoryId => $productId) {
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $this->totalPrice += $product->price;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.aquarium-builder');
    }
}
