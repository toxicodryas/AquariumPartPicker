<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AquariumTank;
use App\Models\Fish;
use App\Models\Inverts;
use App\Model\Plants;
use App\Model\Coral;
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
use App\Models\Build;
use App\Models\BuildItem;
use Illuminate\Support\Str;

class AquariumBuilder extends Component
{
    public $selectedParts = [];
    public $totalPrice = 0;
    
    // Define component types
    public $componentTypes = [
        'aquarium_tanks',
        'filters',
        'heaters',
        'lights',
        'sumps',
        'skimmers',
        'substrates',
        'stands',
        'pumps',
        'reactors',
        'chillers',
        'dosing_pumps',
        'atos',
    ];
    
    protected $listeners = ['selectPart', 'removePart'];
    
    public function mount()
    {
        // Initialize selected parts array
        foreach ($this->componentTypes as $type) {
            $this->selectedParts[$type] = null;
        }
    }
    
    public function selectPart($componentType, $itemId)
    {
        // Update the selected part
        $this->selectedParts[$componentType] = $itemId;
        
        // Recalculate the total price
        $this->calculateTotalPrice();
    }
    
    public function removePart($componentType)
    {
        // Remove a selected part
        $this->selectedParts[$componentType] = null;
        
        // Recalculate the total price
        $this->calculateTotalPrice();
    }
    
    protected function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        
        foreach ($this->selectedParts as $componentType => $itemId) {
            if ($itemId) {
                $modelClass = $this->getModelClass($componentType);
                
                if (class_exists($modelClass)) {
                    $item = $modelClass::find($itemId);
                    if ($item && isset($item->price)) {
                        $this->totalPrice += $item->price;
                    }
                }
            }
        }
    }
    
    public function getModelClass($componentType)
    {
        // Map component types to their model classes
        $modelMap = [
            'aquarium_tanks' => AquariumTank::class,
            'filters' => Filter::class,
            'heaters' => Heater::class,
            'lights' => Light::class,
            'sumps' => Sump::class,
            'skimmers' => Skimmer::class,
            'substrates' => Substrate::class,
            'stands' => Stand::class,
            'pumps' => Pump::class,
            'reactors' => Reactor::class,
            'chillers' => Chiller::class,
            'dosing_pumps' => DosingPump::class,
            'atos' => ATO::class,
        ];
        
        return $modelMap[$componentType] ?? null;
    }
    
    public function getSelectedItem($componentType)
    {
        $itemId = $this->selectedParts[$componentType] ?? null;
        
        if ($itemId) {
            $modelClass = $this->getModelClass($componentType);
            
            if (class_exists($modelClass)) {
                return $modelClass::find($itemId);
            }
        }
        
        return null;
    }
    
    public function getComponentTitle($componentType)
    {
        $titles = [
            'aquarium_tanks' => 'Tank',
            'filters' => 'Filter',
            'heaters' => 'Heater',
            'lights' => 'Lighting',
            'sumps' => 'Sump',
            'skimmers' => 'Protein Skimmer',
            'substrates' => 'Substrate',
            'stands' => 'Stand',
            'pumps' => 'Water Pump',
            'reactors' => 'Reactor',
            'chillers' => 'Chiller',
            'dosing_pumps' => 'Dosing Pump',
            'atos' => 'Auto Top-Off',
        ];
        
        return $titles[$componentType] ?? Str::title(str_replace('_', ' ', $componentType));
    }
    
    public function saveBuild()
    {
        // Create a new build
        $build = Build::create([
            'user_id' => auth()->id(),
            'name' => 'My Aquarium Build',
            'total_price' => $this->totalPrice,
        ]);
        
        // Save all selected parts to the build
        foreach ($this->selectedParts as $componentType => $itemId) {
            if ($itemId) {
                BuildItem::create([
                    'build_id' => $build->id,
                    'component_type' => $componentType,
                    'component_id' => $itemId,
                ]);
            }
        }
        
        // Redirect to the dashboard
        session()->flash('message', 'Build saved successfully!');
        return redirect()->route('dashboard');
    }
    
    public function render()
    {
        return view('livewire.aquarium-builder');
    }
}
