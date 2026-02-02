import React from 'react';

export default function Card({ title, value, icon, color, className = '' }) {
    const colorClasses = {
        blue: 'bg-blue-500',
        green: 'bg-green-500',
        orange: 'bg-orange-500',
        purple: 'bg-purple-500',
        red: 'bg-red-500',
    };

    const bgColor = colorClasses[color] || 'bg-gray-500';

    return (
        <div className={`${bgColor} rounded-lg shadow-lg p-6 text-white relative overflow-hidden ${className}`}>
            <div className="relative z-10">
                <h3 className="text-sm font-semibold uppercase tracking-wider opacity-90 mb-1">{title}</h3>
                <div className="text-3xl font-bold">{value}</div>
            </div>
            <div className="absolute right-4 top-1/2 transform -translate-y-1/2 p-3 bg-white bg-opacity-20 rounded-full">
                {icon}
            </div>
             {/* Decorative circle */}
            <div className="absolute -right-6 -bottom-6 w-24 h-24 bg-white bg-opacity-10 rounded-full z-0"></div>
        </div>
    );
}
