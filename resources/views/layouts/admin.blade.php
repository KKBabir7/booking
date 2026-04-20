<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {
            baseUrl: '{{ url('/') }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 85px;
            --primary-color: #4f46e5;
            /* Indigo 600 */
            --sidebar-bg: #0f172a;
            /* Slate 900 */
            --content-bg: #f8fafc;
            /* Slate 50 */
        }

        body {
            background-color: var(--content-bg);
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 100;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #94a3b8;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 4px 12px;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.25rem;
        }

        .sidebar-link.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .submenu {
            padding-left: 12px;
            margin-top: 4px;
            margin-bottom: 8px;
        }

        .submenu .sidebar-link {
            padding: 8px 16px 8px 48px;
            font-size: 0.875rem;
        }

        .topbar {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .card-premium {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
        }

        /* Collapsed Sidebar Adjustments */
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .sidebar-link span,
        .sidebar.collapsed .sidebar-link .badge,
        .sidebar.collapsed .sidebar-group i:last-child,
        .sidebar.collapsed .sidebar-section-title,
        .sidebar.collapsed .sidebar-link::after {
            opacity: 0 !important;
            visibility: hidden !important;
            position: absolute !important;
            pointer-events: none !important;
        }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 12px 0;
            margin: 4px auto;
            width: 50px;
        }

        .sidebar.collapsed .sidebar-link i {
            margin-right: 0 !important;
            font-size: 1.4rem;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .sidebar.collapsed .px-8 {
            padding-left: 0 !important;
            padding-right: 0 !important;
            display: flex;
            justify-content: center;
        }

        .sidebar.collapsed .logo-container {
            margin-right: 0 !important;
        }

        .sidebar.collapsed .submenu {
            display: none !important;
        }

        .sidebar.collapsed nav {
            padding-left: 0 !important;
            padding-right: 0 !important;
            overflow-x: hidden !important;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Professional Sidebar Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        
        #sidebar.collapsed.custom-scrollbar::-webkit-scrollbar {
            width: 0px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar fixed h-full shadow-2xl flex flex-col pt-2" id="sidebar">
            <div class="px-8 py-6 mb-4 flex items-center justify-between border-b border-slate-800/50">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 tracking-tight overflow-hidden">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shrink-0 logo-container">
                        <i class="bi bi-hospital text-white text-xl"></i>
                    </div>
                    <span class="text-white sidebar-logo-text whitespace-nowrap font-bold text-xl">NGH <span class="text-indigo-400">ADMIN</span></span>
                </a>
                <button class="bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 w-8 h-8 rounded-lg flex items-center justify-center transition-all shrink-0" 
                        onclick="toggleSidebarDesktop()" title="Toggle Sidebar">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>

            <nav class="flex-grow overflow-y-auto px-1 custom-scrollbar">
                <div class="px-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider sidebar-section-title">Main Menu</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.navbar.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.navbar.*') ? 'active' : '' }}">
                    <i class="bi bi-compass-fill"></i> <span>Navbar</span>
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <div class="sidebar-group">
                        <div class="sidebar-link cursor-pointer flex justify-between items-center group"
                            onclick="toggleSubmenu('home-sub')">
                            <div class="flex items-center">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Home Page</span>
                            </div>
                            <i class="bi bi-chevron-down text-xs transition-transform duration-200" id="home-chevron"></i>
                        </div>
                        <div class="submenu {{ request()->is('admin/home/*') ? '' : 'hidden' }}" id="home-sub">
                            <a href="{{ route('admin.home_banners.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_banners.*') ? 'active' : '' }}">
                                Hero Banners
                            </a>
                            <a href="{{ route('admin.home_promo_banners.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_promo_banners.*') ? 'active' : '' }}">
                                Offer Banner
                            </a>
                            <a href="{{ route('admin.home_services.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_services.*') ? 'active' : '' }}">
                                Premium Services
                            </a>
                            <a href="{{ route('admin.home_restaurant') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_restaurant') ? 'active' : '' }}">Restaurant</a>
                            <a href="{{ route('admin.home_conference') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_conference') ? 'active' : '' }}">Conference</a>
                            <a href="{{ route('admin.home_clients.index') }}"
                                class="sidebar-link {{ request()->routeIs('admin.home_clients.*') ? 'active' : '' }}">Our
                                Clients</a>
                        </div>
                    </div>
                @endif

                <a href="{{ route('admin.rooms.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open-fill"></i> <span>Rooms</span>
                </a>

                <a href="{{ route('admin.conference.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.conference.*') ? 'active' : '' }}">
                    <i class="bi bi-building text-xl"></i> <span>Conference Halls</span>
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.page.edit', 'restaurant') }}"
                        class="sidebar-link {{ request()->is('admin/page/restaurant') ? 'active' : '' }}">
                        <i class="bi bi-egg-fried"></i> <span>Restaurant</span>
                    </a>

                    <a href="{{ route('admin.page.contact_information.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.page.contact_information.*') ? 'active' : '' }}">
                        <i class="bi bi-telephone-outbound"></i> <span>Contact Info</span>
                    </a>

                    <a href="{{ route('admin.page.about.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.page.about.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-person"></i> <span>About Page</span>
                    </a>

                    <a href="{{ route('admin.page.privacy.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.page.privacy.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i> <span>Privacy Policy</span>
                    </a>

                    <a href="{{ route('admin.page.terms.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.page.terms.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> <span>Terms of Service</span>
                    </a>

                    <a href="{{ route('admin.page.faq.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.page.faq.*') ? 'active' : '' }}">
                        <i class="bi bi-question-circle"></i> <span>FAQ Page</span>
                    </a>
                @endif

                <div class="px-6 mt-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider sidebar-section-title">Operations
                </div>

                <a href="{{ route('admin.bookings.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }} flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-calendar-check-fill"></i> <span>Bookings</span>
                    </div>
                    @if($unreadBookingsCount > 0)
                        <span id="nav-bookings-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto">
                            {{ $unreadBookingsCount }}
                        </span>
                    @else
                        <span id="nav-bookings-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto"
                            style="display: none;"></span>
                    @endif
                </a>

                <a href="{{ route('admin.contacts.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }} flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-envelope-fill"></i> <span>Contact</span>
                    </div>
                    @if($unreadContactsCount > 0)
                        <span id="nav-contacts-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto">
                            {{ $unreadContactsCount }}
                        </span>
                    @else
                        <span id="nav-contacts-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto"
                            style="display: none;"></span>
                    @endif
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }} flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-star-fill"></i> <span>Reviews</span>
                    </div>
                    @if($unreadReviewsCount > 0)
                        <span id="nav-reviews-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto">
                            {{ $unreadReviewsCount }}
                        </span>
                    @else
                        <span id="nav-reviews-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto"
                            style="display: none;"></span>
                    @endif
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <!-- SEO Menu -->
                    <a href="{{ route('admin.seo.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> <span>SEO</span>
                    </a>

                    <!-- Currencies Menu -->
                    <a href="{{ route('admin.currencies.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.currencies.*') ? 'active' : '' }}">
                        <i class="bi bi-currency-exchange"></i> <span>Currencies</span>
                    </a>
                @endif

                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }} flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-people-fill"></i> <span>Users</span>
                    </div>
                    @if($unreadUsersCount > 0)
                        <span id="nav-users-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto">
                            {{ $unreadUsersCount }}
                        </span>
                    @else
                        <span id="nav-users-count"
                            class="badge bg-rose-500 text-white rounded-full px-2 py-0.5 text-xs ms-auto"
                            style="display: none;"></span>
                    @endif
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <div class="px-6 mt-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider sidebar-section-title">System Settings</div>
                    
                    <a href="{{ route('admin.payment-settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.payment-settings.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card-fill"></i> <span>Payment Settings</span>
                    </a>

                    <a href="{{ route('admin.email-settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.email-settings.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope-at-fill"></i> <span>Email Setting</span>
                    </a>

                    <a href="{{ route('admin.admin-user.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.admin-user.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock-fill"></i> <span>Admin User</span>
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="sidebar-link w-full text-left text-rose-400 hover:bg-rose-500/10 hover:text-rose-300">
                        <i class="bi bi-power"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <header class="topbar px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-slate-600 hover:text-indigo-600 transition" onclick="toggleSidebar()">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <h2 class="font-bold text-xl text-slate-800 tracking-tight">
                        @yield('header')
                    </h2>
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative hidden sm:block">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Search..."
                            class="pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full text-sm focus:ring-2 focus:ring-indigo-500 w-64 transition-all">
                    </div>

                    <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                        <div class="text-right hidden md:block">
                            <div class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-500">
                                @if(auth()->user()->role === 'super_admin')
                                    Super Admin
                                @elseif(auth()->user()->role === 'admin')
                                    Administrator
                                @else
                                    {{ ucfirst(auth()->user()->role) }}
                                @endif
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 border border-indigo-200 shadow-sm">
                            <i class="bi bi-person-fill text-xl"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 flex-grow">
                @if(session('success'))
                    <div
                        class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-exclamation-triangle-fill text-rose-500"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div
                        class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-xl mb-8 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                        <div class="flex items-start gap-3 w-full">
                            <i class="bi bi-exclamation-triangle-fill text-rose-500 mt-0.5"></i>
                            <div class="flex-grow">
                                <h3 class="font-bold mb-1">Please fix the following errors:</h3>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()"
                                class="text-rose-400 hover:text-rose-600">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="w-full">
                    @yield('content')
                </div>
            </main>

            <footer class="px-8 py-6 text-center text-slate-400 text-sm border-t border-slate-200 bg-white">
                &copy; {{ date('Y') }} {{ config('app.name') }} Admin Dashboard. All rights reserved.
            </footer>
        </div>
    </div>

    <script>
        function toggleSubmenu(id) {
            const sidebar = document.getElementById('sidebar');
            
            // Auto expand if collapsed
            if (sidebar.classList.contains('collapsed')) {
                toggleSidebarDesktop();
                // Wait for animation
                setTimeout(() => openSub(id), 200);
            } else {
                openSub(id);
            }
        }

        function openSub(id) {
            const sub = document.getElementById(id);
            const chevron = document.getElementById(id.replace('-sub', '-chevron'));
            sub.classList.toggle('hidden');
            if (chevron) {
                chevron.style.transform = sub.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        function toggleSidebar() {
            // Mobile toggle
            document.getElementById('sidebar').classList.toggle('active');
        }

        function toggleSidebarDesktop() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to local storage
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        }

        // Restore sidebar state on load
        document.addEventListener('DOMContentLoaded', () => {
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed && window.innerWidth > 1024) {
                document.getElementById('sidebar').classList.add('collapsed');
                document.querySelector('.main-content').classList.add('expanded');
            }
        });
    </script>

    <!-- jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            function formatIcon(icon) {
                if (!icon.id) {
                    return icon.text;
                }
                var $icon = $('<span><i class="' + icon.id + '"></i> ' + icon.text + '</span>');
                return $icon;
            }

            $.getJSON('https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.json', function (data) {
                let bsIconsList = [{ id: '', text: 'No Icon' }];
                Object.keys(data).forEach(function (key) {
                    // Capitalize each word and replace dashes with spaces
                    let textName = key.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    bsIconsList.push({
                        id: 'bi bi-' + key,
                        text: textName
                    });
                });

                function initSelect2(element) {
                    let selectedVal = $(element).data('selected');
                    $(element).select2({
                        data: bsIconsList,
                        templateResult: formatIcon,
                        templateSelection: formatIcon,
                        width: '100%',
                        placeholder: "Search for an icon...",
                    });

                    if (selectedVal) {
                        $(element).val(selectedVal).trigger('change');
                    }
                }

                $('.icon-select').each(function () {
                    initSelect2(this);
                });

                // Expose init to window for dynamically added elements (like amenities)
                window.initIconSelect = initSelect2;
            });

            // Notification Polling (Real-time updates without refresh)
            function updateNotificationCounts() {
                $.ajax({
                    url: "{{ route('admin.notifications.counts') }}",
                    method: 'GET',
                    success: function (data) {
                        updateBadge('nav-bookings-count', data.unreadBookingsCount);
                        updateBadge('nav-reviews-count', data.unreadReviewsCount);
                        updateBadge('nav-users-count', data.unreadUsersCount);
                        updateBadge('nav-contacts-count', data.unreadContactsCount);
                    }
                });
            }

            function updateBadge(id, count) {
                const badge = $('#' + id);
                if (count > 0) {
                    badge.text(count).show();
                } else {
                    badge.hide();
                }
            }

            // Poll every 30 seconds
            setInterval(updateNotificationCounts, 30000);
        });
    </script>

    @stack('scripts')
</body>

</html>