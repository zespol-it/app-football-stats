                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.push-notifications')" :active="request()->routeIs('dashboard.push-notifications')">
                        {{ __('Powiadomienia Push') }}
                    </x-nav-link> 