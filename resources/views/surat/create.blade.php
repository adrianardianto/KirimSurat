<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Buat Surat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8 bg-white border-b border-gray-200">



                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Surat -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Surat <span
                                        class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <select name="type" id="typeSelect"
                                        class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 @error('type') border-red-500 bg-red-50 @enderror">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->code }}" data-id="{{ $category->id }}"
                                                {{ old('type') == $category->code ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori ID (Updated via JS) -->
                            <input type="hidden" name="category_id" id="categoryId"
                                value="{{ old('category_id', $categories->first()->id ?? '') }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nomor Surat -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Surat (Otomatis) <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="reference_number"
                                    class="mt-1 bg-gray-100 text-gray-600 cursor-not-allowed focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('reference_number') border-red-500 bg-red-50 @enderror"
                                    placeholder="Generating..." readonly>
                                @error('reference_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Surat <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="date"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('date') border-red-500 bg-red-50 @enderror"
                                    value="{{ date('Y-m-d') }}">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pengirim -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pengirim <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="sender"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('sender') border-red-500 bg-red-50 @enderror"
                                    placeholder="Nama Siswa">
                                @error('sender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Penerima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penerima <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="recipient"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('recipient') border-red-500 bg-red-50 @enderror"
                                    placeholder="Nama Guru/ Sekolah">
                                @error('recipient')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perihal / Subjek <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="subject"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('subject') border-red-500 bg-red-50 @enderror"
                                placeholder="Ringkasan isi surat...">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Isi Ringkas / Keterangan <span
                                    class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <textarea name="content" rows="4"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('content') border-red-500 bg-red-50 @enderror"
                                    placeholder="Deskripsi tambahan..."></textarea>
                            </div>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lampiran File (PDF/Gambar - Max
                                2MB) <span class="text-red-500">*</span></label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors @error('file_attachment') border-red-500 bg-red-50 @enderror">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file_attachment" type="file"
                                                class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                            @error('file_attachment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end pt-5">
                            <a href="{{ route('surat.index') }}"
                                class="mr-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple file upload filename display
        document.getElementById('file-upload').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.closest('div').querySelector('p.text-xs');
            label.textContent = "Selected: " + fileName;
            label.classList.add('text-green-600', 'font-bold');
        });

        // Dynamic Numbering Script
        const typeSelect = document.getElementById('typeSelect');
        const categoryInput = document.getElementById('categoryId');
        const numberInput = document.querySelector('input[name="reference_number"]');

        function updateCategoryAndFetch() {
            // Get selected option
            const selectedOption = typeSelect.options[typeSelect.selectedIndex];
            const catId = selectedOption.getAttribute('data-id');
            const typeCode = typeSelect.value;

            // Update hidden input
            if (catId) categoryInput.value = catId;

            if (!typeCode) return;

            // Show loading
            numberInput.value = "Generating...";

            // Use type only (controller looks up code)
            fetch(`{{ route('surat.check-number') }}?type=${typeCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.number) {
                        numberInput.value = data.number;
                    } else {
                        numberInput.value = "";
                        numberInput.placeholder = "Error generating number";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    numberInput.value = "";
                });
        }

        // Listeners
        typeSelect.addEventListener('change', updateCategoryAndFetch);

        // Initial fetch on load if values exist
        if (typeSelect.value) {
            updateCategoryAndFetch();
        }
    </script>
</x-app-layout>
