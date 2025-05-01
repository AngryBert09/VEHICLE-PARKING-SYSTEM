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

        <div class="main-content flex min-h-screen flex-col">
            <!-- start header section -->
            @include('layout.navbar')
            <!-- end header section -->

            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <!-- start main content section -->
                <div x-data="sales">
                    <ul class="flex space-x-2 rtl:space-x-reverse">
                        <li>
                            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
                        </li>
                    </ul>

                    <div class="pt-5">
                        @if (session('success'))
                            <div
                                class="bg-green-500 text-green text-sm p-4 rounded-md mb-5 mt-5 flex items-center justify-between transition-all duration-300 ease-in-out transform hover:scale-105">
                                <div class="flex items-center">
                                    <!-- Success Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                                <!-- Close Button -->
                                <button class="text-white hover:text-gray-200 ml-2 focus:outline-none"
                                    onclick="this.parentElement.style.display='none'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <!-- Recently Parks Section -->
                            <div class="panel h-full w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                                <div class="mb-5 flex items-center justify-between">
                                    <h5 class="text-lg font-semibold text-gray-800 dark:text-white">Recently Parks</h5>
                                </div>
                                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-1">Parking
                                        Overview</h3>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Total Parks:
                                        <span class="text-green-500 font-semibold">{{ $parkings->count() }}</span>
                                    </p>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Total Earnings:
                                        <span class="text-green-500 font-semibold">₱{{ $totalAmount }}</span>
                                    </p>
                                </div>
                                <div class="table-responsive">
                                    <table class="w-full text-left">
                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                                            <tr>
                                                <th class="p-3 rounded-l-md">Parking Code</th>
                                                <th>Vehicle Type</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th class="rounded-r-md">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parkings as $parking)
                                                <tr class="text-gray-800 dark:text-gray-300">
                                                    <td class="text-primary">{{ $parking->parking_code }}</td>
                                                    <td>{{ $parking->vehicle_type }}</td>
                                                    <td>{{ $parking->check_in }}</td>
                                                    <td>{{ $parking->check_out }}</td>
                                                    <td>
                                                        @if ($parking->paid_status == 'paid')
                                                            <span
                                                                class="badge bg-success text-white shadow-md">Paid</span>
                                                        @else
                                                            <span
                                                                class="badge bg-secondary text-black dark:text-gray-300 shadow-md">Unpaid</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Parking Lot Overview Section -->
                            <div class="panel h-full w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Parking Lot
                                        Overview</h3>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Total Parking Slots:
                                        <span class="text-blue-500 font-semibold">{{ $parkingLots->count() }}</span>
                                    </p>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Available Slots:
                                        <span
                                            class="text-green-500 font-semibold">{{ $parkingLots->where('availability', 'Available')->count() }}</span>
                                    </p>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Occupied Slots:
                                        <span
                                            class="text-red-500 font-semibold">{{ $parkingLots->where('availability', 'Occupied')->count() }}</span>
                                    </p>
                                    <p class="text-lg text-gray-600 dark:text-gray-300">
                                        Reserved Slots:
                                        <span
                                            class="text-yellow-500 font-semibold">{{ $parkingLots->where('availability', 'Reserved')->count() }}</span>
                                    </p>
                                </div>
                                <div class="table-responsive">
                                    <table class="w-full text-left">
                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                                            <tr>
                                                <th class="p-3">Slot Name</th>
                                                <th>Status</th>
                                                <th>Availability</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parkingLots as $lot)
                                                <tr class="text-gray-800 dark:text-gray-300">
                                                    <td>{{ $lot->slot_name }}</td>
                                                    <td>
                                                        <span
                                                            class="
                                                            px-2 py-1 rounded-md text-sm font-semibold
                                                            @if ($lot->status === 'inactive') bg-danger text-white
                                                            @elseif ($lot->status === 'active') bg-success text-white
                                                            @else bg-secondary text-black dark:text-gray-300 @endif">
                                                            {{ ucfirst($lot->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="
                                                            px-2 py-1 rounded-md text-sm font-semibold
                                                            @if ($lot->availability === 'Occupied') bg-danger text-white
                                                            @elseif ($lot->availability === 'Reserved') bg-warning text-black
                                                            @elseif ($lot->availability === 'Available') bg-success text-white
                                                            @else bg-secondary text-black dark:text-gray-300 @endif">
                                                            {{ ucfirst($lot->availability) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- end main content section -->
            </div>
        </div>
    </div>

    @include('layout.footerjs')
</body>

</html>
