<script setup>
import { ref } from 'vue';
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

const logout = () => {
    router.post(route('logout'));
};
</script>

<!--template>
    <Head :title="title" />

    <-Banner />

    <nav class="fixed top-0 z-40 w-full bg-cyan-300 border-b border-gray-100">
        <Primary Navigation Menu>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <Logo>
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <Navigation Links>
                            <div class="hidden flex items-center justify-center space-x-8 sm:-my-px sm:ms-10 sm:flex bg-yellow-300">
                                SN Name
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <Teams Dropdown>
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <Team Management>
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Team
                                            </div>

                                            <Team Setting>
                                            <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                Team Settings
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                Create New Team
                                            </DropdownLink>

                                            <Team Switcher>
                                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                <div class="border-t border-gray-200" />

                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <-- Settings Dropdown ->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <-- Account Management ->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <-- Authentication ->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <-- Hamburger ->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
        </div>

        <-- Responsive Navigation Menu ->
        <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                </div>

                <-- Responsive Settings Options ->
                <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <-- Authentication ->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <-- Team Management ->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <-- Team Settings ->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <-- Team Switcher ->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                </div>
        </div>
    </nav>

    <-- Sidebar Navigation ->
    <aside class="fixed top-0 z-30 bg-yellow-300 shadow w-64 h-screen pt-20 border-2">
        <ul class="px-3 font-medium">
            <li>
                <a href="/dashboard" class="flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ms-3">Home</span>
                </a>
                <a href="/explore" class="flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ms-3">Explore</span>
                </a>
                <a href="/friends" class="flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ms-3">Friends</span>
                </a>
                <a href="/chat" class="flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ms-3">Chat</span>
                </a>
                <a href="/groups" class="flex p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="ms-3">Groups</span>
                </a>
            </li>
        </ul>
    </aside>

    <-- Page Content ->
    <main class="relative top-0 z-20 w-3/5 p-16 mx-auto bg-white rounded-lg">
        <slot />
    </main>
</template-->

<template>
    <Head :title="title" />

    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 z-40 w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <Link :href="route('dashboard')">
                        <ApplicationMark class="block h-9 w-auto" />
                    </Link>
                    <span class="text-lg font-bold">QazSocialMedia</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center space-x-6">
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Home</NavLink>
                    <NavLink :href="route('explore')" :active="route().current('explore')">Explore</NavLink>
                    <NavLink :href="route('friends')" :active="route().current('friends')">Friends</NavLink>
                    <NavLink :href="route('chat')" :active="route().current('chat')">Chat</NavLink>
                    <NavLink :href="route('groups')" :active="route().current('groups')">Groups</NavLink>
                    <NavLink :href="route('person')" :active="route().current('person')">Person</NavLink>
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
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Home</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('explore')" :active="route().current('explore')">Explore</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('friends')" :active="route().current('friends')">Friends</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('chat')" :active="route().current('chat')">Chat</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('groups')" :active="route().current('groups')">Groups</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('person')" :active="route().current('person')">Person</ResponsiveNavLink>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="fixed top-16 z-30 bg-gray-800 text-gray-200 h-full w-64 hidden sm:block">
        <ul class="space-y-1 mt-4">
            <li><Link href="/dashboard" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Home</Link></li>
            <li><Link href="/explore" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Explore</Link></li>
            <li><Link href="/friends" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Friends</Link></li>
            <li><Link href="/chat" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Chat</Link></li>
            <li><Link href="/groups" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Groups</Link></li>
            <li><Link href="/person" class="block px-4 py-2 hover:bg-gray-700 rounded-lg">Person</Link></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="relative sm:ml-64 pt-20 bg-gray-100 min-h-screen p-6">
        <slot />
    </main>
</template>