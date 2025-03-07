<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\AquariumTank;
use App\Models\Filter;
use App\Models\Light;
use App\Models\Heater;
use App\Models\Sump;
use App\Models\Skimmer;
use App\Models\Substrate;
use App\Models\Stand;
use App\Models\Pump;
use App\Models\Reactor;
use App\Models\Chiller;
use App\Models\DosingPump;
use App\Models\ATO;

class PartBrowser extends Component
{
    use WithPagination;

    // Existing properties
    public $componentType = 'aquarium_tanks';
    public $searchQuery = '';
    public $sortField = 'price';
    public $sortDirection = 'asc';

    // New properties for selection
    public $selectedItemId = null;
    public $componentTitle = '';
    public $componentDescription = '';

    // Listen for events from other components
    protected $listeners = ['partSelected' => 'onPartSelected'];

    public function mount($componentType = 'aquarium_tanks', $selectedItemId = null)
    {
        $this->componentType = $componentType;
        $this->selectedItemId = $selectedItemId;

        // Set component title and description based on type
        $this->setComponentInfo();
    }

    protected function setComponentInfo()
    {
        // Map component types to human-readable titles and descriptions
        $componentInfo = [
            'aquarium_tanks' => [
                'title' => 'Tank',
                'description' => 'Select the main aquarium tank'
            ],
            'filters' => [
                'title' => 'Filter',
                'description' => 'Choose a filtration system for your aquarium'
            ],
            'heaters' => [
                'title' => 'Heater',
                'description' => 'Select a heater to maintain water temperature'
            ],
            'lights' => [
                'title' => 'Lighting',
                'description' => 'Choose lighting for your aquarium'
            ],
            'sumps' => [
                'title' => 'Sump',
                'description' => 'Select a sump for additional filtration'
            ],
            'skimmers' => [
                'title' => 'Protein Skimmer',
                'description' => 'Choose a protein skimmer for your saltwater tank'
            ],
            'substrates' => [
                'title' => 'Substrate',
                'description' => 'Select substrate for your aquarium bed'
            ],
            'stands' => [
                'title' => 'Stand',
                'description' => 'Choose a stand to support your aquarium'
            ],
            'pumps' => [
                'title' => 'Water Pump',
                'description' => 'Select a circulation or return pump'
            ],
            'reactors' => [
                'title' => 'Reactor',
                'description' => 'Choose media reactors for chemical filtration'
            ],
            'chillers' => [
                'title' => 'Chiller',
                'description' => 'Select a chiller to cool your aquarium'
            ],
            'dosing_pumps' => [
                'title' => 'Dosing Pump',
                'description' => 'Choose an automated dosing system'
            ],
            'atos' => [
                'title' => 'Auto Top-Off',
                'description' => 'Select an automatic top-off system'
            ],
        ];

        if (isset($componentInfo[$this->componentType])) {
            $this->componentTitle = $componentInfo[$this->componentType]['title'];
            $this->componentDescription = $componentInfo[$this->componentType]['description'];
        } else {
            $this->componentTitle = Str::title(str_replace('_', ' ', $this->componentType));
            $this->componentDescription = 'Select a ' . Str::singular($this->componentTitle) . ' for your aquarium';
        }
    }

    public function getModelForType($type)
    {
        // Expanded version of your original function
        switch($type) {
            case 'aquarium_tanks':
                return AquariumTank::query();
            case 'filters':
                return Filter::query();
            case 'lights':
                return Light::query();
            case 'heaters':
                return Heater::query();
            case 'sumps':
                // Return empty query or placeholder if model doesn't exist
                return new \Illuminate\Database\Eloquent\Builder(new \Illuminate\Database\Query\Builder(
                    app('db')->connection()
                ));
            case 'skimmers':
                // Same handling for other missing models
                return new \Illuminate\Database\Eloquent\Builder(new \Illuminate\Database\Query\Builder(
                    app('db')->connection()
                ));
            // Similar handling for other missing models
            default:
                return AquariumTank::query();
        }
    }


    public function setComponentType($type)
    {
        $this->componentType = $type;
        $this->resetPage();
        $this->setComponentInfo();
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

    public function selectItem($itemId)
    {
        $this->selectedItemId = $itemId;

        // Emit an event to notify the parent component
        $this->emitUp('selectPart', $this->componentType, $itemId);
    }

    // Update selected state when changed elsewhere
    public function onPartSelected($componentType, $itemId)
    {
        if ($componentType == $this->componentType) {
            $this->selectedItemId = $itemId;
        }
    }

    public function render()
    {
        $query = $this->getModelForType($this->componentType);

        if (!empty($this->searchQuery)) {
            $query = $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%');

                // Only add brand search if the column exists
                if (in_array($this->componentType, ['aquarium_tanks', 'filters', 'lights', 'heaters'])) {
                    $q->orWhere('brand', 'like', '%' . $this->searchQuery . '%');
                }
            });
        }

        $components = $query->orderBy($this->sortField, $this->sortDirection)
                           ->paginate(10);

        return view('livewire.part-browser', [
            'components' => $components,
            'componentType' => $this->componentType,
            'componentTitle' => $this->componentTitle,
            'componentDescription' => $this->componentDescription
        ]);
    }
}
