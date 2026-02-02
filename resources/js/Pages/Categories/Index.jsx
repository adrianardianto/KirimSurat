import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';
import Badge from '@/Components/Badge';

export default function Index({ auth, categories }) {
    const { data, setData, post, put, processing, errors, reset, delete: destroy } = useForm({
        name: '',
        code: '',
        format_code: '',
        description: '',
    });

    const [isCreating, setIsCreating] = useState(false);
    const [editingCategory, setEditingCategory] = useState(null);

    const submit = (e) => {
        e.preventDefault();
        
        if (editingCategory) {
            put(route('categories.update', editingCategory.id), {
                onSuccess: () => {
                    handleCancel();
                },
            });
        } else {
            post(route('categories.store'), {
                onSuccess: () => {
                     handleCancel();
                },
            });
        }
    };
    
    // Handlers
    const handleEdit = (category) => {
        setEditingCategory(category);
        setData({
            name: category.name,
            code: category.code,
            format_code: category.format_code,
            description: category.description || '',
        });
        setIsCreating(true);
    };

    const handleCancel = () => {
        setIsCreating(false);
        setEditingCategory(null);
        reset();
    };

    const handleDelete = (id) => {
        if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            destroy(route('categories.destroy', id), {
                onSuccess: () => reset()
            });
        }
    }

    return (
        <AuthenticatedLayout>
            <Head title="Tipe Surat" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                    
                    <div className="flex justify-between items-center">
                        <div>
                            <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Tipe Surat</h2>
                            <p className="text-sm text-gray-500">Kelola kategori dan format penomoran surat.</p>
                        </div>
                        <PrimaryButton onClick={isCreating ? handleCancel : () => setIsCreating(true)}>
                            {isCreating ? 'Batal' : 'Tambah Tipe Baru'}
                        </PrimaryButton>
                    </div>

                    {isCreating && (
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                             <h3 className="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {editingCategory ? 'Edit Tipe Surat' : 'Tambah Tipe Surat Baru'}
                             </h3>
                             <form onSubmit={submit} className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel value="Nama Kategori" />
                                    <TextInput 
                                        value={data.name}
                                        onChange={e => setData('name', e.target.value)}
                                        className="w-full mt-1"
                                        placeholder="Contoh: Surat Izin"
                                    />
                                    <InputError message={errors.name} className="mt-2" />
                                </div>
                                <div>
                                    <InputLabel value="Kode Unik (Slug)" />
                                    <TextInput 
                                        value={data.code}
                                        onChange={e => setData('code', e.target.value)}
                                        className="w-full mt-1"
                                        placeholder="Contoh: izin"
                                    />
                                    <InputError message={errors.code} className="mt-2" />
                                </div>
                                <div>
                                    <InputLabel value="Format Kode Nomor" />
                                    <TextInput 
                                        value={data.format_code}
                                        onChange={e => setData('format_code', e.target.value)}
                                        className="w-full mt-1"
                                        placeholder="Contoh: IZN"
                                    />
                                     <p className="text-xs text-gray-500 mt-1">Akan muncul di nomor surat: 001/<b>IZN</b>/I/2024</p>
                                    <InputError message={errors.format_code} className="mt-2" />
                                </div>
                                <div>
                                    <InputLabel value="Deskripsi" />
                                    <TextInput 
                                        value={data.description}
                                        onChange={e => setData('description', e.target.value)}
                                        className="w-full mt-1"
                                    />
                                    <InputError message={errors.description} className="mt-2" />
                                </div>
                                <div className="md:col-span-2 flex justify-end">
                                    <PrimaryButton disabled={processing}>
                                        {editingCategory ? 'Simpan Perubahan' : 'Simpan Kategori'}
                                    </PrimaryButton>
                                </div>
                             </form>
                        </div>
                    )}

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                         <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Format</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Surat</th>
                                        <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {categories.map((category) => (
                                        <tr key={category.id}>
                                            <td className="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 font-medium">{category.name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-gray-500">{category.code}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <Badge color="blue">{category.format_code}</Badge>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-gray-500">{category.count} surat</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button 
                                                    onClick={() => handleEdit(category)}
                                                    className="text-indigo-600 hover:text-indigo-900 mr-4"
                                                >
                                                    Edit
                                                </button>
                                                <button 
                                                    onClick={() => handleDelete(category.id)}
                                                    className="text-red-600 hover:text-red-900"
                                                >
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                    {categories.length === 0 && (
                                        <tr>
                                            <td colSpan="5" className="px-6 py-4 text-center text-gray-500">Belum ada kategori surat.</td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
