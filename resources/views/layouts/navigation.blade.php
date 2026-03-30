{{--
    Navigācija: satur saites uz galvenajām lapām un tēmas pārslēdzēju.
    Pogai `#theme-toggle` tiek piesaistīts JS handler skriptā `layouts.app`.
--}}
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-purple-50 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="rounded-md overflow-hidden bg-gray-900 p-1 dark:bg-transparent">
                            <x-application-logo class="h-8 w-8 block dark:invert" />
                        </div>
                    </a>
                </div>
               

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Fitness Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('calories.index')" :active="request()->routeIs('calories.*')">
                        {{ __('Calories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('plans.index')" :active="request()->routeIs('plans.*')">
                        {{ __('Workout Plans') }}
                    </x-nav-link>
                    <x-nav-link :href="route('workouts.browse')" :active="request()->routeIs('workouts.*')">
                        {{ __('Workouts') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Theme toggle -->
                <button id="theme-toggle" type="button" title="Toggle dark mode" class="me-3 p-2 rounded-md text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white bg-white/10 dark:bg-white/5 border border-transparent hover:border-purple-100 dark:hover:border-gray-600 focus:ring-2 focus:ring-purple-400" aria-label="Toggle theme" aria-pressed="false">
                    <!-- Moon (dark) icon -->
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M21.752 15.002A9.718 9.718 0 0112.75 22C6.201 22 1 16.799 1 10.25 1 4.701 6.201-.5 12.75-.5c.756 0 1.506.064 2.244.19.422.07.735.45.735.882 0 .238-.092.466-.255.64a.996.996 0 01-1.12.233 7.472 7.472 0 00-3.39-.737C7.507 0 3.25 4.257 3.25 9.75 3.25 15.243 7.507 19.5 13 19.5c3.04 0 5.77-1.46 7.502-3.748.293-.382.117-.914-.75-.75z"/>
                    </svg>
                    <!-- Sun (light) icon -->
                    <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M6.995 12c0-2.761 2.246-5.005 5.005-5.005s5.005 2.244 5.005 5.005-2.246 5.005-5.005 5.005S6.995 14.761 6.995 12zm13.705-.5h2.3a.5.5 0 010 1h-2.3a.5.5 0 010-1zM1 11.5h2.3a.5.5 0 010 1H1a.5.5 0 010-1zm11-9.2v2.3a.5.5 0 01-1 0V2.3a.5.5 0 011 0zM12 20.7v2.3a.5.5 0 01-1 0v-2.3a.5.5 0 011 0zM4.22 4.22l1.63 1.63a.5.5 0 01-.71.71L3.5 4.93a.5.5 0 01.71-.71zm13.9 13.9l1.63 1.63a.5.5 0 01-.71.71l-1.63-1.63a.5.5 0 01.71-.71zM4.22 19.78l1.63-1.63a.5.5 0 01.71.71L4.93 20.5a.5.5 0 01-.71-.71zm13.9-13.9l1.63-1.63a.5.5 0 01.71.71L19.5 4.93a.5.5 0 01-.71-.71z"/>
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 dark:text-gray-200 bg-white dark:bg-transparent hover:text-purple-700 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-purple-700 hover:bg-purple-50 focus:outline-none focus:bg-purple-50 focus:text-purple-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Fitness Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calories.index')" :active="request()->routeIs('calories.*')">
                {{ __('Calories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('plans.index')" :active="request()->routeIs('plans.*')">
                {{ __('Workout Plans') }}
            </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('workouts.browse')" :active="request()->routeIs('workouts.*')">
                    {{ __('Workouts') }}
                </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
