import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SelectInput from '@/Components/SelectInput';

export default function Edit({ auth, surat, categories }) {
     const { data, setData, put, processing, errors } = useForm({
        type: surat.type,
        category_id: surat.category_id,
        reference_number: surat.reference_number,
        date: surat.date,
        sender: surat.sender,
        recipient: surat.recipient,
        subject: surat.subject,
        content: surat.content,
        file_attachment: null, // Don't prefill file
    });

    const submit = (e) => {
        e.preventDefault();
        // Use post with _method: put for file uploads if needed, but here simple PUT might work if no file
        // However, Inertia + Laravel file upload usually requires POST with _method: 'PUT'
        // But useForm's put method handles JSON usually. 
        // For file uploads in update (PUT/PATCH), Laravel requires POST with _method field.
        // Inertia's router.post(url, { ...data, _method: 'put' }) is the way.
        // But useForm helper:
        // const { post } = useForm({...}); post(url, { _method: 'put' }); ??
        
        // Actually, let's try router.post with FormData override logic inside useForm?
        // useForm has a 'transform' method if needed.
        
        // Simplest compliant way for file upload on update:
        // Use POST method effectively.
        
        // Let's use the router manually for this one specific case or just post to a specific update route that allows POST?
        // Standard Resource route expects PUT/PATCH.
        // Inertia `router.post(url, { ...data, _method: 'put' })`
        
        // Wait, the `put` helper from `useForm` sends JSON. File uploads won't work with JSON.
        // So we must use `post` and spoof method.
        
    };
    
    // Workaround for file upload with PUT in Laravel/Inertia
    // We re-initialize form with post method but target the update url with method spoofing
    const { data: formData, setData: setFormData, post: postForm, processing: formProcessing, errors: formErrors } = useForm({
        _method: 'PUT',
        type: surat.type,
        category_id: surat.category_id,
        reference_number: surat.reference_number,
        date: surat.date,
        sender: surat.sender,
        recipient: surat.recipient,
        subject: surat.subject,
        content: surat.content,
        file_attachment: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        postForm(route('surat.update', surat.id));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Surat" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                             <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Edit Surat</h2>

                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {/* Left Column */}
                                    <div className="space-y-6">


                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Kategori</label>
                                            <SelectInput
                                                className="mt-1 block w-full"
                                                value={formData.category_id}
                                                onChange={(e) => setFormData('category_id', e.target.value)}
                                            >
                                                <option value="">Pilih Kategori</option>
                                                {categories.map((category) => (
                                                    <option key={category.id} value={category.id}>{category.name}</option>
                                                ))}
                                            </SelectInput>
                                            {formErrors.category_id && <div className="text-red-500 text-sm mt-1">{formErrors.category_id}</div>}
                                        </div>

                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Nomor Surat <span className="text-red-500">*</span></label>
                                            <div className="relative">
                                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg className="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                                </div>
                                                <TextInput
                                                    type="text"
                                                    className="pl-10 mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-500 cursor-not-allowed"
                                                    value={formData.reference_number}
                                                    readOnly
                                                    placeholder="Otomatis digenerate sistem..."
                                                />
                                            </div>
                                            <p className="text-xs text-gray-500 mt-1">Nomor surat tidak dapat diubah (Otomatis dari sistem).</p>
                                            {formErrors.reference_number && <div className="text-red-500 text-sm mt-1">{formErrors.reference_number}</div>}
                                        </div>

                                         <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal</label>
                                            <TextInput
                                                type="date"
                                                className="mt-1 block w-full"
                                                value={formData.date}
                                                onChange={(e) => setFormData('date', e.target.value)}
                                            />
                                             {formErrors.date && <div className="text-red-500 text-sm mt-1">{formErrors.date}</div>}
                                        </div>
                                    </div>

                                    {/* Right Column */}
                                    <div className="space-y-6">
                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Pengirim</label>
                                            <TextInput
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={formData.sender}
                                                onChange={(e) => setFormData('sender', e.target.value)}
                                            />
                                             {formErrors.sender && <div className="text-red-500 text-sm mt-1">{formErrors.sender}</div>}
                                        </div>

                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Penerima</label>
                                            <TextInput
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={formData.recipient}
                                                onChange={(e) => setFormData('recipient', e.target.value)}
                                            />
                                             {formErrors.recipient && <div className="text-red-500 text-sm mt-1">{formErrors.recipient}</div>}
                                        </div>

                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Perihal</label>
                                            <TextInput
                                                type="text"
                                                className="mt-1 block w-full"
                                                value={formData.subject}
                                                onChange={(e) => setFormData('subject', e.target.value)}
                                            />
                                             {formErrors.subject && <div className="text-red-500 text-sm mt-1">{formErrors.subject}</div>}
                                        </div>

                                        <div>
                                            <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Ubah File Lampiran (Opsional)</label>
                                            <input
                                                type="file"
                                                className="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                                onChange={(e) => setFormData('file_attachment', e.target.files[0])}
                                            />
                                             {formErrors.file_attachment && <div className="text-red-500 text-sm mt-1">{formErrors.file_attachment}</div>}
                                             {surat.file_path && (
                                                 <p className="text-xs text-gray-500 mt-1">File saat ini: {surat.file_path}</p>
                                             )}
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                     <label className="block font-medium text-sm text-gray-700 dark:text-gray-300">Isi Ringkas</label>
                                     <textarea
                                        className="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="3"
                                        value={formData.content}
                                        onChange={(e) => setFormData('content', e.target.value)}
                                     ></textarea>
                                      {formErrors.content && <div className="text-red-500 text-sm mt-1">{formErrors.content}</div>}
                                </div>

                                <div className="flex items-center justify-end">
                                    <PrimaryButton disabled={formProcessing}>
                                        Simpan Perubahan
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
