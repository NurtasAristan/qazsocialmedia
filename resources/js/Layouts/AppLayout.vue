<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n'
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
    categories: Array
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const { locale } = useI18n()

const changeLanguage = (lang) => {
    locale.value = lang
    localStorage.setItem('lang', lang) // Optional: save selection
}

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <Head :title="title" />

    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 z-40 w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <Link :href="route('home')">
                        <ApplicationMark class="block h-9 w-auto" />
                    </Link>
                    <span class="text-lg font-bold">QazSocialMedia</span>
                </div>

                <div class="flex items-center space-x-2">
                    <select v-model="locale" @change="changeLanguage($event.target.value)" 
                        class="px-2 py-1 rounded bg-none bg-white text-blue-500 hover:bg-blue-100">
                        <option value="en">EN</option>
                        <option value="ru">RU</option>
                        <option value="kk">KK</option>
                    </select>
                </div>

                <!-- User Dropdown -->
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button class="flex items-center text-sm font-medium">
                            <img v-if="$page.props.auth.user.profile_photo_url" :src="$page.props.auth.user.profile_photo_url" class="h-8 w-8 rounded-full" alt="Profile">
                            <span class="ml-2 hidden sm:inline">{{ $page.props.auth.user.name }}</span>
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">API Tokens</DropdownLink>
                        <form method="POST" @submit.prevent="logout">
                            <DropdownLink as="button">Logout</DropdownLink>
                        </form>
                    </template>
                </Dropdown>

                <!-- Hamburger Menu for Mobile -->
                <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="sm:hidden p-2 rounded-md">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': showingNavigationDropdown, 'block': !showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Navigation -->
        <div v-if="showingNavigationDropdown" class="sm:hidden bg-white shadow-lg">
            <div class="px-4 py-2 space-y-1">
                <ResponsiveNavLink :href="route('home')" :active="route().current('home')">{{ $t('navigation.home') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('explore')" :active="route().current('explore')">{{ $t('navigation.explore') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('friends')" :active="route().current('friends')">{{ $t('navigation.friends') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('chat')" :active="route().current('chat')">{{ $t('navigation.chat') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('groups')" :active="route().current('groups')">{{ $t('navigation.groups') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('person')" :active="route().current('person')">{{ $t('navigation.person') }}</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('feed')" :active="route().current('feed')">{{ $t('navigation.feed') }}</ResponsiveNavLink>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="fixed top-16 z-30 bg-gray-800 text-gray-200 h-full w-64 hidden sm:block">
        <ul class="space-y-1 mt-4">
            <li><Link href="/home" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.home') }}</Link></li>
            <li><Link href="/explore" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.explore') }}</Link></li>
            <li><Link href="/friends" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.friends') }}</Link></li>
            <li><Link href="/chat" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.chat') }}</Link></li>
            <li><Link href="/groups" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.groups') }}</Link></li>
            <li><Link href="/person" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.person') }}</Link></li>
            <li><Link href="/feed" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">{{ $t('navigation.feed') }}</Link></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="relative sm:ml-64 pt-20 bg-gray-100 min-h-screen p-6">
        <slot />
    </main>
</template>