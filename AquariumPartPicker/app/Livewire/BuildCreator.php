<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AquariumTank;
use App\Models\Filter;
use App\Models\Light;
use App\Models\Heater;

class BuildCreator extends Component
{
    public $currentBuild = [];
    public $selectedTankId = null;
    public $selectedFilterId = null;
    public $selectedLightId = null;
    public $selectedHeaterId = null;
    public $buildName = '';

    public function render()
    {
        $tank = $this->selectedTankId ? AquariumTank::find($this->selectedTankId) : null;
        $filter = $this->selectedFilterId ? Filter::find($this->selectedFilterId) : null;
        $light = $this->selectedLightId ? Light::find($this->selectedLightId) : null;
        $heater = $this->selectedHeaterId ? Heater::find($this->selectedHeaterId) : null;

        $totalPrice = collect([$tank, $filter, $light, $heater])
            ->filter()
            ->sum('price');

        return view('livewire.build-creator', [
            'tank' => $tank,
            'filter' => $filter,
            'light' => $light,
            'heater' => $heater,
            'totalPrice' => $totalPrice,
            // For selection dropdowns
            'tanks' => AquariumTank::orderBy('name')->get(),
            'filters' => Filter::orderBy('name')->get(),
            'lights' => Light::orderBy('name')->get(),
            'heaters' => Heater::orderBy('name')->get(),
        ]);
    }

    public function selectTank($id)
    {
        $this->selectedTankId = $id;
        // Clear incompatible components when tank changes
        $this->checkCompatibility();
    }

    public function selectFilter($id)
    {
        $this->selectedFilterId = $id;
    }

    public function selectLight($id)
    {
        $this->selectedLightId = $id;
    }

    public function selectHeater($id)
    {
        $this->selectedHeaterId = $id;
    }

    public function checkCompatibility()
    {
        // We'll implement this later with real compatibility logic
        // For now, just a placeholder to illustrate the concept
        if (!$this->selectedTankId) {
            return;
        }

        $tank = AquariumTank::find($this->selectedTankId);

        // Example: If filter is too powerful for the tank, clear it
        if ($this->selectedFilterId) {
            $filter = Filter::find($this->selectedFilterId);
            if ($filter->min_tank_size > $tank->volume_gallons) {
                $this->selectedFilterId = null;
            }
        }

        // Similar logic for other components...
    }

    public function saveBuild()
    {
        $this->validate([
            'buildName' => 'required|min:3',
            'selectedTankId' => 'required',
            // Add other validations as needed
        ]);

        // Calculate total price
        $tank = AquariumTank::find($this->selectedTankId);
        $filter = $this->selectedFilterId ? Filter::find($this->selectedFilterId) : null;
        $light = $this->selectedLightId ? Light::find($this->selectedLightId) : null;
        $heater = $this->selectedHeaterId ? Heater::find($this->selectedHeaterId) : null;

        $totalPrice = collect([$tank, $filter, $light, $heater])
            ->filter()
            ->sum('price');

        // Create the build
        $build = Build::create([
            'user_id' => auth()->id(),
            'name' => $this->buildName,
            'total_price' => $totalPrice,
            'is_public' => true, // Default to public, could add a toggle
        ]);

        // Add build items
        if ($tank) {
            BuildItem::create([
                'build_id' => $build->id,
                'component_type' => 'AquariumTank',
                'component_id' => $tank->id,
                'price' => $tank->price,
            ]);
        }

        // Add other components similarly
        if ($filter) {
            BuildItem::create([
                'build_id' => $build->id,
                'component_type' => 'Filter',
                'component_id' => $filter->id,
                'price' => $filter->price,
            ]);
        }
        // Repeat for light, heater, etc.

        session()->flash('message', 'Build saved successfully!');
        return redirect()->route('builds.show', $build);
    }
}
