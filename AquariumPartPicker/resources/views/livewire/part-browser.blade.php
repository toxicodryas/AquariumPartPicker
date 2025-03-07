<div>
    <!-- Search and Category Filters (from your original) -->
    <div class="mb-4">
        <input wire:model.debounce.300ms="searchQuery" type="text" placeholder="Search components..." class="px-4 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
        <div class="mt-2">
            <button wire:click="setComponentType('aquarium_tanks')" class="px-4 py-2 {{ $componentType === 'aquarium_tanks' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Tanks
            </button>
            <button wire:click="setComponentType('filters')" class="px-4 py-2 {{ $componentType === 'filters' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Filters
            </button>
            <button wire:click="setComponentType('lights')" class="px-4 py-2 {{ $componentType === 'lights' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Lights
            </button>
            <button wire:click="setComponentType('heaters')" class="px-4 py-2 {{ $componentType === 'heaters' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Heaters
            </button>
            <button wire:click="setComponentType('sumps')" class="px-4 py-2 {{ $componentType === 'sumps' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Sumps
            </button>
            <button wire:click="setComponentType('skimmers')" class="px-4 py-2 {{ $componentType === 'skimmers' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }} rounded">
                Skimmers
            </button>
        </div>
    </div>
    
    <!-- Component Title and Description -->
    <div class="mb-4">
        <h3 class="text-lg font-medium">{{ $componentTitle ?? 'Components' }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $componentDescription ?? 'Select components for your aquarium' }}</p>
    </div>
    
    <!-- Table with Selection Functionality -->
    <table class="min-w-full bg-white dark:bg-gray-800">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Image
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                    Name
                    @if($sortField === 'name')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('brand')">
                    Brand
                    @if($sortField === 'brand')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('price')">
                    Price
                    @if($sortField === 'price')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                
                <!-- Component-specific columns -->
                @if($componentType === 'aquarium_tanks')
                    <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('volume')">
                        Size (Gallons)
                        @if($sortField === 'volume')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                @endif
                
                @if($componentType === 'filters')
                    <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('flow_rate')">
                        Flow Rate (GPH)
                        @if($sortField === 'flow_rate')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                @endif
                
                @if(in_array($componentType, ['heaters', 'lights']))
                    <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('wattage')">
                        Wattage
                        @if($sortField === 'wattage')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                @endif
                
                <th class="px-6 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
                <tr class="{{ $selectedItemId == $component->id ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                        <img src="{{ $component->image_url ?? 'https://via.placeholder.com/50' }}" alt="{{ $component->name }}" class="h-10 w-10 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                        {{ $component->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                        {{ $component->brand ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                        ${{ number_format($component->price, 2) }}
                    </td>
                    
                    <!-- Component-specific data -->
                    @if($componentType === 'aquarium_tanks' && isset($component->volume))
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                            {{ $component->volume }} gallons
                        </td>
                    @endif
                    
                    @if($componentType === 'filters' && isset($component->flow_rate))
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                            {{ $component->flow_rate }} GPH
                        </td>
                    @endif
                    
                    @if(in_array($componentType, ['heaters', 'lights']) && isset($component->wattage))
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                            {{ $component->wattage }}W
                        </td>
                    @endif
                    
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 dark:border-gray-700">
                        @if($selectedItemId == $component->id)
                            <button wire:click="selectItem(null)" class="px-4 py-2 bg-red-500 text-white rounded">Remove</button>
                        @else
                            <button wire:click="selectItem({{ $component->id }})" class="px-4 py-2 bg-green-500 text-white rounded">
                                Select
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            
            @if(count($components) === 0)
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center border-b border-gray-200 dark:border-gray-700">
                        No components found matching your criteria.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $components->links() }}
    </div>
</div>
