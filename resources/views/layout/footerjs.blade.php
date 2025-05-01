 <!-- Include JavaScript Assets -->
 <script src="{{ asset('js/alpine-collapse.min.js') }}"></script>
 <script src="{{ asset('js/alpine-persist.min.js') }}"></script>
 <script defer src="{{ asset('js/alpine-ui.min.js') }}"></script>
 <script defer src="{{ asset('js/alpine-focus.min.js') }}"></script>
 <script defer src="{{ asset('js/alpine.min.js') }}"></script>
 <script src="{{ asset('js/custom.js') }}"></script>
 <script defer src="{{ asset('js/apexcharts.js') }}"></script>


 <script>
     document.addEventListener("alpine:init", () => {
         // main section
         Alpine.data("scrollToTop", () => ({
             showTopButton: false,
             init() {
                 window.onscroll = () => {
                     this.scrollFunction();
                 };
             },

             scrollFunction() {
                 if (
                     document.body.scrollTop > 50 ||
                     document.documentElement.scrollTop > 50
                 ) {
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
         Alpine.data("customizer", () => ({
             showCustomizer: false,
         }));

         // sidebar section
         Alpine.data("sidebar", () => ({
             init() {
                 const selector = document.querySelector(
                     '.sidebar ul a[href="' + window.location.pathname + '"]'
                 );
                 if (selector) {
                     selector.classList.add("active");
                     const ul = selector.closest("ul.sub-menu");
                     if (ul) {
                         let ele = ul.closest("li.menu").querySelectorAll(".nav-link");
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

         Alpine.data("header", () => ({
             init() {
                 const selector = document.querySelector(
                     'ul.horizontal-menu a[href="' + window.location.pathname + '"]'
                 );
                 if (selector) {
                     selector.classList.add("active");
                     const ul = selector.closest("ul.sub-menu");
                     if (ul) {
                         let ele = ul.closest("li.menu").querySelectorAll(".nav-link");
                         if (ele) {
                             ele = ele[0];
                             setTimeout(() => {
                                 ele.classList.add("active");
                             });
                         }
                     }
                 }

                 // Fetch notifications when the component is initialized
                 this.fetchNotifications();
             },

             messages: [{
                     id: 1,
                     image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-success-light dark:bg-success text-success dark:text-success-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>',
                     title: "Congratulations!",
                     message: "Your OS has been updated.",
                     time: "1hr",
                 },
                 {
                     id: 2,
                     image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-info-light dark:bg-info text-info dark:text-info-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>',
                     title: "Did you know?",
                     message: "You can switch between artboards.",
                     time: "2hr",
                 },
                 {
                     id: 3,
                     image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-danger-light dark:bg-danger text-danger dark:text-danger-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>',
                     title: "Something went wrong!",
                     message: "Send Report",
                     time: "2days",
                 },
                 {
                     id: 4,
                     image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-warning-light dark:bg-warning text-warning dark:text-warning-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg></span>',
                     title: "Warning",
                     message: "Your password strength is low.",
                     time: "5days",
                 },
             ],

             languages: [{
                     id: 1,
                     key: "Khmer",
                     value: "kh"
                 },
                 {
                     id: 2,
                     key: "Danish",
                     value: "da"
                 },
                 {
                     id: 3,
                     key: "English",
                     value: "en"
                 },
                 {
                     id: 4,
                     key: "French",
                     value: "fr"
                 },
                 {
                     id: 5,
                     key: "German",
                     value: "de"
                 },
                 {
                     id: 6,
                     key: "Greek",
                     value: "el"
                 },
                 {
                     id: 7,
                     key: "Hungarian",
                     value: "hu"
                 },
                 {
                     id: 8,
                     key: "Italian",
                     value: "it"
                 },
                 {
                     id: 9,
                     key: "Japanese",
                     value: "ja"
                 },
                 {
                     id: 10,
                     key: "Polish",
                     value: "pl"
                 },
                 {
                     id: 11,
                     key: "Portuguese",
                     value: "pt"
                 },
                 {
                     id: 12,
                     key: "Russian",
                     value: "ru"
                 },
                 {
                     id: 13,
                     key: "Spanish",
                     value: "es"
                 },
                 {
                     id: 14,
                     key: "Swedish",
                     value: "sv"
                 },
                 {
                     id: 15,
                     key: "Turkish",
                     value: "tr"
                 },
                 {
                     id: 16,
                     key: "Arabic",
                     value: "ae"
                 },
             ],

             notifications: [], // Define the notifications array

             async fetchNotifications() {
                 console.log('Fetching notifications...');
                 try {
                     const response = await fetch('/notifications'); // Your route URL here
                     const data = await response.json();
                     console.log('Notifications fetched:', data.notifications);
                     this.notifications = data.notifications; // Populate notifications
                 } catch (error) {
                     console.error('Error fetching notifications:', error);
                 }
             },

             removeNotification(value) {
                 console.log('Removing notification with id:', value);
                 this.notifications = this.notifications.filter((d) => d.id !== value);
                 console.log('Updated notifications:', this.notifications);
             },

             removeMessage(value) {
                 this.messages = this.messages.filter((d) => d.id !== value);
             },
         }));



         // content section
         Alpine.data("sales", () => ({
             init() {
                 isDark =
                     this.$store.app.theme === "dark" || this.$store.app.isDarkMode ?
                     true :
                     false;
                 isRtl = this.$store.app.rtlClass === "rtl" ? true : false;

                 const revenueChart = null;
                 const salesByCategory = null;
                 const dailySales = null;
                 const totalOrders = null;

                 // revenue
                 setTimeout(() => {
                     this.revenueChart = new ApexCharts(
                         this.$refs.revenueChart,
                         this.revenueChartOptions
                     );
                     this.$refs.revenueChart.innerHTML = "";
                     this.revenueChart.render();

                     // sales by category
                     this.salesByCategory = new ApexCharts(
                         this.$refs.salesByCategory,
                         this.salesByCategoryOptions
                     );
                     this.$refs.salesByCategory.innerHTML = "";
                     this.salesByCategory.render();

                     // daily sales
                     this.dailySales = new ApexCharts(
                         this.$refs.dailySales,
                         this.dailySalesOptions
                     );
                     this.$refs.dailySales.innerHTML = "";
                     this.dailySales.render();

                     // total orders
                     this.totalOrders = new ApexCharts(
                         this.$refs.totalOrders,
                         this.totalOrdersOptions
                     );
                     this.$refs.totalOrders.innerHTML = "";
                     this.totalOrders.render();
                 }, 300);

                 this.$watch("$store.app.theme", () => {
                     isDark =
                         this.$store.app.theme === "dark" || this.$store.app.isDarkMode ?
                         true :
                         false;

                     this.revenueChart.updateOptions(this.revenueChartOptions);
                     this.salesByCategory.updateOptions(this.salesByCategoryOptions);
                     this.dailySales.updateOptions(this.dailySalesOptions);
                     this.totalOrders.updateOptions(this.totalOrdersOptions);
                 });

                 this.$watch("$store.app.rtlClass", () => {
                     isRtl = this.$store.app.rtlClass === "rtl" ? true : false;
                     this.revenueChart.updateOptions(this.revenueChartOptions);
                 });
             },

             // revenue
             get revenueChartOptions() {
                 return {
                     series: [{
                             name: "Income",
                             data: [
                                 16800, 16800, 15500, 17800, 15500, 17000, 19000, 16000,
                                 15000, 17000, 14000, 17000,
                             ],
                         },
                         {
                             name: "Expenses",
                             data: [
                                 16500, 17500, 16200, 17300, 16000, 19500, 16000, 17000,
                                 16000, 19000, 18000, 19000,
                             ],
                         },
                     ],
                     chart: {
                         height: 325,
                         type: "area",
                         fontFamily: "Nunito, sans-serif",
                         zoom: {
                             enabled: false,
                         },
                         toolbar: {
                             show: false,
                         },
                     },
                     dataLabels: {
                         enabled: false,
                     },
                     stroke: {
                         show: true,
                         curve: "smooth",
                         width: 2,
                         lineCap: "square",
                     },
                     dropShadow: {
                         enabled: true,
                         opacity: 0.2,
                         blur: 10,
                         left: -7,
                         top: 22,
                     },
                     colors: isDark ? ["#2196f3", "#e7515a"] : ["#1b55e2", "#e7515a"],
                     markers: {
                         discrete: [{
                                 seriesIndex: 0,
                                 dataPointIndex: 6,
                                 fillColor: "#1b55e2",
                                 strokeColor: "transparent",
                                 size: 7,
                             },
                             {
                                 seriesIndex: 1,
                                 dataPointIndex: 5,
                                 fillColor: "#e7515a",
                                 strokeColor: "transparent",
                                 size: 7,
                             },
                         ],
                     },
                     labels: [
                         "Jan",
                         "Feb",
                         "Mar",
                         "Apr",
                         "May",
                         "Jun",
                         "Jul",
                         "Aug",
                         "Sep",
                         "Oct",
                         "Nov",
                         "Dec",
                     ],
                     xaxis: {
                         axisBorder: {
                             show: false,
                         },
                         axisTicks: {
                             show: false,
                         },
                         crosshairs: {
                             show: true,
                         },
                         labels: {
                             offsetX: isRtl ? 2 : 0,
                             offsetY: 5,
                             style: {
                                 fontSize: "12px",
                                 cssClass: "apexcharts-xaxis-title",
                             },
                         },
                     },
                     yaxis: {
                         tickAmount: 7,
                         labels: {
                             formatter: (value) => {
                                 return value / 1000 + "K";
                             },
                             offsetX: isRtl ? -30 : -10,
                             offsetY: 0,
                             style: {
                                 fontSize: "12px",
                                 cssClass: "apexcharts-yaxis-title",
                             },
                         },
                         opposite: isRtl ? true : false,
                     },
                     grid: {
                         borderColor: isDark ? "#191e3a" : "#e0e6ed",
                         strokeDashArray: 5,
                         xaxis: {
                             lines: {
                                 show: true,
                             },
                         },
                         yaxis: {
                             lines: {
                                 show: false,
                             },
                         },
                         padding: {
                             top: 0,
                             right: 0,
                             bottom: 0,
                             left: 0,
                         },
                     },
                     legend: {
                         position: "top",
                         horizontalAlign: "right",
                         fontSize: "16px",
                         markers: {
                             width: 10,
                             height: 10,
                             offsetX: -2,
                         },
                         itemMargin: {
                             horizontal: 10,
                             vertical: 5,
                         },
                     },
                     tooltip: {
                         marker: {
                             show: true,
                         },
                         x: {
                             show: false,
                         },
                     },
                     fill: {
                         type: "gradient",
                         gradient: {
                             shadeIntensity: 1,
                             inverseColors: !1,
                             opacityFrom: isDark ? 0.19 : 0.28,
                             opacityTo: 0.05,
                             stops: isDark ? [100, 100] : [45, 100],
                         },
                     },
                 };
             },

             // sales by category
             get salesByCategoryOptions() {
                 return {
                     series: [985, 737, 270],
                     chart: {
                         type: "donut",
                         height: 460,
                         fontFamily: "Nunito, sans-serif",
                     },
                     dataLabels: {
                         enabled: false,
                     },
                     stroke: {
                         show: true,
                         width: 25,
                         colors: isDark ? "#0e1726" : "#fff",
                     },
                     colors: isDark ? ["#5c1ac3", "#e2a03f", "#e7515a", "#e2a03f"] : ["#e2a03f",
                         "#5c1ac3", "#e7515a"
                     ],
                     legend: {
                         position: "bottom",
                         horizontalAlign: "center",
                         fontSize: "14px",
                         markers: {
                             width: 10,
                             height: 10,
                             offsetX: -2,
                         },
                         height: 50,
                         offsetY: 20,
                     },
                     plotOptions: {
                         pie: {
                             donut: {
                                 size: "65%",
                                 background: "transparent",
                                 labels: {
                                     show: true,
                                     name: {
                                         show: true,
                                         fontSize: "29px",
                                         offsetY: -10,
                                     },
                                     value: {
                                         show: true,
                                         fontSize: "26px",
                                         color: isDark ? "#bfc9d4" : undefined,
                                         offsetY: 16,
                                         formatter: (val) => {
                                             return val;
                                         },
                                     },
                                     total: {
                                         show: true,
                                         label: "Total",
                                         color: "#888ea8",
                                         fontSize: "29px",
                                         formatter: (w) => {
                                             return w.globals.seriesTotals.reduce(function(a,
                                                 b) {
                                                 return a + b;
                                             }, 0);
                                         },
                                     },
                                 },
                             },
                         },
                     },
                     labels: ["Apparel", "Sports", "Others"],
                     states: {
                         hover: {
                             filter: {
                                 type: "none",
                                 value: 0.15,
                             },
                         },
                         active: {
                             filter: {
                                 type: "none",
                                 value: 0.15,
                             },
                         },
                     },
                 };
             },

             // daily sales
             get dailySalesOptions() {
                 return {
                     series: [{
                             name: "Sales",
                             data: [44, 55, 41, 67, 22, 43, 21],
                         },
                         {
                             name: "Last Week",
                             data: [13, 23, 20, 8, 13, 27, 33],
                         },
                     ],
                     chart: {
                         height: 160,
                         type: "bar",
                         fontFamily: "Nunito, sans-serif",
                         toolbar: {
                             show: false,
                         },
                         stacked: true,
                         stackType: "100%",
                     },
                     dataLabels: {
                         enabled: false,
                     },
                     stroke: {
                         show: true,
                         width: 1,
                     },
                     colors: ["#e2a03f", "#e0e6ed"],
                     responsive: [{
                         breakpoint: 480,
                         options: {
                             legend: {
                                 position: "bottom",
                                 offsetX: -10,
                                 offsetY: 0,
                             },
                         },
                     }, ],
                     xaxis: {
                         labels: {
                             show: false,
                         },
                         categories: ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"],
                     },
                     yaxis: {
                         show: false,
                     },
                     fill: {
                         opacity: 1,
                     },
                     plotOptions: {
                         bar: {
                             horizontal: false,
                             columnWidth: "25%",
                         },
                     },
                     legend: {
                         show: false,
                     },
                     grid: {
                         show: false,
                         xaxis: {
                             lines: {
                                 show: false,
                             },
                         },
                         padding: {
                             top: 10,
                             right: -20,
                             bottom: -20,
                             left: -20,
                         },
                     },
                 };
             },

             // total orders
             get totalOrdersOptions() {
                 return {
                     series: [{
                         name: "Sales",
                         data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40],
                     }, ],
                     chart: {
                         height: 290,
                         type: "area",
                         fontFamily: "Nunito, sans-serif",
                         sparkline: {
                             enabled: true,
                         },
                     },
                     stroke: {
                         curve: "smooth",
                         width: 2,
                     },
                     colors: isDark ? ["#00ab55"] : ["#00ab55"],
                     labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
                     yaxis: {
                         min: 0,
                         show: false,
                     },
                     grid: {
                         padding: {
                             top: 125,
                             right: 0,
                             bottom: 0,
                             left: 0,
                         },
                     },
                     fill: {
                         opacity: 1,
                         type: "gradient",
                         gradient: {
                             type: "vertical",
                             shadeIntensity: 1,
                             inverseColors: !1,
                             opacityFrom: 0.3,
                             opacityTo: 0.05,
                             stops: [100, 100],
                         },
                     },
                     tooltip: {
                         x: {
                             show: false,
                         },
                     },
                 };
             },
         }));

         Alpine.data('chat', () => ({
             isShowUserChat: false,
             isShowChatMenu: false,
             loginUser: {
                 id: 0,
                 name: 'Alon Smith',
                 path: 'profile-34.jpeg',
                 designation: 'Software Developer',
             },
             contactList: [{
                     userId: 1,
                     name: 'Nia Hillyer',
                     path: 'profile-16.jpeg',
                     time: '2:09 PM',
                     preview: 'How do you do?',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 1,
                             text: 'Hi, I am back from vacation',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 1,
                             text: 'How are you?',
                         },
                         {
                             fromUserId: 1,
                             toUserId: 0,
                             text: 'Welcom Back',
                         },
                         {
                             fromUserId: 1,
                             toUserId: 0,
                             text: 'I am all well',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 1,
                             text: 'Coffee?',
                         },
                     ],
                     active: true,
                 },
                 {
                     userId: 2,
                     name: 'Sean Freeman',
                     path: 'profile-1.jpeg',
                     time: '12:09 PM',
                     preview: 'I was wondering...',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 2,
                             text: 'Hello',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 2,
                             text: "It's me",
                         },
                         {
                             fromUserId: 0,
                             toUserId: 2,
                             text: 'I have a question regarding project.',
                         },
                     ],
                     active: false,
                 },
                 {
                     userId: 3,
                     name: 'Alma Clarke',
                     path: 'profile-2.jpeg',
                     time: '1:44 PM',
                     preview: 'I’ve forgotten how it felt before',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 3,
                             text: 'Hey Buddy.',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 3,
                             text: "What's up",
                         },
                         {
                             fromUserId: 3,
                             toUserId: 0,
                             text: 'I am sick',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 3,
                             text: 'Not comming to office today.',
                         },
                     ],
                     active: true,
                 },
                 {
                     userId: 4,
                     name: 'StarCode Kh',
                     path: 'profile-3.jpeg',
                     time: '2:06 PM',
                     preview: 'But we’re probably gonna need a new carpet.',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 4,
                             text: 'Hi, collect your check',
                         },
                         {
                             fromUserId: 4,
                             toUserId: 0,
                             text: 'Ok, I will be there in 10 mins',
                         },
                     ],
                     active: true,
                 },
                 {
                     userId: 5,
                     name: 'StarCode Kh',
                     path: 'profile-4.jpeg',
                     time: '2:05 PM',
                     preview: 'It’s not that bad...',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 3,
                             text: 'Hi, I am back from vacation',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 3,
                             text: 'How are you?',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 5,
                             text: 'Welcom Back',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 5,
                             text: 'I am all well',
                         },
                         {
                             fromUserId: 5,
                             toUserId: 0,
                             text: 'Coffee?',
                         },
                     ],
                     active: false,
                 },
                 {
                     userId: 6,
                     name: 'Roxanne',
                     path: 'profile-5.jpeg',
                     time: '2:00 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [{
                             fromUserId: 0,
                             toUserId: 6,
                             text: 'Hi',
                         },
                         {
                             fromUserId: 0,
                             toUserId: 6,
                             text: 'Uploaded files to server.',
                         },
                     ],
                     active: false,
                 },
                 {
                     userId: 7,
                     name: 'Ernest Reeves',
                     path: 'profile-6.jpeg',
                     time: '2:09 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: true,
                 },
                 {
                     userId: 8,
                     name: 'Laurie Fox',
                     path: 'profile-7.jpeg',
                     time: '12:09 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: true,
                 },
                 {
                     userId: 9,
                     name: 'Xavier',
                     path: 'profile-8.jpeg',
                     time: '4:09 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: false,
                 },
                 {
                     userId: 10,
                     name: 'Susan Phillips',
                     path: 'profile-9.jpeg',
                     time: '9:00 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: true,
                 },
                 {
                     userId: 11,
                     name: 'Dale Butler',
                     path: 'profile-10.jpeg',
                     time: '5:09 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: false,
                 },
                 {
                     userId: 12,
                     name: 'Grace Roberts',
                     path: 'user-profile.jpeg',
                     time: '8:01 PM',
                     preview: 'Wasup for the third time like is you bling bitch',
                     messages: [],
                     active: true,
                 },
             ],
             searchUser: '',
             textMessage: '',
             selectedUser: '',

             get searchUsers() {
                 setTimeout(() => {
                     const element = document.querySelector('.chat-users');
                     element.scrollTop = 0;
                     element.behavior = 'smooth';
                 });
                 return this.contactList.filter((d) => {
                     return d.name.toLowerCase().includes(this.searchUser);
                 });
             },

             selectUser(user) {
                 this.selectedUser = user;
                 this.isShowUserChat = true;
                 this.scrollToBottom;
                 this.isShowChatMenu = false;
             },

             sendMessage() {
                 if (this.textMessage.trim()) {
                     const user = this.contactList.find((d) => d.userId === this.selectedUser
                         .userId);
                     user.messages.push({
                         fromUserId: this.selectedUser.userId,
                         toUserId: 0,
                         text: this.textMessage,
                         time: 'Just now',
                     });
                     this.textMessage = '';
                     this.scrollToBottom;
                 }
             },

             get scrollToBottom() {
                 if (this.isShowUserChat) {
                     setTimeout(() => {
                         const element = document.querySelector(
                             '.chat-conversation-box');
                         element.scrollIntoView({
                             behavior: 'smooth',
                             block: 'end',
                         });
                     });
                 }
             },
         }));
     });
 </script>
