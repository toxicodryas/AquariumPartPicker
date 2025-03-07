<div>
    <div class="mb-4">
        <input wire:model.debounce.300ms="searchQuery" type="text" placeholder="Search components..." class="px-4 py-2 border rounded">

        <div class="mt-2">
            <button wire:click="setComponentType('tanks')" class="px-4 py-2 {{ $componentType === 'tanks' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
                Tanks
            </button>
            <button wire:click="setComponentType('filters')" class="px-4 py-2 {{ $componentType === 'filters' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
                Filters
            </button>
            <button wire:click="setComponentType('lights')" class="px-4 py-2 {{ $componentType === 'lights' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
                Lights
            </button>
            <button wire:click="setComponentType('heaters')" class="px-4 py-2 {{ $componentType === 'heaters' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
                Heaters
            </button>
        </div>
    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Image
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                    Name
                    @if($sortField === 'name')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('brand')">
                    Brand
                    @if($sortField === 'brand')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('price')">
                    Price
                    @if($sortField === 'price')
                        @if($sortDirection === 'asc') ↑ @else ↓ @endif
                    @endif
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        <img src="{{ $component->image_url ?? 'https://via.placeholder.com/50' }}" alt="{{ $component->name }}" class="h-10 w-10 object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        {{ $component->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        {{ $component->brand }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        ${{ number_format($component->price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        <button class="px-4 py-2 bg-green-500 text-white rounded">Add to Build</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $components->links() }}
    </div>
</div>
