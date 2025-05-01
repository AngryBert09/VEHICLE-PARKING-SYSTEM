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
                            <a href="javascript:;" class="text-primary hover:underline">Add Parking</a>
                        </li>
                        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                            <span>Add</span>
                        </li>
                    </ul>
                    <div class="grid grid-cols-1 gap-6 pt-5 lg:grid-cols-2">
                        <!-- Stack -->
                        <div class="panel">
                            <div class="mb-5 flex items-center justify-between">
                                <h5 class="text-lg font-semibold dark:text-white-light">Add Parking Vehicle</h5>
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
                                <form class="space-y-5" action="{{ route('parkings.store') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="slot"
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
                                                    data-type="{{ strtolower(trim($category->group_name)) }}">
                                                    {{ $category->group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="rate"
                                            class="block text-sm font-medium text-gray-700">Rate</label>
                                        <select class="form-input" name="rate_id" id="rateSelect" required>
                                            <option value="" disabled selected>Select Rate</option>
                                            @foreach ($rates as $rate)
                                                <option value="{{ $rate->id }}"
                                                    data-type="{{ strtolower(trim($rate->rate_name)) }}">
                                                    {{ $rate->rate_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <!-- Cancel button (redirects to categories list or previous page) -->
                                        <a href="{{ route('parkings.index') }}" class="btn btn-secondary">Cancel</a>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const categorySelect = document.getElementById('categorySelect');
                                        const rateSelect = document.getElementById('rateSelect');

                                        // Store all rate options initially
                                        const allRateOptions = Array.from(rateSelect.querySelectorAll('option[data-type]'));

                                        // Log all rates' data-types on page load for verification
                                        console.log('All Rate Options:', allRateOptions.map(rate => ({
                                            text: rate.textContent.trim(),
                                            type: rate.getAttribute('data-type')
                                        })));

                                        categorySelect.addEventListener('change', function() {
                                            // Log all category options and their data-type to verify
                                            Array.from(categorySelect.options).forEach(option => {
                                                console.log('Category Option:', option.textContent, 'Data-Type:', option
                                                    .getAttribute('data-type'));
                                            });

                                            // Get the selected category's data-type and normalize it (remove spaces and convert to lowercase)
                                            const selectedCategoryType = categorySelect.options[categorySelect.selectedIndex]
                                                ?.getAttribute('data-type')?.trim().toLowerCase().replace(/\s+/g, '');

                                            // Log the selected category's text and normalized data-type
                                            const selectedCategoryText = categorySelect.options[categorySelect.selectedIndex]
                                                ?.textContent.trim();
                                            console.log('Selected Category:', selectedCategoryText);
                                            console.log('Normalized Selected Category Data-Type:', selectedCategoryType);

                                            // Reset the rate select options
                                            rateSelect.innerHTML = '<option value="" disabled selected>Select Rate</option>';

                                            // Filter and append matching rates based on substring match
                                            allRateOptions.forEach(rate => {
                                                const rateType = rate.getAttribute('data-type')?.trim().toLowerCase().replace(
                                                    /\s+/g, '');
                                                console.log('Normalized Rate Type:', rateType);

                                                // Match the selected category's data-type as a substring within the rate's data-type
                                                if (rateType.includes(selectedCategoryType)) {
                                                    const newOption = rate.cloneNode(true);
                                                    rateSelect.appendChild(newOption);
                                                }
                                            });

                                            // Log the filtered rates
                                            console.log('Filtered Rates:', Array.from(rateSelect.options).map(option => option
                                                .textContent));
                                        });
                                    });
                                </script>







                            </div>
                        </div>



                        <!-- end main content section -->

                    </div>


                </div>
            </div>

            @include('layout.footerjs')
            <!-- start hightlight js -->
            <link rel="stylesheet" href="css/highlight.min.css">
            <script src="js/highlight.min.js">
                < /> <!--end hightlight js-- >

                <
                script >
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
                                if (document.body.scrollTop > 50 || document.documentElement.scrollTop >
                                    50) {
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
                                const selector = document.querySelector(
                                    '.sidebar ul a[href="' + window.location
                                    .pathname + '"]'
                                );
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
                    }); <
                /> < /
                body >

                    <
                    /html>
