import React from 'react';

export default function Badge({ children, color = 'gray', className = '' }) {
    const colors = {
        success: 'bg-green-100 text-green-800 border-green-200',
        warning: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        danger: 'bg-red-100 text-red-800 border-red-200',
        info: 'bg-blue-100 text-blue-800 border-blue-200',
        gray: 'bg-gray-100 text-gray-800 border-gray-200',
        'dark-blue': 'bg-blue-900 text-blue-100 border-blue-800',
        orange: 'bg-orange-100 text-orange-800 border-orange-200',
    };

    const style = colors[color] || colors.gray;

    return (
        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${style} ${className}`}>
            {children}
        </span>
    );
}
