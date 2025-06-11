<script setup>
import { useI18n } from 'vue-i18n'
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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

const { locale } = useI18n()

const changeLanguage = (lang) => {
    locale.value = lang
    localStorage.setItem('lang', lang) // Optional: save selection
}

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

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
                    <div>
                            <select v-model="locale" @change="changeLanguage($event.target.value)" 
                                class="px-2 py-1 rounded bg-none bg-white text-blue-500 hover:bg-blue-100">
                                <option value="en">{{ $t('language.english') }}/EN</option>
                                <option value="ru">{{ $t('language.russian') }}/RU</option>
                                <option value="kk">{{ $t('language.kazakh') }}/KK</option>
                            </select>
                        </div>
                    <div v-if="canLogin" class="space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('home')"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#FF2D20] rounded-md shadow-lg hover:bg-[#e52518]"
                        >
                        {{ $t('navigation.home') }}
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 text-sm font-semibold text-white bg-[#FF2D20] rounded-md shadow-lg hover:bg-[#e52518]"
                            >
                            {{ $t('welcome.log_in') }}
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-4 py-2 text-sm font-semibold text-white bg-gray-600 rounded-md shadow-lg hover:bg-gray-700"
                            >
                            {{ $t('welcome.register') }}
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
                    {{ $t('welcome.description') }}
                </p>

                <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="current-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="form.remember" name="remember" />
                                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Forgot your password?
                                </Link>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Log in
                                </PrimaryButton>
                            </div>
                        </form>
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
