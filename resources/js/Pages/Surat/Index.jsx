import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SelectInput from '@/Components/SelectInput';
import Badge from '@/Components/Badge';

export default function Index({ auth, surats, filters }) {
    const [search, setSearch] = useState(filters?.search || '');
    const [status, setStatus] = useState(filters?.status || '');
    const [startDate, setStartDate] = useState(filters?.startDate || '');
    const [endDate, setEndDate] = useState(filters?.endDate || '');

    const handleFilter = () => {
        router.get(route('surat.index'), { search, status, start_date: startDate, end_date: endDate }, { preserveState: true });
    };

    const handleReset = () => {
        setSearch('');
        setStatus('');
        setStartDate('');
        setEndDate('');
        router.get(route('surat.index'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Daftar Surat" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                    
                    {/* Header */}
                    <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            {auth.user.role !== 'admin' && (
                                <div className="mb-2">
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                    >
                                        <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                        Kembali
                                    </Link>
                                </div>
                            )}
                            <h2 className="text-2xl font-bold text-gray-900 dark:text-gray-100">Daftar Surat</h2>
                            <p className="text-gray-500 dark:text-gray-400">Kelola semua pengajuan surat masuk dan keluar dalam satu tempat.</p>
                        </div>
                        <div className="flex space-x-3">
                            {auth.user.role === 'admin' && (
                                <>
                                    <a 
                                        href={route('surat.export', { search, status, start_date: startDate, end_date: endDate })}
                                        className="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <svg className="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Excel
                                    </a>
                                    <a 
                                        href={route('surat.print', { search, status, start_date: startDate, end_date: endDate })}
                                        target="_blank"
                                        className="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <svg className="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Print Laporan
                                    </a>
                                </>
                            )}
                            <Link href={route('surat.create')}>
                                <PrimaryButton className="h-full">
                                    <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path></svg>
                                    Buat Surat Baru
                                </PrimaryButton>
                            </Link>
                        </div>
                    </div>

                    {/* Filter Section */}
                    {auth.user.role === 'admin' && (
                        <div className="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                            <div className="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                <div className="md:col-span-4">
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pencarian</label>
                                    <div className="relative">
                                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg className="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <TextInput 
                                            type="text" 
                                            className="pl-10 w-full" 
                                            placeholder="Cari surat..." 
                                            value={search}
                                            onChange={(e) => setSearch(e.target.value)}
                                        />
                                    </div>
                                </div>
                                
                                <div className="md:col-span-4">
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                                    <div className="flex space-x-2">
                                        <TextInput 
                                            type="date" 
                                            className="w-full" 
                                            value={startDate}
                                            onChange={(e) => setStartDate(e.target.value)}
                                        />
                                        <TextInput 
                                            type="date" 
                                            className="w-full" 
                                            value={endDate}
                                            onChange={(e) => setEndDate(e.target.value)}
                                        />
                                    </div>
                                </div>

                                <div className="md:col-span-2">
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <SelectInput 
                                        className="w-full"
                                        value={status}
                                        onChange={(e) => setStatus(e.target.value)}
                                    >
                                        <option value="">Semua</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </SelectInput>
                                </div>

                                <div className="md:col-span-2 flex space-x-2">
                                    <button 
                                        onClick={handleReset}
                                        className="w-full inline-flex justify-center items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        Reset
                                    </button>
                                    <button 
                                        onClick={handleFilter}
                                        className="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Table Section */}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Info Surat
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Pengirim & Penerima
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal ↓
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {surats.data.map((surat) => (
                                        <tr key={surat.id}>
                                            <td className="px-6 py-4">
                                                <Link href={route('surat.show', surat)} className="block text-sm font-bold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors mb-1">
                                                    {surat.reference_number}
                                                </Link>
                                                <div className="text-sm text-gray-700 dark:text-gray-300 mb-1">
                                                    {surat.subject}
                                                </div>
                                                <div className="flex space-x-1">
                                                    <span className="text-xs text-gray-500 font-semibold uppercase tracking-wider">
                                                        {surat.category?.name || 'UMUM'}
                                                    </span>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex flex-col text-sm">
                                                    <div className="flex">
                                                        <span className="w-16 text-gray-400 uppercase text-xs">Dari</span>
                                                        <span className="text-gray-900 dark:text-gray-100 font-medium">{surat.sender}</span>
                                                    </div>
                                                    <div className="flex">
                                                        <span className="w-16 text-gray-400 uppercase text-xs">Kepada</span>
                                                        <span className="text-gray-900 dark:text-gray-100 font-medium">{surat.recipient}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {new Date(surat.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                 <Badge color={surat.status === 'approved' ? 'success' : surat.status === 'pending' ? 'warning' : 'danger'}>
                                                    {surat.status.charAt(0).toUpperCase() + surat.status.slice(1)}
                                                </Badge>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div className="flex justify-end space-x-2">
                                                    <Link href={route('surat.show', surat)} className="p-2 bg-indigo-50 dark:bg-indigo-900 rounded-md text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100">
                                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </Link>
                                                    {surat.status === 'approved' && (
                                                        <a href={route('surat.pdf', surat)} className="p-2 bg-red-50 dark:bg-red-900 rounded-md text-red-600 dark:text-red-400 hover:bg-red-100" target="_blank">
                                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        </a>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                    {surats.data.length === 0 && (
                                        <tr>
                                            <td colSpan="5" className="px-6 py-4 text-center text-gray-500">
                                                Tidak ada data surat yang ditemukan.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                        {/* Pagination would go here */}
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
