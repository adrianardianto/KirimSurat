<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Surat Masuk</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['surat_masuk'] }}</p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-30 p-3 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                    </div>
                </div>



                <div
                    class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending Approval</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-yellow-300 bg-opacity-30 p-3 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->isAdmin())
                    <div
                        class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Total Users</p>
                                <p class="text-3xl font-bold mt-1">{{ $stats['users'] ?? 0 }}</p>
                            </div>
                            <div class="bg-green-300 bg-opacity-30 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activities (Audit Log) -->
                @if (Auth::user()->isAdmin())
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div
                            class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">Recent Activities</h3>
                            <span
                                class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">Live</span>
                        </div>
                        <div class="p-0">
                            @forelse($recent_logs as $log)
                                <div
                                    class="p-4 border-b last:border-0 border-gray-50 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex gap-4">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold shrink-0">
                                            {{ substr($log->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $log->action }}</p>
                                            <p class="text-xs text-gray-500">{{ $log->description }} by <span
                                                    class="font-medium text-gray-700 dark:text-gray-300">{{ $log->user->name ?? 'Unknown' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $log->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-gray-500 text-sm">No recent activities.</div>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Recent Letters -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 {{ Auth::user()->isAdmin() ? '' : 'lg:col-span-2' }}">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">Recent Letters</h3>
                        <a href="{{ route('surat.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 hover:underline">View All &rarr;</a>
                    </div>
                    <div class="p-0">
                        @forelse($recent_surats as $surat)
                            <div
                                class="p-4 flex items-center justify-between border-b last:border-0 border-gray-50 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                <div class="flex gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full {{ $surat->type == 'masuk' ? 'bg-emerald-100 text-emerald-600' : 'bg-sky-100 text-sky-600' }} flex items-center justify-center shrink-0">
                                        @if ($surat->type == 'masuk')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 transition-colors">
                                            {{ $surat->subject }}</p>
                                        <p class="text-xs text-gray-500">{{ $surat->reference_number }} •
                                            {{ $surat->date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if ($surat->status == 'approved') bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300
                                    @elseif($surat->status == 'rejected') bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300
                                    @else bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300 @endif
                                ">
                                        {{ ucfirst($surat->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <p class="text-gray-500 mb-2">Belum ada surat.</p>
                                <a href="{{ route('surat.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Buat Surat Baru
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
