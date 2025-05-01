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

                <div x-data="contacts">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h2 class="text-xl">Vehicle Category</h2>
                        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center sm:gap-3">
                            <div class="flex gap-3">
                                <div>
                                    <form action="{{ route('vehicle-categories.create') }}" method="GET">
                                        <button type="submit" class="btn btn-primary">
                                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ltr:mr-2 rtl:ml-2">
                                                <circle cx="10" cy="6" r="4" stroke="currentColor"
                                                    stroke-width="1.5"></circle>
                                                <path opacity="0.5"
                                                    d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z"
                                                    stroke="currentColor" stroke-width="1.5"></path>
                                                <path d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                                </path>
                                            </svg>
                                            Add Category
                                        </button>
                                    </form>
                                    <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60"
                                        :class="addContactModal && '!block'">
                                        <div class="flex min-h-screen items-center justify-center px-4"
                                            @click.self="addContactModal = false">
                                            <div x-show="addContactModal" x-transition="" x-transition.duration.300=""
                                                class="panel my-8 w-[90%] max-w-lg overflow-hidden rounded-lg border-0 p-0 md:w-full">
                                                <button type="button"
                                                    class="absolute top-4 text-white-dark hover:text-dark ltr:right-4 rtl:left-4"
                                                    @click="addContactModal = false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                        height="24px" viewbox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" class="h-6 w-6">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                </button>
                                                <h3 class="bg-[#fbfbfb] py-3 text-lg font-medium ltr:pl-5 ltr:pr-[50px] rtl:pr-5 rtl:pl-[50px] dark:bg-[#121c2c]"
                                                    x-text="params.id ? 'Edit Contact' : 'Add Contact'"></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>
                    @if (session('success'))
                        <div class="bg-success text-white text-sm p-3 rounded-md mb-5 mt-5">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="panel mt-5 overflow-hidden border-0 p-0">
                        <template x-if="displayType === 'list'">
                            <div class="table-responsive">
                                <table class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Group</th>
                                            <th>Status</th>
                                            <th class="!text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="whitespace-nowrap">{{ $category->group_name }}</td>
                                                <td class="whitespace-nowrap">
                                                    @if ($category->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="flex items-center justify-center gap-4">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('vehicle-categories.edit', $category->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Edit
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <form
                                                            action="{{ route('vehicle-categories.destroy', $category->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </template>
                    </div>
                    <template x-if="displayType === 'grid'">
                        <div class="my-5 grid w-full grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                            <template x-for="contact in filterdContactsList" :key="contact.id">
                                <div
                                    class="relative overflow-hidden rounded-md bg-white text-center shadow dark:bg-[#1c232f]">
                                    <div
                                        class="rounded-t-md bg-white/40 bg-[url('../images/notification-bg.png')] bg-cover bg-center p-6 pb-0">
                                        <template x-if="contact.path">
                                            <img class="mx-auto max-h-40 w-4/5 object-contain"
                                                src="assets/images/user-profile.jpeg">
                                        </template>
                                    </div>
                                    <div class="relative -mt-10 px-6 pb-24">
                                        <div class="rounded-md bg-white px-2 py-4 shadow-md dark:bg-gray-900">
                                            <div class="text-xl" x-text="contact.name"></div>
                                            <div class="text-white-dark" x-text="contact.role"></div>
                                            <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                                                <div class="flex-auto">
                                                    <div class="text-info" x-text="contact.posts"></div>
                                                    <div>Posts</div>
                                                </div>
                                                <div class="flex-auto">
                                                    <div class="text-info" x-text="contact.following"></div>
                                                    <div>Following</div>
                                                </div>
                                                <div class="flex-auto">
                                                    <div class="text-info" x-text="contact.followers"></div>
                                                    <div>Followers</div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <ul
                                                    class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                                                    <li>
                                                        <a href="javascript:;"
                                                            class="btn btn-outline-primary h-7 w-7 rounded-full p-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewbox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="h-4 w-4">
                                                                <path
                                                                    d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;"
                                                            class="btn btn-outline-primary h-7 w-7 rounded-full p-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewbox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="h-4 w-4">
                                                                <rect x="2" y="2" width="20" height="20"
                                                                    rx="5" ry="5"></rect>
                                                                <path
                                                                    d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z">
                                                                </path>
                                                                <line x1="17.5" y1="6.5" x2="17.51"
                                                                    y2="6.5"></line>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;"
                                                            class="btn btn-outline-primary h-7 w-7 rounded-full p-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewbox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="h-4 w-4">
                                                                <path
                                                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                                                </path>
                                                                <rect x="2" y="9" width="4" height="12">
                                                                </rect>
                                                                <circle cx="4" cy="4" r="2"></circle>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;"
                                                            class="btn btn-outline-primary h-7 w-7 rounded-full p-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewbox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="h-4 w-4">
                                                                <path
                                                                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mt-6 grid grid-cols-1 gap-4 ltr:text-left rtl:text-right">
                                            <div class="flex items-center">
                                                <div class="flex-none ltr:mr-2 rtl:ml-2">Email :</div>
                                                <div class="truncate text-white-dark" x-text="contact.email"></div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="flex-none ltr:mr-2 rtl:ml-2">Phone :</div>
                                                <div class="text-white-dark" x-text="contact.phone"></div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="flex-none ltr:mr-2 rtl:ml-2">Address :</div>
                                                <div class="text-white-dark" x-text="contact.location"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-0 mt-6 flex w-full gap-4 p-6 ltr:left-0 rtl:right-0">
                                        <button type="button" class="btn btn-outline-primary w-1/2"
                                            @click="editUser(contact)">Edit</button>
                                        <button type="button" class="btn btn-outline-danger w-1/2"
                                            @click="deleteUser(contact)">Delete</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
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
