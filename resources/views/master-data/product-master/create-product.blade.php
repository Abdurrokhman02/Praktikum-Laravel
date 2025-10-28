<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Product') }}
        </h2>
    </x-slot>

    <div class="container p-6 mx-auto bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('product-store') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="product_name" :value="__('Product Name')" />
                <x-text-input id="product_name" class="block w-full mt-1" type="text" name="product_name" :value="old('product_name')" required autofocus />
                <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="unit" :value="__('Unit')" />
                <x-text-input id="unit" class="block w-full mt-1" type="text" name="unit" :value="old('unit')" required />
                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="type" :value="__('Type')" />
                <x-text-input id="type" class="block w-full mt-1" type="text" name="type" :value="old('type')" required />
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="information" :value="__('Information')" />
                <textarea id="information" name="information" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('information') }}</textarea>
                <x-input-error :messages="$errors->get('information')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="qty" :value="__('Quantity')" />
                <x-text-input id="qty" class="block w-full mt-1" type="number" name="qty" :value="old('qty')" required />
                <x-input-error :messages="$errors->get('qty')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="producer" :value="__('Producer')" />
                <x-text-input id="producer" class="block w-full mt-1" type="text" name="producer" :value="old('producer')" required />
                <x-input-error :messages="$errors->get('producer')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="ms-3">
                    {{ __('Create Product') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        @if ($errors->any())
            let errorMessages = @json($errors->all());
            
            let alertMessage = "Terdapat kesalahan:\n- " + errorMessages.join("\n- ");
            alert(alertMessage);
        @endif
    </script>
</x-app-layout>