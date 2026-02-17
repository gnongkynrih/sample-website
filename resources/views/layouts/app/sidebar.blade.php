<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
         <!--  Swiper's CSS -->
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-gray-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('homepage') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="home" :href="route('admin.hero-section')" :current="request()->routeIs('admin.hero-section')" wire:navigate>
                        {{ __('Hero Section') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="home" :href="route('admin.room-type')"  :current="request()->routeIs('admin.room-type')" wire:navigate>
                        {{ __('Room Type') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="home" :href="route('admin.room')"  :current="request()->routeIs('admin.room')" wire:navigate>
                        {{ __('Room') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="home" :href="route('admin.about')"  :current="request()->routeIs('admin.about')" wire:navigate>
                        {{ __('About') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Settings')">
                <div class="px-3 py-2">   <!-- Just some padding around the button -->

                <button 

                    {{-- <!-- ────────────── Part 1: Create a memory box called "theme" ────────────── --> --}}
                    x-data="{ theme: $persist('dark') }"

                    {{-- <!-- ────────────── Part 2: When the button first appears on screen ────────────── --> --}}
                    x-init="
                        // Step 1: Immediately check what theme we saved before and apply it
                        document.documentElement.classList.toggle('dark', theme === 'dark');

                        // Step 2: From now on, watch the 'theme' box forever
                        // Whenever 'theme' changes → run this little instruction
                    $watch('theme', (newTheme) => {
                        if (newTheme === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    });
                    "

                    {{-- <!-- ────────────── Part 3: What happens when someone clicks the button ────────────── --> --}}
                    @click="theme = theme === 'light' ? 'dark' : 'light'"

                    {{-- <!-- Tailwind styles: makes it look nice in both light and dark mode --> --}}
                    class="flex items-center gap-2 px-3 py-2 text-sm font-medium 
                        text-zinc-700 hover:bg-zinc-100 
                        dark:text-zinc-300 dark:hover:bg-zinc-700 
                        rounded-md w-full"
                    >

                    {{-- <!-- Sun icon → only visible in light mode --> --}}
                    <svg x-show="theme === 'light'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <!-- (long path data that draws a sun) -->
                    </svg>

                    {{-- <!-- Moon icon → only visible in dark mode --> --}}
                    <svg x-show="theme === 'dark'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>

                    {{-- <!-- Text that changes automatically --> --}}
                    <span x-text="theme === 'light' ? 'Dark Mode' : 'Light Mode'"></span>

                </button>

            </div>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
            @auth
            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @endauth
        </flux:sidebar>


        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        @auth
            
       
            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
        </flux:header>

        {{ $slot }}

        @fluxScripts
        @stack('scripts')
    </body>
</html>
