<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos Registrados') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg justify-items-center">
                <x-create-product></x-create-product>
                <table class="border-separate border border-gray-400 w-full ...">
                    <thead>
                      <tr>
                        <th class="border border-gray-300 ...">Name</th>
                        <th class="border border-gray-300 ...">Description</th>
                        <th class="border border-gray-300 ...">Price</th>
                        <th class="border border-gray-300 ...">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                          <td class="border border-gray-300 ...">{{ $product->name }}</td>
                          <td class="border border-gray-300 ...">{{ $product->description }}</td>
                          <td class="border border-gray-300 ...">{{ $product->price }}</td>
                          <td class="border border-gray-300 text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="text-black py-2 px-4 rounded-full shadow-lg">Editar</button>
                                <button class="text-black py-2 px-4 rounded-full shadow-lg">Borrar</button>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>


