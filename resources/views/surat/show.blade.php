<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-t-xl border-b border-gray-100">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900"># {{ $surat->reference_number }}</h3>
                        <p class="text-sm text-gray-500">Dibuat pada {{ $surat->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <span
                            class="px-4 py-2 text-sm font-bold rounded-full 
                            @if ($surat->status == 'approved') bg-green-100 text-green-700
                            @elseif($surat->status == 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($surat->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-b-xl p-8 space-y-8">

                <!-- Main Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Perihal</label>
                            <p class="text-lg font-medium text-gray-900">{{ $surat->subject }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Kategori</label>
                            <p class="text-base text-gray-700">{{ $surat->category->name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Tipe</label>
                            <p class="text-base text-gray-700">{{ ucfirst($surat->type) }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Pengirim</label>
                            <p class="text-base text-gray-700">{{ $surat->sender }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Penerima</label>
                            <p class="text-base text-gray-700">{{ $surat->recipient }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Tanggal Surat</label>
                            <p class="text-base text-gray-700">{{ $surat->date->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <label class="text-xs font-semibold text-gray-400 uppercase">Isi / Keterangan</label>
                    <div class="mt-2 text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $surat->content ?: 'Tidak ada keterangan tambahan.' }}
                    </div>
                </div>

                @if ($surat->file_path)
                    <div class="border-t border-gray-100 pt-6">
                        <label class="text-xs font-semibold text-gray-400 uppercase">Lampiran</label>
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Lihat Lampiran
                            </a>
                        </div>
                    </div>
                @endif

                @if ($surat->status == 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
                        <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-bold text-green-800">Disetujui Oleh Admin</h4>
                            <p class="text-sm text-green-700 mt-1">
                                Oleh: {{ $surat->approver->name ?? 'System' }} <br>
                                Pada: {{ $surat->approved_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                @endif

                @if ($surat->status == 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start">
                        <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Ditolak</h4>
                            <p class="text-sm text-red-700 mt-1">
                                Oleh: {{ $surat->approver->name ?? 'System' }} <br>
                                Pada: {{ $surat->approved_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('surat.index') }}"
                        class="flex-1 text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Kembali
                    </a>

                    @if ($surat->status == 'pending' && Auth::user()->isAdmin())
                        <form action="{{ route('surat.approve', $surat) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full justify-center inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Setujui (Approve)
                            </button>
                        </form>
                        <form action="{{ route('surat.reject', $surat) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full justify-center inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Tolak (Reject)
                            </button>
                        </form>
                    @endif

                    @if ($surat->status == 'approved')
                        <a href="{{ route('surat.pdf', $surat) }}"
                            class="flex-1 justify-center inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Download PDF
                        </a>
                    @endif

                    @can('update', $surat)
                        <a href="{{ route('surat.edit', $surat) }}"
                            class="flex-1 justify-center inline-flex items-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Edit
                        </a>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
