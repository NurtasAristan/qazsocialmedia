<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
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

<template>
    <Head title="Welcome" />
    <div class="bg-gradient-to-b from-gray-50 to-gray-100 dark:from-black dark:to-gray-900 text-gray-700 dark:text-gray-300">
        <!-- Hero Section -->
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <header class="w-full max-w-4xl px-6 py-10">
                <nav class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-[#FF2D20]">QazSocialMedia</h1>
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
                    Welcome to <span class="text-[#FF2D20]">QazSocialMedia</span>
                </h2>
                <p class="mt-4 text-lg sm:text-xl text-gray-500">
                    A modern social media app for Kazakhstani people.
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
