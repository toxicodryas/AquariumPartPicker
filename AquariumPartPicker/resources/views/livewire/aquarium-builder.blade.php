<div>
    <h3 class="text-lg font-medium mb-4">Select your aquarium components</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <!-- Display component types using the PartBrowser component -->
            @foreach ($componentTypes as $type)
                @livewire('part-browser', [
                    'componentType' => $type, 
                    'selectedItemId' => $selectedParts[$type] ?? null
                ], key('component-'.$type))
            @endforeach
        </div>
        
        <div>
            <!-- Build summary -->
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow sticky top-4">
                <h4 class="font-medium mb-4">Your Build</h4>
                
                @php
                    $hasSelectedItems = false;
                    foreach ($selectedParts as $itemId) {
                        if ($itemId) {
                            $hasSelectedItems = true;
                            break;
                        }
                    }
                @endphp
                
                @if ($hasSelectedItems)
                    <div class="space-y-3">
                        @foreach ($componentTypes as $type)
                            @if (!empty($selectedParts[$type]))
                                @php
                                    $item = $this->getSelectedItem($type);
                                @endphp
                                
                                @if ($item)
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="font-medium">{{ $item->name }}</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $this->getComponentTitle($type) }}
                                            </p>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span>${{ number_format($item->price ?? 0, 2) }}</span>
                                            <button 
                                                wire:click="removePart('{{ $type }}')"
                                                class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <p class="flex justify-between font-medium">
                            <span>Total:</span>
                            <span>${{ number_format($totalPrice, 2) }}</span>
                        </p>
                    </div>
                    
                    <button wire:click="saveBuild" type="button" class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Save Build
                    </button>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No components selected yet</p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <p class="flex justify-between">
                            <span>Total:</span>
                            <span>$0.00</span>
                        </p>
                    </div>
                    
                    <button type="button" class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50" disabled>
                        Save Build
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
