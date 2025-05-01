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

    <!-- screen loader -->
    {{-- <div class="screen_loader animate__animated fixed inset-0 z-[60] grid place-content-center bg-[#fafafa] dark:bg-[#060818]">
            <svg width="64" height="64" viewbox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
                <path d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
                    <animatetransform attributename="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s" repeatcount="indefinite"></animatetransform>
                </path>
                <path d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
                    <animatetransform attributename="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s" repeatcount="indefinite"></animatetransform>
                </path>
            </svg>
        </div> --}}

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
            <!-- start header section -->
            @include('layout.navbar')
            <!-- end header section -->

            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <!-- start main content section -->

                <div x-data="parkingSlots" x-init="initialize()">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h2 class="text-xl">Parking Slot</h2>
                        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center sm:gap-3">
                            <div class="flex gap-3">
                                <div>

                                    <form action="{{ route('bookings.create') }}" method="GET">
                                        <button type="submit" class="btn btn-primary">
                                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pl-5">
                                                <path d="M2 5.5L3.21429 7L7.5 3" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                                <path opacity="0.5" d="M2 12.5L3.21429 14L7.5 10" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                                <path d="M2 19.5L3.21429 21L7.5 17" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                                <path d="M22 19L12 19" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                                <path opacity="0.5" d="M22 12L12 12" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M22 5L12 5" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                            </svg>
                                            Create Booking
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search Slot"
                                    class="peer form-input py-2 ltr:pr-11 rtl:pl-11" x-model="searchQuery"
                                    @keyup="searchSlots">
                                <div
                                    class="absolute top-1/2 -translate-y-1/2 peer-focus:text-primary ltr:right-[11px] rtl:left-[11px]">
                                    <svg class="mx-auto" width="16" height="16" viewbox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor"
                                            stroke-width="1.5" opacity="0.5"></circle>
                                        <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel mt-5 overflow-hidden border-0 p-0">
                        <template x-if="displayType === 'list'">
                            <div class="table-responsive">
                                <table class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Slot name</th>
                                            <th>Status</th>
                                            <th>Vehicle Type</th>
                                            <th>Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="slot in filteredSlots" :key="slot.id">
                                            <tr>
                                                <td class="whitespace-nowrap" x-text="slot.slot_name"></td>
                                                <td class="whitespace-nowrap">
                                                    <span
                                                        :class="slot.status === 'inactive' ? 'badge bg-danger' : slot
                                                            .status === 'active' ? 'badge bg-success' :
                                                            'badge bg-secondary'"
                                                        x-text="slot.status"></span>
                                                </td>
                                                <td class="whitespace-nowrap" x-text="slot.vehicle_type"></td>
                                                <td class="whitespace-nowrap">
                                                    <span
                                                        :class="slot.availability === 'Occupied' ? 'badge bg-danger' : slot
                                                            .availability === 'Available' ? 'badge bg-success' :
                                                            'badge bg-warning'"
                                                        x-text="slot.availability"></span>
                                                    <!-- Check if the authenticated user is the one who reserved the slot -->
                                                    @foreach ($parkings as $parking)
                                                        <template
                                                            x-if="slot.id === {{ $parking->slot_id }} && {{ $parking->user_id === Auth::id() }}">
                                                            <span class="badge bg-danger ml-2">You</span>
                                                        </template>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </div>

                </div>
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('parkingSlots', () => ({
                            searchQuery: '',
                            displayType: 'list', // Default to 'list' view
                            slots: @json($parkingSlots), // Assuming you're passing the parking slots from PHP to the view
                            filteredSlots: [],

                            // Initialization method to set the filteredSlots initially
                            initialize() {
                                this.filteredSlots = this.slots;
                            },

                            // Method to search and filter slots
                            searchSlots() {
                                const query = this.searchQuery.toLowerCase();
                                this.filteredSlots = this.slots.filter(slot => {
                                    return slot.slot_name.toLowerCase().includes(query) ||
                                        slot.status.toLowerCase().includes(query) ||
                                        slot.vehicle_type.toLowerCase().includes(query) ||
                                        slot.availability.toLowerCase().includes(query);
                                });
                            },

                            // Method to switch display type (list/grid)
                            setDisplayType(type) {
                                this.displayType = type;
                            }
                        }));
                    });
                </script>

                <!-- end main content section -->

            </div>
        </div>
    </div>

    @include('layout.footerjs')

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
            //contacts
            Alpine.data('contacts', () => ({
                defaultParams: {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    phone: '',
                    location: '',
                },
                displayType: 'list',
                addContactModal: false,
                params: {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    phone: '',
                    location: '',
                },
                filterdContactsList: [],
                searchUser: '',
                contactList: [{
                        id: 1,
                        path: 'profile-35.png',
                        name: 'Soeng Souy',
                        role: 'Web Developer',
                        email: 'soengsouy@mail.com',
                        location: 'Boston, USA',
                        phone: '+1 202 555 0197',
                        posts: 25,
                        followers: '5K',
                        following: 500,
                    },
                    {
                        id: 2,
                        path: 'profile-35.png',
                        name: 'StarCode Kh',
                        role: 'Web Designer',
                        email: 'starcodekh@mail.com',
                        location: 'Sydney, Australia',
                        phone: '+1 202 555 0170',
                        posts: 25,
                        followers: '21.5K',
                        following: 350,
                    },
                    {
                        id: 3,
                        path: 'profile-35.png',
                        name: 'Lila Perry',
                        role: 'UX/UI Designer',
                        email: 'lila@mail.com',
                        location: 'Miami, USA',
                        phone: '+1 202 555 0105',
                        posts: 20,
                        followers: '21.5K',
                        following: 350,
                    },
                    {
                        id: 4,
                        path: 'profile-35.png',
                        name: 'Andy King',
                        role: 'Project Lead',
                        email: 'andy@mail.com',
                        location: 'Tokyo, Japan',
                        phone: '+1 202 555 0194',
                        posts: 25,
                        followers: '21.5K',
                        following: 300,
                    },
                    {
                        id: 5,
                        path: 'profile-35.png',
                        name: 'Jesse Cory',
                        role: 'Web Developer',
                        email: 'jesse@mail.com',
                        location: 'Edinburgh, UK',
                        phone: '+1 202 555 0161',
                        posts: 30,
                        followers: '20K',
                        following: 350,
                    },
                    {
                        id: 6,
                        path: 'profile-35.png',
                        name: 'Xavier',
                        role: 'UX/UI Designer',
                        email: 'xavier@mail.com',
                        location: 'Phnom Penh',
                        phone: '+1 202 555 0155',
                        posts: 25,
                        followers: '21.5K',
                        following: 350,
                    },
                    {
                        id: 7,
                        path: 'profile-35.png',
                        name: 'Susan',
                        role: 'Project Manager',
                        email: 'susan@mail.com',
                        location: 'Miami, USA',
                        phone: '+1 202 555 0118',
                        posts: 40,
                        followers: '21.5K',
                        following: 350,
                    },
                    {
                        id: 8,
                        path: 'profile-35.png',
                        name: 'Raci Lopez',
                        role: 'Web Developer',
                        email: 'traci@mail.com',
                        location: 'Edinburgh, UK',
                        phone: '+1 202 555 0135',
                        posts: 25,
                        followers: '21.5K',
                        following: 350,
                    },
                    {
                        id: 9,
                        path: 'profile-35.png',
                        name: 'Steven Mendoza',
                        role: 'HR',
                        email: 'sokol@verizon.net',
                        location: 'Monrovia, US',
                        phone: '+1 202 555 0100',
                        posts: 40,
                        followers: '21.8K',
                        following: 300,
                    },
                    {
                        id: 10,
                        path: 'profile-35.png',
                        name: 'James Cantrell',
                        role: 'Web Developer',
                        email: 'sravani@comcast.net',
                        location: 'Michigan, US',
                        phone: '+1 202 555 0134',
                        posts: 100,
                        followers: '28K',
                        following: 520,
                    },
                    {
                        id: 11,
                        path: 'profile-35.png',
                        name: 'Reginald Brown',
                        role: 'Web Designer',
                        email: 'drhyde@gmail.com',
                        location: 'Entrimo, Spain',
                        phone: '+1 202 555 0153',
                        posts: 35,
                        followers: '25K',
                        following: 500,
                    },
                    {
                        id: 12,
                        path: 'profile-35.png',
                        name: 'Stacey Smith',
                        role: 'Chief technology officer',
                        email: 'maikelnai@optonline.net',
                        location: 'Lublin, Poland',
                        phone: '+1 202 555 0115',
                        posts: 21,
                        followers: '5K',
                        following: 200,
                    },
                ],

                init() {
                    this.searchContacts();
                },

                searchContacts() {
                    this.filterdContactsList = this.contactList.filter((d) => d.name.toLowerCase()
                        .includes(this.searchUser.toLowerCase()));
                },

                editUser(user) {
                    this.params = this.defaultParams;
                    if (user) {
                        this.params = JSON.parse(JSON.stringify(user));
                    }

                    this.addContactModal = true;
                },

                saveUser() {
                    if (!this.params.name) {
                        this.showMessage('Name is required.', 'error');
                        return true;
                    }
                    if (!this.params.email) {
                        this.showMessage('Email is required.', 'error');
                        return true;
                    }
                    if (!this.params.phone) {
                        this.showMessage('Phone is required.', 'error');
                        return true;
                    }
                    if (!this.params.role) {
                        this.showMessage('Occupation is required.', 'error');
                        return true;
                    }

                    if (this.params.id) {
                        //update user
                        let user = this.contactList.find((d) => d.id === this.params.id);
                        user.name = this.params.name;
                        user.email = this.params.email;
                        user.role = this.params.role;
                        user.phone = this.params.phone;
                        user.location = this.params.location;
                    } else {
                        //add user
                        let maxUserId = this.contactList.length ?
                            this.contactList.reduce((max, character) => (character.id > max ? character
                                .id : max), this.contactList[0].id) :
                            0;

                        let user = {
                            id: maxUserId + 1,
                            path: 'profile-35.png',
                            name: this.params.name,
                            email: this.params.email,
                            role: this.params.role,
                            phone: this.params.phone,
                            location: this.params.location,
                            posts: 20,
                            followers: '5K',
                            following: 500,
                        };
                        this.contactList.splice(0, 0, user);
                        this.searchContacts();
                    }

                    this.showMessage('User has been saved successfully.');
                    this.addContactModal = false;
                },

                deleteUser(user) {
                    this.contactList = this.contactList.filter((d) => d.id != user.id);
                    // this.ids = this.ids.filter((d) => d != user.id);
                    this.searchContacts();
                    this.showMessage('User has been deleted successfully.');
                },

                setDisplayType(type) {
                    this.displayType = type;
                },

                showMessage(msg = '', type = 'success') {
                    const toast = window.Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    toast.fire({
                        icon: type,
                        title: msg,
                        padding: '10px 20px',
                    });
                },
            }));
        });
    </script>
</body>

</html>
