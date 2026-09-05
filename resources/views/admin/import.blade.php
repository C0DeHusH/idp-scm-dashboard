<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Import Control</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Upload Latest Raw_Data.csv</label>
                        <input type="file" name="import_file" required class="border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <button type="submit" class="bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-gray-900">
                        Process and Update Network
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>