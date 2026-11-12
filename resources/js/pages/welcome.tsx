import { Head } from '@inertiajs/react';

export default function Welcome() {
    return (
        <>
            <Head title="Welcome" />
            <div className="flex min-h-screen items-center justify-center bg-[#FDFDFC] p-6 dark:bg-[#0a0a0a]">
                <div className="rounded-lg border-4 border-[#1b1b18] bg-white px-12 py-8 shadow-lg dark:border-[#1b1b18] dark:bg-[#161615]">
                    <h1 className="font-mono text-5xl font-bold tracking-widest text-green-600 dark:text-green-400">
                        RZKYY
                    </h1>
                </div>
            </div>
        </>
    );
}
