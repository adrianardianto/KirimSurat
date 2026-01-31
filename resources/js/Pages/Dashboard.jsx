import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import Card from '@/Components/Card';
import Badge from '@/Components/Badge';

export default function Dashboard({ auth, stats, recent_surats }) {
    const userRole = auth.user.role;
    
    // Quick Stats Config
    const statsConfig = [
        {
            title: "Total Surat",
            value: stats.total_surat,
            icon: (
                <svg className="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            ),
            gradient: "from-blue-500 to-indigo-600",
            shadow: "shadow-blue-500/30"
        },
        {
            title: "Disetujui",
            value: stats.disetujui,
            icon: (
                <svg className="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            ),
            gradient: "from-emerald-400 to-green-600",
            shadow: "shadow-green-500/30"
        },
        {
            title: "Pending",
            value: stats.pending,
            icon: (
                <svg className="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            ),
            gradient: "from-amber-400 to-orange-500",
            shadow: "shadow-orange-500/30"
        }
    ];

    if (userRole === 'admin') {
        statsConfig.push({
            title: "Total User",
            value: stats.total_user,
            icon: (
                <svg className="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            ),
            gradient: "from-purple-500 to-pink-600",
            shadow: "shadow-purple-500/30"
        });
    }

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div className="py-6">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                    
                    {/* 1. Welcome Hero Section */}
                    <div className="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-900 via-indigo-900 to-purple-900 shadow-xl">
                        <div className="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                        <div className="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-indigo-500 opacity-20 rounded-full blur-3xl"></div>
                        
                        <div className="relative p-4 md:p-6 flex flex-col md:flex-row items-center justify-between z-10">
                            <div className="mb-3 md:mb-0 text-center md:text-left">
                                <h1 className="text-xl md:text-2xl font-bold text-white mb-1">
                                    Halo, <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-100">{auth.user.name.split(' ')[0]}!</span>
                                </h1>
                                <p className="text-indigo-200 text-xs md:text-sm max-w-xl">
                                    {userRole === 'admin' 
                                        ? 'Pantau aktivitas surat secara real-time' 
                                        : 'Pantau setiap tahap proses pengajuan surat secara real-time'}
                                </p>
                            </div>
                            
                            {userRole !== 'admin' && (
                                <Link href={route('surat.create')} className="group relative inline-flex items-center justify-center px-5 py-2 bg-white text-indigo-600 font-bold rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-indigo-500/20 active:scale-95 text-xs">
                                    <span className="absolute inset-0 bg-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                    <svg className="w-3.5 h-3.5 mr-1.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span className="relative z-10">Buat Surat Baru</span>
                                </Link>
                            )}
                            
                            {userRole === 'admin' && (
                                <div className="flex space-x-2">
                                     <Link href={route('users.index')} className="px-3 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-md text-white text-xs font-medium hover:bg-white/20 transition">
                                        Kelola User
                                    </Link>
                                    <Link href={route('surat.index')} className="px-3 py-1.5 bg-white text-indigo-900 rounded-md text-xs font-bold shadow-lg hover:bg-gray-50 transition">
                                        Lihat Semua
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* 2. Stats Cards */}
                    <div className={`grid grid-cols-1 md:grid-cols-2 ${userRole === 'admin' ? 'lg:grid-cols-4' : 'lg:grid-cols-3'} gap-6`}>
                        {statsConfig.map((stat, index) => (
                            <div key={index} className="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-300 flex items-center justify-between group">
                                <div>
                                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{stat.title}</p>
                                    <h3 className="text-3xl font-extrabold text-gray-900 dark:text-white group-hover:scale-105 transition-transform origin-left">{stat.value}</h3>
                                </div>
                                <div className={`w-14 h-14 rounded-2xl bg-gradient-to-br ${stat.gradient} flex items-center justify-center text-white shadow-lg ${stat.shadow} transform group-hover:rotate-6 transition-transform duration-300`}>
                                    {stat.icon}
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* 3. Main Content Area */}
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {/* Recent Activity List (Takes up full width now) */}
                        <div className="lg:col-span-3 space-y-6">
                            <div className="flex items-center justify-between">
                                <h2 className="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                                    <svg className="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Aktivitas Terbaru
                                </h2>
                                <Link href={route('surat.index')} className="group inline-flex items-center space-x-1 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all duration-300">
                                    <span>Lihat Semua</span>
                                    <svg className="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </Link>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                {recent_surats.length > 0 ? (
                                    <div className="divide-y divide-gray-100 dark:divide-gray-700">
                                        {recent_surats.map((surat) => (
                                            <div key={surat.id} className="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                                <div className="flex items-start justify-between">
                                                    <div className="flex items-start space-x-4">
                                                        <div className={`p-3 rounded-xl mt-1 flex-shrink-0 ${
                                                            surat.status === 'approved' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' :
                                                            surat.status === 'rejected' ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' :
                                                            'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400'
                                                        }`}>
                                                            {surat.status === 'approved' ? (
                                                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path></svg>
                                                            ) : surat.status === 'rejected' ? (
                                                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            ) : (
                                                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            )}
                                                        </div>
                                                        <div>
                                                            <div className="flex items-center space-x-2 mb-1">
                                                                <span className="text-xs font-bold px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                                                                    {surat.category?.name || 'Umum'}
                                                                </span>
                                                                <span className="text-xs text-gray-400">•</span>
                                                                <span className="text-xs text-gray-500 dark:text-gray-400">
                                                                    {new Date(surat.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                                                                </span>
                                                            </div>
                                                            <h4 className="text-base font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                                {surat.subject}
                                                            </h4>
                                                            <p className="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                                                                {userRole === 'admin' 
                                                                    ? `Dari: ${surat.sender} • User: ${surat.user?.name}`
                                                                    : `Kepada: ${surat.recipient} • Dari: ${surat.sender}`
                                                                }
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div className="flex flex-col items-end space-y-2">
                                                        <Badge color={surat.status === 'approved' ? 'success' : surat.status === 'pending' ? 'warning' : 'danger'}>
                                                            {surat.status.toUpperCase()}
                                                        </Badge>
                                                        <Link 
                                                            href={route('surat.show', surat.id)} 
                                                            className="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0"
                                                        >
                                                            Detail Surat
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="p-10 text-center flex flex-col items-center justify-center text-gray-500">
                                        <div className="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                             <svg className="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p className="text-lg font-medium">Belum ada aktivitas surat.</p>
                                        <p className="text-sm mt-1">Surat surat {userRole === 'admin' ? 'masuk' : 'Anda'} akan muncul di sini.</p>
                                    </div>
                                )}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
