<!DOCTYPE html>
<html lang="en" dir="ltr">
@include('layout.header')

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
    <!-- sidebar menu overlay -->
    <div x-cloak="" class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>



    <!-- scroll to top button -->
    <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button"
                class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
                @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewbox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                        fill="currentColor"></path>
                    <path
                        d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                        fill="currentColor"></path>
                </svg>
            </button>
        </template>
    </div>

    <!-- start theme customizer section -->
    @include('layout.customizer')
    <!-- end theme customizer section -->

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        @include('layout.sidebar')
        <!-- end sidebar section -->

        <div class="main-content flex flex-col min-h-screen">
            @include('layout.navbar')
            <!-- end header section -->

            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <!-- start main content section -->
                <div x-data="form">
                    <ul class="flex space-x-2 rtl:space-x-reverse">
                        <li>
                            <a href="javascript:;" class="text-primary hover:underline">Book Now</a></a>
                        </li>
                        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                            <span>Add</span>
                        </li>
                    </ul>
                    <div class="grid grid-cols-1 gap-6 pt-5 lg:grid-cols-2">
                        <!-- Stack -->
                        <div class="panel">
                            <div class="mb-5 flex items-center justify-between">
                                <h5 class="text-lg font-semibold dark:text-white-light">Book Now !!!</h5>
                            </div>

                            <!-- Success message -->
                            @if (session('success'))
                                <div class="bg-green-500 text-white text-sm p-3 rounded-md mb-5">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="mb-5">
                                @error('error')
                                    <div class="bg-danger border border-danger text-red-700 px-4 py-3 rounded relative mb-4"
                                        role="alert">
                                        <span class="block sm:inline">{{ $message }}</span>
                                    </div>
                                @enderror
                                <!-- Form to create a new category -->
                                <form class="space-y-5" action="{{ route('bookings.update', $parkings->id) }}"
                                    method="POST">
                                    @csrf
                                    <div>
                                        <label for="category"
                                            class="block text-sm font-medium text-gray-700">Slot</label>
                                        <select class="form-input" name="slot_id" required>
                                            <option value="" disabled selected>Select Slot</option>
                                            @foreach ($parkingSlots as $parkingSlot)
                                                @if ($parkingSlot->status != 'inactive' && !in_array(strtolower($parkingSlot->availability), ['occupied', 'reserved']))
                                                    <option value="{{ $parkingSlot->id }}">{{ $parkingSlot->slot_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="category"
                                            class="block text-sm font-medium text-gray-700">Category</label>
                                        <select class="form-input" name="vehicle_id" id="categorySelect" required>
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach ($vehicleCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    data-name="{{ $category->group_name }}">
                                                    {{ $category->group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="category"
                                            class="block text-sm font-medium text-gray-700">Rate</label>
                                        <select class="form-input" name="rate_id" id="rateSelect" required>
                                            <option value="" disabled selected>Select Rate</option>
                                            @foreach ($rates as $rate)
                                                <option value="{{ $rate->id }}">{{ $rate->rate_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="flex items-center space-x-3">
                                        <!-- Cancel button (redirects to categories list or previous page) -->
                                        <a href="{{ route('DashboardUser') }}" class="btn btn-secondary">Cancel</a>
                                        <!-- Link to categories list -->
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <!-- end main content section -->

                    </div>


                </div>
            </div>

            @include('layout.footerjs')
            <!-- start hightlight js -->
            <link rel="stylesheet" href="css/highlight.min.css">
            <script src="js/highlight.min.js"></script>
            <!-- end hightlight js -->

            <script>
                document.addEventListener('alpine:init', () => {
                    // main section
                    Alpine.data('scrollToTop', () => ({
                        showTopButton: false,
                        init() {
                            window.onscroll = () => {
                                this.scrollFunction();
                            };
                        },

                        scrollFunction() {
                            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                                this.showTopButton = true;
                            } else {
                                this.showTopButton = false;
                            }
                        },

                        goToTop() {
                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;
                        },
                    }));

                    // theme customization
                    Alpine.data('customizer', () => ({
                        showCustomizer: false,
                    }));

                    // sidebar section
                    Alpine.data('sidebar', () => ({
                        init() {
                            const selector = document.querySelector('.sidebar ul a[href="' + window.location
                                .pathname + '"]');
                            if (selector) {
                                selector.classList.add('active');
                                const ul = selector.closest('ul.sub-menu');
                                if (ul) {
                                    let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                                    if (ele) {
                                        ele = ele[0];
                                        setTimeout(() => {
                                            ele.click();
                                        });
                                    }
                                }
                            }
                        },
                    }));

                    // header section
                    Alpine.data('header', () => ({
                        init() {
                            const selector = document.querySelector('ul.horizontal-menu a[href="' + window
                                .location.pathname + '"]');
                            if (selector) {
                                selector.classList.add('active');
                                const ul = selector.closest('ul.sub-menu');
                                if (ul) {
                                    let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                                    if (ele) {
                                        ele = ele[0];
                                        setTimeout(() => {
                                            ele.classList.add('active');
                                        });
                                    }
                                }
                            }
                        },

                        notifications: [{
                                id: 1,
                                profile: 'user-profile.jpeg',
                                message: '<strong class="text-sm mr-1">StarCode Kh</strong>invite you to <strong>Prototyping</strong>',
                                time: '45 min ago',
                            },
                            {
                                id: 2,
                                profile: 'profile-34.jpeg',
                                message: '<strong class="text-sm mr-1">Adam Nolan</strong>mentioned you to <strong>UX Basics</strong>',
                                time: '9h Ago',
                            },
                            {
                                id: 3,
                                profile: 'profile-16.jpeg',
                                message: '<strong class="text-sm mr-1">Anna Morgan</strong>Upload a file',
                                time: '9h Ago',
                            },
                        ],

                        messages: [{
                                id: 1,
                                image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-success-light dark:bg-success text-success dark:text-success-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>',
                                title: 'Congratulations!',
                                message: 'Your OS has been updated.',
                                time: '1hr',
                            },
                            {
                                id: 2,
                                image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-info-light dark:bg-info text-info dark:text-info-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>',
                                title: 'Did you know?',
                                message: 'You can switch between artboards.',
                                time: '2hr',
                            },
                            {
                                id: 3,
                                image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-danger-light dark:bg-danger text-danger dark:text-danger-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>',
                                title: 'Something went wrong!',
                                message: 'Send Reposrt',
                                time: '2days',
                            },
                            {
                                id: 4,
                                image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-warning-light dark:bg-warning text-warning dark:text-warning-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">    <circle cx="12" cy="12" r="10"></circle>    <line x1="12" y1="8" x2="12" y2="12"></line>    <line x1="12" y1="16" x2="12.01" y2="16"></line></svg></span>',
                                title: 'Warning',
                                message: 'Your password strength is low.',
                                time: '5days',
                            },
                        ],

                        languages: [{
                                id: 1,
                                key: 'Khmer',
                                value: 'kh',
                            },
                            {
                                id: 2,
                                key: 'Danish',
                                value: 'da',
                            },
                            {
                                id: 3,
                                key: 'English',
                                value: 'en',
                            },
                            {
                                id: 4,
                                key: 'French',
                                value: 'fr',
                            },
                            {
                                id: 5,
                                key: 'German',
                                value: 'de',
                            },
                            {
                                id: 6,
                                key: 'Greek',
                                value: 'el',
                            },
                            {
                                id: 7,
                                key: 'Hungarian',
                                value: 'hu',
                            },
                            {
                                id: 8,
                                key: 'Italian',
                                value: 'it',
                            },
                            {
                                id: 9,
                                key: 'Japanese',
                                value: 'ja',
                            },
                            {
                                id: 10,
                                key: 'Polish',
                                value: 'pl',
                            },
                            {
                                id: 11,
                                key: 'Portuguese',
                                value: 'pt',
                            },
                            {
                                id: 12,
                                key: 'Russian',
                                value: 'ru',
                            },
                            {
                                id: 13,
                                key: 'Spanish',
                                value: 'es',
                            },
                            {
                                id: 14,
                                key: 'Swedish',
                                value: 'sv',
                            },
                            {
                                id: 15,
                                key: 'Turkish',
                                value: 'tr',
                            },
                            {
                                id: 16,
                                key: 'Arabic',
                                value: 'ae',
                            },
                        ],

                        removeNotification(value) {
                            this.notifications = this.notifications.filter((d) => d.id !== value);
                        },

                        removeMessage(value) {
                            this.messages = this.messages.filter((d) => d.id !== value);
                        },
                    }));

                    // content section
                    Alpine.data('form', () => ({
                        // highlightjs
                        codeArr: [],
                        toggleCode(name) {
                            if (this.codeArr.includes(name)) {
                                this.codeArr = this.codeArr.filter((d) => d != name);
                            } else {
                                this.codeArr.push(name);

                                setTimeout(() => {
                                    document.querySelectorAll('pre.code').forEach((el) => {
                                        hljs.highlightElement(el);
                                    });
                                });
                            }
                        },
                        get searchResults() {
                            return this.items.filter((item) => {
                                return (
                                    item.name.toLowerCase().includes(this.search
                                        .toLowerCase()) ||
                                    item.email.toLowerCase().includes(this.search
                                        .toLowerCase()) ||
                                    item.status.toLowerCase().includes(this.search
                                        .toLowerCase())
                                );
                            });
                        },
                    }));
                });
            </script>
</body>

</html>
