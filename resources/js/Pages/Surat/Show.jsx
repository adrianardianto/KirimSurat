import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import Badge from '@/Components/Badge';
import Modal from '@/Components/Modal';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import SecondaryButton from '@/Components/SecondaryButton';
import DangerButton from '@/Components/DangerButton';

export default function Show({ auth, surat }) {
    const { post: approve, processing: approving } = useForm();
    
    // Form for rejection
    const { 
        data, 
        setData, 
        post: reject, 
        processing: rejecting, 
        errors, 
        reset 
    } = useForm({
        rejection_reason: '',
    });

    const [confirmingRejection, setConfirmingRejection] = useState(false);
    const [confirmingApproval, setConfirmingApproval] = useState(false);

    const handleApprove = () => {
        setConfirmingApproval(true);
    };

    const submitApprove = () => {
        approve(route('surat.approve', surat.id), {
            onFinish: () => setConfirmingApproval(false),
        });
    };

    const confirmRejection = () => {
        setConfirmingRejection(true);
    };

    const closeModal = () => {
        setConfirmingRejection(false);
        reset();
    };

    const handleReject = (e) => {
        e.preventDefault();

        reject(route('surat.reject', surat.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Surat ${surat.reference_number}`} />

            <div className="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
                <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    {/* Breadcrumb & Navigation */}
                    <div className="flex items-center justify-between mb-6">
                        <Link
                            href={auth.user.role === 'admin' ? route('surat.index') : route('dashboard')}
                            className="group inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors"
                        >
                            <div className="mr-2 p-1.5 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 group-hover:border-indigo-200 transition-colors">
                                <svg className="w-4 h-4 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </div>
                            Kembali ke Daftar
                        </Link>
                        
                        <div className="flex items-center space-x-3">
                            {(auth.user.role === 'admin' || (auth.user.id === surat.user_id && surat.status === 'pending')) && (
                                <Link
                                    href={route('surat.edit', surat.id)}
                                    className="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm mr-2"
                                >
                                    <svg className="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </Link>
                            )}
                            {auth.user.role === 'admin' && surat.status === 'pending' && (
                                <>
                                    <button 
                                        onClick={handleApprove}
                                        disabled={approving}
                                        className="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm disabled:opacity-50"
                                    >
                                        <svg className="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui
                                    </button>
                                    <button 
                                        onClick={confirmRejection}
                                        className="inline-flex items-center px-4 py-2 bg-rose-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-700 active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm"
                                    >
                                        <svg className="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </>
                            )}
                            {surat.status === 'approved' && (
                                 <a 
                                    href={route('surat.pdf', surat.id)} 
                                    target="_blank"
                                    className="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <svg className="w-4 h-4 mr-1.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Cetak PDF
                                </a>
                            )}
                        </div>
                    </div>

                    {/* Main Document Card */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden relative">
                         {/* Status Watermark/Badge */}
                         <div className="absolute top-0 right-0 p-6 z-10 pointer-events-none">
                            <Badge color={surat.status === 'approved' ? 'success' : surat.status === 'pending' ? 'warning' : 'danger'} className="text-sm px-3 py-1 shadow-sm">
                                {surat.status.toUpperCase()}
                            </Badge>
                        </div>

                         {/* Header Section */}
                        <div className="p-8 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                            <div className="max-w-2xl">
                                <p className="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1 tracking-wide uppercase">
                                    {surat.category?.name || 'Surat Umum'}
                                </p>
                                <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100 leading-tight mb-2">
                                    {surat.subject}
                                </h1>
                                <div className="flex items-center text-sm text-gray-500 dark:text-gray-400 font-mono">
                                    <span className="bg-gray-200 dark:bg-gray-700 px-2 py-0.5 rounded text-gray-700 dark:text-gray-300 mr-2">
                                        Ref: {surat.reference_number}
                                    </span>
                                    <span>• {new Date(surat.date).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
                                </div>
                            </div>
                        </div>

                        {/* Rejection Alert */}
                        {surat.status === 'rejected' && surat.rejection_reason && (
                            <div className="mx-8 mt-8 p-4 bg-red-50 dark:bg-red-900/10 border-l-4 border-red-500 rounded-r-md flex items-start">
                                <svg className="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <h3 className="text-sm font-bold text-red-800 dark:text-red-300">Surat Ditolak</h3>
                                    <p className="text-sm text-red-700 dark:text-red-400 mt-1">
                                        Alasan: <span className="font-medium italic">"{surat.rejection_reason}"</span>
                                    </p>
                                </div>
                            </div>
                        )}

                        <div className="flex flex-col md:flex-row">
                            {/* Left Content Column */}
                            <div className="flex-1 p-8 md:pr-12">
                                <div className="mb-8">
                                    <h3 className="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b dark:border-gray-700 pb-2">Konten Surat</h3>
                                    <div className="prose prose-indigo max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                        {surat.content}
                                    </div>
                                </div>
                            </div>

                            {/* Right Meta Column */}
                            <div className="w-full md:w-80 bg-gray-50 dark:bg-gray-900/50 p-8 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700">
                                
                                <div className="mb-8">
                                    <h3 className="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi</h3>
                                    <div className="space-y-4">
                                        <div>
                                            <p className="text-xs text-gray-500">Pengirim</p>
                                            <div className="flex items-center mt-1">
                                                <div className="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold mr-2">
                                                    {surat.sender.substring(0, 2).toUpperCase()}
                                                </div>
                                                <p className="font-medium text-gray-900 dark:text-gray-200">{surat.sender}</p>
                                            </div>
                                        </div>
                                        <div className="w-px h-8 bg-gray-200 ml-4"></div>
                                        <div>
                                            <p className="text-xs text-gray-500">Penerima</p>
                                            <div className="flex items-center mt-1">
                                                <div className="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold mr-2">
                                                    {surat.recipient.substring(0, 2).toUpperCase()}
                                                </div>
                                                <p className="font-medium text-gray-900 dark:text-gray-200">{surat.recipient}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 className="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Lampiran</h3>
                                    {surat.file_path && surat.file_path !== '0' ? (
                                        <div className="space-y-3">
                                            {['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(surat.file_path.split('.').pop().toLowerCase()) && (
                                                <div className="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
                                                    <img 
                                                        src={`/storage/${surat.file_path}`} 
                                                        alt="Lampiran Surat" 
                                                        className="w-full h-auto object-contain max-h-64 mx-auto"
                                                    />
                                                </div>
                                            )}
                                            
                                            <a href={`/storage/${surat.file_path}`} target="_blank" className="group flex items-center p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm hover:shadow-md hover:border-indigo-300 transition-all">
                                                <div className="p-2 bg-red-50 text-red-500 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                                     <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div className="overflow-hidden">
                                                    <p className="text-sm font-medium text-gray-900 dark:text-gray-200 truncate">Lihat Dokumen</p>
                                                    <p className="text-xs text-gray-500 truncate">Klik untuk membuka</p>
                                                </div>
                                            </a>
                                        </div>
                                    ) : (
                                        <div className="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-center border border-dashed border-gray-300">
                                            <p className="text-xs text-gray-500 italic">Tidak ada lampiran</p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Footer / Actions for Quick Access */}
                         <div className="bg-gray-50 dark:bg-gray-900/80 px-8 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <p className="text-xs text-gray-400">Dibuat pada {new Date(surat.created_at).toLocaleString('id-ID')}</p>
                         </div>
                    </div>

                </div>
            </div>

            <Modal show={confirmingRejection} onClose={closeModal}>
                <form onSubmit={handleReject} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Tolak Surat Ini?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Silakan masukkan alasan penolakan surat ini. Alasan ini akan disimpan dan dapat dilihat oleh pembuat surat.
                    </p>

                    <div className="mt-6">
                        <InputLabel htmlFor="rejection_reason" value="Alasan Penolakan" className="sr-only" />

                        <TextInput
                            id="rejection_reason"
                            type="text"
                            name="rejection_reason"
                            value={data.rejection_reason}
                            onChange={(e) => setData('rejection_reason', e.target.value)}
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="Alasan ditolak..."
                        />

                        <InputError message={errors.rejection_reason} className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>
                            Batal
                        </SecondaryButton>

                        <DangerButton className="ml-3" disabled={rejecting}>
                            Tolak Surat
                        </DangerButton>
                    </div>
                </form>
            </Modal>

            <Modal show={confirmingApproval} onClose={() => setConfirmingApproval(false)}>
                <div className="p-6">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Setujui Surat Ini?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Apakah Anda yakin ingin menyetujui surat ini? Tindakan ini akan mengubah status surat menjadi <strong>Disetujui</strong>.
                    </p>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={() => setConfirmingApproval(false)}>
                            Batal
                        </SecondaryButton>

                        <button
                            onClick={submitApprove}
                            disabled={approving}
                            className="ml-3 inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:border-emerald-900 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                           {approving ? 'Memproses...' : 'Ya, Setujui'}
                        </button>
                    </div>
                </div>
            </Modal>
        </AuthenticatedLayout>
    );
}
