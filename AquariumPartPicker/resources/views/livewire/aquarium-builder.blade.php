<div>
    <h3 class="text-lg font-medium mb-4">Select your aquarium components</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <!-- Categories and product selection will go here -->
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <h4 class="font-medium mb-2">Tank</h4>
                <p class="text-gray-500 dark:text-gray-400">Select a tank to begin your build</p>
                <!-- Tank selection will go here -->
            </div>

            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                <h4 class="font-medium mb-2">Filter</h4>
                <p class="text-gray-500 dark:text-gray-400">Choose a filter for your aquarium</p>
                <!-- Filter selection will go here -->
            </div>

            <!-- Add more component categories as needed -->
        </div>

        <div>
            <!-- Build summary will go here -->
            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow sticky top-4">
                <h4 class="font-medium mb-4">Your Build</h4>
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
            </div>
        </div>
    </div>
</div>
