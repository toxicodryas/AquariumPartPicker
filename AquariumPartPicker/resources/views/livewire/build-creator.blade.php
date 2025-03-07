<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Create Your Aquarium Build</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Build Components Selection -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tank</h2>
                <select wire:model="selectedTankId" wire:change="selectTank($event.target.value)" class="w-full p-2 border rounded">
                    <option value="">Select a Tank</option>
                    @foreach($tanks as $tank)
                        <option value="{{ $tank->id }}">{{ $tank->brand }} {{ $tank->name }} - {{ $tank->volume_gallons }}G (${{ number_format($tank->price, 2) }})</option>
                    @endforeach
                </select>

                <!-- Display selected tank details if any -->
                @if($tank)
                    <div class="mt-4 p-4 bg-blue-50 rounded">
                        <h3 class="font-semibold">{{ $tank->brand }} {{ $tank->name }}</h3>
                        <p>Size: {{ $tank->volume_gallons }} gallons ({{ $tank->length_inches }}" × {{ $tank->width_inches }}" × {{ $tank->height_inches }}")</p>
                        <p>{{ $tank->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Similar sections for Filter, Light, Heater -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Filter</h2>
                <select wire:model="selectedFilterId" wire:change="selectFilter($event.target.value)" class="w-full p-2 border rounded">
                    <option value="">Select a Filter</option>
                    @foreach($filters as $filterOption)
                        <option value="{{ $filterOption->id }}">{{ $filterOption->brand }} {{ $filterOption->name }} (${{ number_format($filterOption->price, 2) }})</option>
                    @endforeach
                </select>

                @if($filter)
                    <div class="mt-4 p-4 bg-blue-50 rounded">
                        <h3 class="font-semibold">{{ $filter->brand }} {{ $filter->name }}</h3>
                        <p>Type: {{ $filter->type }} - Flow Rate: {{ $filter->flow_rate }} GPH</p>
                        <p>Recommended for tanks: {{ $filter->min_tank_size }}-{{ $filter->max_tank_size }} gallons</p>
                        <p>{{ $filter->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Add sections for Light and Heater following the same pattern -->
        </div>

        <!-- Build Summary -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-xl font-semibold mb-4">Build Summary</h2>

                <div class="mb-4">
                    <label for="buildName" class="block text-sm font-medium text-gray-700">Build Name</label>
                    <input type="text" id="buildName" wire:model="buildName" class="mt-1 p-2 w-full border rounded" placeholder="My Dream Aquarium">
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between">
                        <span>Tank:</span>
                        <span>{{ $tank ? '$'.number_format($tank->price, 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Filter:</span>
                        <span>{{ $filter ? '$'.number_format($filter->price, 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Light:</span>
                        <span>{{ $light ? '$'.number_format($light->price, 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Heater:</span>
                        <span>{{ $heater ? '$'.number_format($heater->price, 2) : '-' }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-200 font-bold flex justify-between">
                        <span>Total:</span>
                        <span>${{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>

                <button wire:click="saveBuild" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Save Build
                </button>
            </div>
        </div>
    </div>
</div>
