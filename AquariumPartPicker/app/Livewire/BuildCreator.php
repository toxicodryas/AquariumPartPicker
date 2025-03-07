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
        if (!$this->selectedTankId) {
            return;
        }

        $tank = AquariumTank::find($this->selectedTankId);
        $tankVolume = $tank->volume_gallons;

        // Filter compatibility check
        if ($this->selectedFilterId) {
            $filter = Filter::find($this->selectedFilterId);

            // Check if filter is appropriate for tank size
            if ($filter->min_tank_size > $tankVolume) {
                $this->addWarning('filter', 'This filter is rated for larger tanks and may be too powerful.');
            } elseif ($filter->max_tank_size < $tankVolume) {
                $this->addWarning('filter', 'This filter may not provide adequate filtration for your tank size.');
            } else {
                $this->removeWarning('filter');
            }
        }

        // Heater compatibility check
        if ($this->selectedHeaterId) {
            $heater = Heater::find($this->selectedHeaterId);

            // Assume heaters have min_tank_size and max_tank_size properties
            if ($heater->min_tank_size > $tankVolume) {
                $this->addWarning('heater', 'This heater may be too powerful for your tank size.');
            } elseif ($heater->max_tank_size < $tankVolume) {
                $this->addWarning('heater', 'This heater may not provide adequate heating for your tank size.');
            } else {
                $this->removeWarning('heater');
            }
        }

        // Light compatibility check
        if ($this->selectedLightId && $tank) {
            $light = Light::find($this->selectedLightId);

            // Check if light fixture is appropriate length for tank
            if ($light->length_inches > $tank->length_inches) {
                $this->addWarning('light', 'This light fixture is too long for your tank.');
            } else {
                $this->removeWarning('light');
            }
        }
    }

    // Helper methods for warnings
    public $warnings = [];

    public function addWarning($component, $message)
    {
        $this->warnings[$component] = $message;
    }

    public function removeWarning($component)
    {
        if (isset($this->warnings[$component])) {
            unset($this->warnings[$component]);
        }
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
