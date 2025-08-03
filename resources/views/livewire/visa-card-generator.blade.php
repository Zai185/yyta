<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-xl rounded-lg p-6 w-full max-w-md">
        <div class="bg-blue-600 text-white rounded-lg p-5 mb-4 text-center">
            <h2 class="text-lg font-semibold">Visa Card Placeholder</h2>
            <p class="mt-3 text-2xl tracking-widest font-mono">{{ $cardNumber }}</p>
        </div>

        <button wire:click="generate"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition duration-200">
            Generate New Card
        </button>
    </div>
</div>
