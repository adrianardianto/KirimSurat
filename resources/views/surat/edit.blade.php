<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700" role="alert">
                            <p class="font-bold">Oops! Ada kesalahan.</p>
                            <ul class="list-disc pl-5 mt-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.update', $surat) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Surat -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Surat</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <select name="type"
                                        class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                        <option value="izin" {{ $surat->type == 'izin' ? 'selected' : '' }}>Surat Izin
                                            Tidak Masuk</option>
                                        <option value="dispensasi" {{ $surat->type == 'dispensasi' ? 'selected' : '' }}>
                                            Pengajuan Dispensasi</option>
                                        <option value="sakit" {{ $surat->type == 'sakit' ? 'selected' : '' }}>Surat
                                            Keterangan Sakit</option>
                                        <option value="beasiswa" {{ $surat->type == 'beasiswa' ? 'selected' : '' }}>
                                            Pengajuan Beasiswa</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Kategori (Hidden) -->
                            <input type="hidden" name="category_id" value="{{ $surat->category_id }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nomor Surat -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Surat (Referensi)</label>
                                <input type="text" name="reference_number"
                                    value="{{ old('reference_number', $surat->reference_number) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                                <input type="date" name="date"
                                    value="{{ old('date', $surat->date->format('Y-m-d')) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pengirim -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pengirim</label>
                                <input type="text" name="sender" value="{{ old('sender', $surat->sender) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Penerima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penerima</label>
                                <input type="text" name="recipient"
                                    value="{{ old('recipient', $surat->recipient) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perihal / Subjek</label>
                            <input type="text" name="subject" value="{{ old('subject', $surat->subject) }}"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Isi Ringkas / Keterangan</label>
                            <div class="mt-1">
                                <textarea name="content" rows="4"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('content', $surat->content) }}</textarea>
                            </div>
                        </div>

                        <!-- File Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ganti Lampiran (Opsional)</label>
                            @if ($surat->file_path)
                                <p class="text-xs text-gray-500 mb-2">File saat ini: <a
                                        href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat File</a></p>
                            @endif
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
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
                                            <span>Upload a new file</span>
                                            <input id="file-upload" name="file_attachment" type="file"
                                                class="sr-only">
                                        </label>
                                        <p class="pl-1">to replace</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-5">
                            @can('delete', $surat)
                                <button type="button" onclick="document.getElementById('delete-form').submit()"
                                    class="text-red-600 hover:text-red-900 font-medium text-sm">
                                    Hapus Surat
                                </button>
                            @else
                                <div></div>
                            @endcan

                            <div class="flex items-center">
                                <a href="{{ route('surat.show', $surat) }}"
                                    class="mr-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('surat.destroy', $surat) }}" method="POST" class="hidden"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini? Data tidak bisa dikembalikan.');">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('file-upload').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.closest('div').querySelector('p.text-xs');
            label.textContent = "Selected: " + fileName;
            label.classList.add('text-green-600', 'font-bold');
        });
    </script>
</x-app-layout>
