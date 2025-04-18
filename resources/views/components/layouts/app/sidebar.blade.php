<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
            <a href="{{ route('dashboard.index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>
            <flux:navlist variant="outline">
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.Platform')" />
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.Penjualan')" />
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.Logistik')" />
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.PemasukanPengeluaran')" />
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.Management')" />
                <flux:custom.navigation-group-list :konfigurasi="config('sidebar.Database')" />
            </flux:navlist>
            <flux:spacer />
            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>
        <flux:header class="block! bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
            <flux:navbar class="lg:hidden w-full">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <flux:spacer />
                <flux:dropdown position="top" align="start">
                    <flux:profile initials="{{ auth()->user()->initials() }}" />
                    <flux:menu>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:navbar>
            <flux:navbar scrollable>
                <flux:dropdown>
                    <flux:navbar.item badge="{{ $notifAll }}" badge-color="red">
                        <flux:icon.bell variant="solid" class="text-red-500 dark:text-red-300" />
                    </flux:navbar.item>
                    <flux:navmenu>
                        <div class="grid grid-cols-1">
                            @foreach($notifList as $key => $value)
                                <div class="grid grid-cols-3 gap-4 {{ $loop->last ? 'border-none' : 'border-b' }} py-2">
                                    <div class="flex items-center">
                                        <flux:heading>{{ $value->data['category'] }}</flux:heading>
                                    </div>
                                    <div class="flex items-center">
                                        <flux:text>{{ $value->data['ro_number'] }}</flux:text>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <flux:button :href="route('notification.redirect', $value->id)" size="xs" variant="primary">
                                            Lihat
                                        </flux:button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </flux:navmenu>
                </flux:dropdown>
            </flux:navbar>
        </flux:header>
        {{ $slot }}
        @fluxScripts
        <flux:toast />
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </body>
</html>
