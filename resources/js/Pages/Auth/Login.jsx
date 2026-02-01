import React, { useEffect, useState } from 'react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('login'));
    };

    return (
        <div className="min-h-screen flex bg-gray-50 dark:bg-gray-900 overflow-hidden relative">
            <Head title="Log in" />

            {/* Mobile Background Gradient */}
            <div className="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 lg:hidden z-0">
                <div className="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] bg-purple-500 rounded-full blur-[100px] opacity-40 animate-pulse"></div>
                <div className="absolute bottom-[-10%] left-[-10%] w-[60%] h-[60%] bg-indigo-500 rounded-full blur-[100px] opacity-40 animate-pulse" style={{ animationDelay: '2s' }}></div>
            </div>

            {/* Left Side - Visual & Branding (Desktop Only) */}
            <div className="hidden lg:flex w-1/2 relative bg-gradient-to-br from-indigo-600 to-purple-700 items-center justify-center overflow-hidden z-10">
                <div className="absolute top-0 left-0 w-full h-full opacity-20">
                     <div className="absolute top-[-20%] left-[-20%] w-[50%] h-[50%] bg-white rounded-full blur-[100px] animate-pulse"></div>
                     <div className="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] bg-purple-400 rounded-full blur-[120px] animate-pulse" style={{ animationDelay: '2s' }}></div>
                </div>

                <div className="relative z-10 p-12 text-white max-w-lg text-center">
                    <div className="mb-8 flex justify-center">
                         <div className="w-24 h-24 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center shadow-2xl border border-white/20 transform hover:scale-110 transition-transform duration-500">
                            <svg className="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                         </div>
                    </div>
                    <h1 className="text-5xl font-bold mb-6 tracking-tight drop-shadow-lg">KirimSurat</h1>
                    <p className="text-lg text-indigo-50 leading-relaxed font-light">
                        Platform manajemen surat menyurat yang efisien, modern, dan terintegrasi. 
                        Kelola arsip anda dengan mudah.
                    </p>
                    <div className="mt-12 flex flex-wrap gap-4 justify-center">
                         <div className="px-5 py-2 bg-white/10 rounded-full backdrop-blur-sm border border-white/10 text-sm font-medium hover:bg-white/20 transition cursor-default">✨ Super Cepat</div>
                         <div className="px-5 py-2 bg-white/10 rounded-full backdrop-blur-sm border border-white/10 text-sm font-medium hover:bg-white/20 transition cursor-default">🛡️ Aman Terenkripsi</div>
                    </div>
                </div>
            </div>

            {/* Right Side / Mobile Container */}
            <div className="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 relative z-10 bg-transparent lg:bg-white lg:dark:bg-gray-900"> 
                
                <div className="w-full max-w-md">
                    {/* Mobile Branding */}
                    <div className="lg:hidden text-center mb-8 animate-fade-in-up">
                         <div className="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl shadow-xl mb-4 text-white border border-white/20">
                             <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                         </div>
                         <h1 className="text-3xl font-bold text-white tracking-tight drop-shadow-md">KirimSurat</h1>
                    </div>

                    {/* Card Container (Glassmorphism on Mobile, Clean on Desktop) */}
                    <div className="bg-white/90 dark:bg-gray-800/95 backdrop-blur-xl lg:backdrop-blur-none lg:bg-transparent lg:dark:bg-transparent rounded-3xl shadow-2xl lg:shadow-none p-8 lg:p-0 animate-fade-in-up border border-white/20 lg:border-none">
                        
                        {status && (
                            <div className="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative role='alert'">
                                <span className="block sm:inline">{status}</span>
                            </div>
                        )}

                        <div className="text-center lg:text-left mb-8">
                            <h2 className="text-2xl lg:text-3xl font-extrabold text-gray-900 dark:text-white">Selamat Datang</h2>
                            <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Masukkan detail akun anda untuk masuk
                            </p>
                        </div>

                        <form onSubmit={submit} className="space-y-6">
                            <div className="space-y-5">
                                <div className="relative group">
                                    <label htmlFor="email" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 pl-1">Email</label>
                                    <div className="relative">
                                        <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg className="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                        </div>
                                        <TextInput
                                            id="email"
                                            type="email"
                                            name="email"
                                            value={data.email}
                                            className="pl-11 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm transition-all py-3"
                                            autoComplete="username"
                                            isFocused={true}
                                            onChange={(e) => setData('email', e.target.value)}
                                            placeholder="nama@email.com"
                                        />
                                    </div>
                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                <div className="relative group">
                                    <label htmlFor="password" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 pl-1">Password</label>
                                    <div className="relative">
                                        <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg className="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                        <TextInput
                                            id="password"
                                            type={showPassword ? "text" : "password"}
                                            name="password"
                                            value={data.password}
                                            className="pl-11 pr-11 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm transition-all py-3"
                                            autoComplete="current-password"
                                            onChange={(e) => setData('password', e.target.value)}
                                            placeholder="••••••••"
                                        />
                                        <button 
                                            type="button" 
                                            className="absolute inset-y-0 right-0 pr-4 flex items-center focus:outline-none"
                                            onClick={() => setShowPassword(!showPassword)}
                                        >
                                            {showPassword ? (
                                                 <svg className="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                            ) : (
                                                <svg className="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            )}
                                        </button>
                                    </div>
                                    <InputError message={errors.password} className="mt-2" />
                                </div>
                            </div>

                            <div className="flex items-center justify-between">
                                <div className="flex items-center">
                                    <Checkbox
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) => setData('remember', e.target.checked)}
                                        className="text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded w-4 h-4"
                                    />
                                    <span className="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                                </div>

                                {canResetPassword && (
                                    <Link
                                        href={route('password.request')}
                                        className="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                                    >
                                        Lupa password?
                                    </Link>
                                )}
                            </div>

                            <div className="pt-2">
                                <PrimaryButton 
                                    className="w-full justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl"
                                    disabled={processing}
                                >
                                    {processing ? (
                                        <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    ) : "Masuk Sekarang"}
                                </PrimaryButton>
                            </div>
                        </form>
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
                    animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }
            `}</style>
        </div>
    );
}
