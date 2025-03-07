<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AquariumTank;
use App\Models\Filter;
use App\Models\Light;
use App\Models\Heater;

class PartBrowser extends Component
{
    public $componentType = 'tanks';
    public $searchQuery = '';
    public $sortField = 'price';
    public $sortDirection = 'asc';

    public function render()
    {
        $query = $this->getModelForType($this->componentType);

        if (!empty($this->searchQuery)) {
            $query = $query->where('name', 'like', '%' . $this->searchQuery . '%')
                          ->orWhere('brand', 'like', '%' . $this->searchQuery . '%');
        }

        $components = $query->orderBy($this->sortField, $this->sortDirection)
                          ->paginate(10);

        return view('livewire.part-browser', [
            'components' => $components
        ]);
    }

    private function getModelForType($type)
    {
        switch($type) {
            case 'tanks':
                return AquariumTank::query();
            case 'filters':
                return Filter::query();
            case 'lights':
                return Light::query();
            case 'heaters':
                return Heater::query();
            default:
                return AquariumTank::query();
        }
    }

    public function setComponentType($type)
    {
        $this->componentType = $type;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
}
