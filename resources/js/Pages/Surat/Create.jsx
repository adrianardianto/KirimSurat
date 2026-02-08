import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SelectInput from '@/Components/SelectInput';

export default function Create({ auth, categories }) {
    const { data, setData, post, processing, errors } = useForm({
        type: 'surat_masuk',
        category_id: '',
        reference_number: '',
        date: new Date().toISOString().split('T')[0],
        sender: '',
        recipient: '',
        subject: '',
        content: '',
        file_attachment: null,
    });
    
    const [dragActive, setDragActive] = useState(false);

    React.useEffect(() => {
        if (data.category_id) {
            axios.get(route('surat.check-number'), {
                params: {
                    type: data.category_id
                }
            })
            .then(res => {
                setData('reference_number', res.data.number);
            })
            .catch(err => {
                console.error(err);
            });
        }
    }, [data.category_id]);

    const submit = (e) => {
        e.preventDefault();
        post(route('surat.store'));
    };

    const handleDrag = (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (e.type === "dragenter" || e.type === "dragover") {
            setDragActive(true);
        } else if (e.type === "dragleave") {
            setDragActive(false);
        }
    };

    const handleDrop = (e) => {
        e.preventDefault();
        e.stopPropagation();
        setDragActive(false);
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            setData('file_attachment', e.dataTransfer.files[0]);
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Buat Surat Baru" />

            <div className="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
                <div className="max-w-5xl mx-auto sm:px-6 lg:px-8">
                    
                    {/* Header Card */}
                    <div className="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-2xl shadow-lg p-8 mb-0 relative overflow-hidden">
                        <div className="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-xl"></div>
                        <div className="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white opacity-10 rounded-full blur-lg"></div>
                        
                        <div className="relative z-10 flex items-center justify-between">
                            <div className="flex items-center space-x-4">
                                <Link href={auth.user.role === 'admin' ? route('surat.index') : route('dashboard')} className="p-2 bg-white/20 rounded-full hover:bg-white/30 transition-colors backdrop-blur-sm">
                                    <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                </Link>
                                <div>
                                    <h2 className="text-3xl font-extrabold text-white tracking-tight">Buat Surat Baru</h2>
                                    <p className="text-indigo-100 mt-2 text-sm font-medium">Isi formulir di bawah ini untuk membuat arsip surat baru.</p>
                                </div>
                            </div>
                            <div className="hidden md:block p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg className="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-b-2xl border-t-0 border border-gray-100 dark:border-gray-700">
                        <div className="p-8">
                            <form onSubmit={submit} className="space-y-8 animate-fade-in-up">
                                
                                {/* Section 1: Detail Surat */}
                                <div>
                                    <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200 border-b pb-2 mb-6 border-gray-200 dark:border-gray-700 flex items-center">
                                        <svg className="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        Detail Surat
                                    </h3>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        
                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Kategori <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                </div>
                                                <SelectInput
                                                    className="pl-10 mt-1 block w-full border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm transition-all duration-200"
                                                    value={data.category_id}
                                                    onChange={(e) => setData('category_id', e.target.value)}
                                                >
                                                    <option value="">Pilih Kategori</option>
                                                    {categories.map((category) => (
                                                        <option key={category.id} value={category.id}>{category.name}</option>
                                                    ))}
                                                </SelectInput>
                                            </div>
                                            {errors.category_id && <div className="text-red-500 text-xs mt-1 font-medium">{errors.category_id}</div>}
                                        </div>

                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Nomor Surat <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                                </div>
                                                <TextInput
                                                    type="text"
                                                    className="pl-10 mt-1 block w-full rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                                                    value={data.reference_number}
                                                    readOnly
                                                    placeholder="Otomatis digenerate sistem..."
                                                />
                                            </div>
                                            <p className="text-xs text-gray-500 mt-1">Nomor surat akan dibuat otomatis berdasarkan kategori.</p>
                                            {errors.reference_number && <div className="text-red-500 text-xs mt-1 font-medium">{errors.reference_number}</div>}
                                        </div>

                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Tanggal Surat <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <TextInput
                                                    type="date"
                                                    className="pl-10 mt-1 block w-full rounded-lg cursor-pointer"
                                                    value={data.date}
                                                    onChange={(e) => setData('date', e.target.value)}
                                                />
                                            </div>
                                             {errors.date && <div className="text-red-500 text-xs mt-1 font-medium">{errors.date}</div>}
                                        </div>
                                    </div>
                                </div>

                                {/* Section 2: Informasi Pengiriman */}
                                <div>
                                    <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200 border-b pb-2 mb-6 border-gray-200 dark:border-gray-700 flex items-center">
                                         <svg className="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Informasi Pengiriman
                                    </h3>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Pengirim <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                                <TextInput
                                                    type="text"
                                                    className="pl-10 mt-1 block w-full rounded-lg"
                                                    value={data.sender}
                                                    onChange={(e) => setData('sender', e.target.value)}
                                                    placeholder="Nama Pengirim"
                                                />
                                            </div>
                                             {errors.sender && <div className="text-red-500 text-xs mt-1 font-medium">{errors.sender}</div>}
                                        </div>

                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Penerima <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <TextInput
                                                    type="text"
                                                    className="pl-10 mt-1 block w-full rounded-lg"
                                                    value={data.recipient}
                                                    onChange={(e) => setData('recipient', e.target.value)}
                                                    placeholder="Nama Penerima / Instansi"
                                                />
                                            </div>
                                             {errors.recipient && <div className="text-red-500 text-xs mt-1 font-medium">{errors.recipient}</div>}
                                        </div>
                                    </div>
                                </div>

                                {/* Section 3: Konten & Lampiran */}
                                <div>
                                    <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200 border-b pb-2 mb-6 border-gray-200 dark:border-gray-700 flex items-center">
                                         <svg className="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Konten & Lampiran
                                    </h3>
                                    
                                    <div className="space-y-6">
                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Perihal <span className="text-red-500">*</span></label>
                                             <div className="relative">
                                                 <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                 </div>
                                                <TextInput
                                                    type="text"
                                                    className="pl-10 mt-1 block w-full rounded-lg"
                                                    value={data.subject}
                                                    onChange={(e) => setData('subject', e.target.value)}
                                                    placeholder="Perihal Surat (Contoh: Undangan Rapat)"
                                                />
                                            </div>
                                             {errors.subject && <div className="text-red-500 text-xs mt-1 font-medium">{errors.subject}</div>}
                                        </div>

                                        <div className="group">
                                             <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Isi Ringkas <span className="text-red-500">*</span></label>
                                             <textarea
                                                className="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm transition-shadow duration-200 focus:shadow-md"
                                                rows="4"
                                                value={data.content}
                                                onChange={(e) => setData('content', e.target.value)}
                                                placeholder="Tuliskan isi ringkas surat di sini..."
                                             ></textarea>
                                              {errors.content && <div className="text-red-500 text-xs mt-1 font-medium">{errors.content}</div>}
                                        </div>

                                        <div className="group">
                                            <label className="block font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">File Lampiran (PDF/Image)</label>
                                            
                                            <div 
                                                className={`mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-all duration-300 ${dragActive ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 scale-[1.02]' : 'border-gray-300 dark:border-gray-700 hover:border-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800'}`}
                                                onDragEnter={handleDrag} 
                                                onDragLeave={handleDrag} 
                                                onDragOver={handleDrag} 
                                                onDrop={handleDrop}
                                            >
                                                <div className="space-y-1 text-center">
                                                    {data.file_attachment ? (
                                                        <div className="flex flex-col items-center">
                                                            <svg className="mx-auto h-12 w-12 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <p className="text-sm text-gray-600 dark:text-gray-400 mt-2 font-medium">{data.file_attachment.name}</p>
                                                            <button 
                                                                type="button" 
                                                                onClick={(e) => { e.preventDefault(); setData('file_attachment', null); }}
                                                                className="text-xs text-red-500 hover:underline mt-2"
                                                            >
                                                                Hapus File
                                                            </button>
                                                        </div>
                                                    ) : (
                                                        <>
                                                            <svg className={`mx-auto h-12 w-12 text-gray-400 ${dragActive ? 'text-indigo-500' : ''}`} stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                                                            </svg>
                                                            <div className="flex text-sm text-gray-600 dark:text-gray-400">
                                                                <label htmlFor="file-upload" className="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                    <span>Upload a file</span>
                                                                    <input id="file-upload" name="file-upload" type="file" className="sr-only" onChange={(e) => setData('file_attachment', e.target.files[0])} />
                                                                </label>
                                                                <p className="pl-1">or drag and drop</p>
                                                            </div>
                                                            <p className="text-xs text-gray-500 dark:text-gray-400">
                                                                PNG, JPG, PDF up to 2MB
                                                            </p>
                                                        </>
                                                    )}
                                                </div>
                                            </div>
                                             {errors.file_attachment && <div className="text-red-500 text-xs mt-1 font-medium">{errors.file_attachment}</div>}
                                        </div>
                                    </div>
                                </div>

                                <div className="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <PrimaryButton disabled={processing} className="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 rounded-lg text-lg shadow-lg transform transition hover:-translate-y-0.5">
                                        {processing ? (
                                            <span className="flex items-center">
                                                <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Menyimpan...
                                            </span>
                                        ) : (
                                            <span className="flex items-center">
                                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                                Simpan Surat
                                            </span>
                                        )}
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <style>{`
                @keyframes fade-in-up {
                    0% {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .animate-fade-in-up {
                    animation: fade-in-up 0.5s ease-out forwards;
                }
            `}</style>
        </AuthenticatedLayout>
    );
}
