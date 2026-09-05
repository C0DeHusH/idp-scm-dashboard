<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $manpower->name }} - SCM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        
        <div class="flex-1 flex flex-col h-screen overflow-y-auto w-full">
            
            <header class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-6 z-10 transition-colors duration-200">
                <div class="flex items-center space-x-4 flex-1">
                    <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                        Manpower & Personnel Registry
                    </h1>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <a href="{{ route('manpower.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                        &larr; Back to Registry
                    </a>
                </div>
            </header>

            <div class="w-full max-w-4xl mx-auto py-10 px-6 sm:px-8">
                
                <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight">Edit Personnel Record</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Updating profile details for <strong>{{ $manpower->name }}</strong>.</p>
                    </div>
                    
                    <!-- Delete Action Hook -->
                    <form action="{{ route('manpower.destroy', $manpower->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to completely remove this personnel record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Remove Record
                        </button>
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-xl rounded-2xl overflow-hidden transition-all p-6 sm:p-10">
                    <form action="{{ route('manpower.update', $manpower->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $manpower->name) }}" 
                                    class="w-full bg-gray-50 dark:bg-gray-900 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror text-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm transition-colors" required>
                                @error('name')
                                    <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Section / Department -->
                            <div>
                                <label for="section" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Section / Department <span class="text-red-500">*</span></label>
                                <input type="text" name="section" id="section" value="{{ old('section', $manpower->section) }}" 
                                    class="w-full bg-gray-50 dark:bg-gray-900 border @error('section') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror text-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm transition-colors" required>
                                @error('section')
                                    <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Position / Title <span class="text-red-500">*</span></label>
                                <input type="text" name="position" id="position" value="{{ old('position', $manpower->position) }}" 
                                    class="w-full bg-gray-50 dark:bg-gray-900 border @error('position') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror text-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm transition-colors" required>
                                @error('position')
                                    <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Current Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status" 
                                    class="w-full md:w-1/2 bg-gray-50 dark:bg-gray-900 border @error('status') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror text-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 shadow-sm transition-colors" required>
                                    <option value="Active" {{ old('status', $manpower->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="On Leave" {{ old('status', $manpower->status) == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="Inactive" {{ old('status', $manpower->status) == 'Inactive' ? 'selected' : '' }}>Inactive / Resigned</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 mt-8">
                            <a href="{{ route('manpower.index') }}" class="w-full sm:w-auto bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-semibold py-2.5 px-6 rounded-lg text-center shadow-sm transition-colors duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition-colors duration-150 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>