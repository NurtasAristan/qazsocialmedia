<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    language: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<!--template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <h2>{{ language }}</h2>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template -->

<template>
    <Head title="Welcome" />
    <div class="bg-gradient-to-b from-gray-50 to-gray-100 dark:from-black dark:to-gray-900 text-gray-700 dark:text-gray-300">
        <!-- Hero Section -->
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <header class="w-full max-w-4xl px-6 py-10">
                <nav class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-[#FF2D20]">Laravel Social</h1>
                    <div v-if="canLogin" class="space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#FF2D20] rounded-md shadow-lg hover:bg-[#e52518]"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 text-sm font-semibold text-white bg-[#FF2D20] rounded-md shadow-lg hover:bg-[#e52518]"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-4 py-2 text-sm font-semibold text-white bg-gray-600 rounded-md shadow-lg hover:bg-gray-700"
                            >
                                Register
                            </Link>
                        </template>
                    </div>
                </nav>
            </header>

            <main class="w-full max-w-3xl text-center">
                <h2 class="text-4xl font-extrabold leading-tight sm:text-5xl">
                    Welcome to <span class="text-[#FF2D20]">Laravel Social</span>
                </h2>
                <p class="mt-4 text-lg sm:text-xl text-gray-500">
                    A modern social media app built with Laravel, Vue, and Inertia.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="p-6 bg-white shadow rounded-lg dark:bg-gray-800">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">
                            Language
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ language }}
                        </p>
                    </div>

                    <div class="p-6 bg-white shadow rounded-lg dark:bg-gray-800">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">
                            Framework Details
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Laravel v{{ laravelVersion }} <br />
                            PHP v{{ phpVersion }}
                        </p>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer Section -->
        <footer class="py-8 bg-gray-800 dark:bg-gray-900">
            <div class="text-center text-sm text-gray-400">
                Built using Laravel, Vue, and Inertia.
            </div>
        </footer>
    </div>
</template>
