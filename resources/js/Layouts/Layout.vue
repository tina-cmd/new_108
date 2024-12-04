<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
// import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/vue3";

const { auth } = usePage().props;

// Reactive reference for sidebar state
const isSidebarOpen = ref(true);

// Computed property to check if the screen size is mobile
const isMobile = computed(() => window.innerWidth < 1024);

// Example user role (this should come from props or API)
const userRole = ref("admin"); // Possible values: "admin", "assistant", "member"

// Method to toggle the sidebar
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Resize handler to auto-show/hide sidebar on larger screens
const handleResize = () => {
    isSidebarOpen.value = window.innerWidth >= 1024; // Auto-show sidebar on larger screens
};

// //logout
// const handleLogout = () => {
//     Inertia.post('/logout');
// };

// Watch for screen resize events and update sidebar state accordingly
onMounted(() => {
    window.addEventListener("resize", handleResize);
    handleResize(); // Initialize the sidebar state based on initial screen size
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize); // Clean up on unmount
});
</script>

<template>
    <Head>
        <title>Library Management System</title>
    </Head>
    <div class="flex min-h-screen bg-gray-200">
        <!-- Sidebar -->
        <div
            class="bg-white shadow-lg flex flex-col transition-all duration-300 ease-in-out transform"
            :class="{ '-translate-x-full': !isSidebarOpen, fixed: isMobile }"
            style="width: 16rem"
        >
            <!-- Header (Name and Info) -->
            <div class="p-4 bg-gray-800 text-white text-center">
                <h1 class="text-xl font-bold">{{ auth.user.name }}</h1>
                <p class="text-sm">{{ auth.user.role }}</p>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 p-4 space-y-2">
                <!-- Conditional Links -->
                <Link
                    v-if="auth.user.role === 'librarian'"
                    href="/dashboard/users"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith('/dashboard/users'),
                    }"
                >
                    Manage Users
                </Link>
                <Link
                    v-if="auth.user.role === 'librarian'"
                    href="/dashboard/books"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith('/dashboard/books'),
                    }"
                >
                    Add Books
                </Link>
                <Link
                    v-if="
                        auth.user.role === 'librarian' ||
                        auth.user.role === 'assistant'
                    "
                    href="/dashboard/inventory"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith('/dashboard/inventory'),
                    }"
                >
                    Book Inventory
                </Link>
                <Link
                    v-if="
                        auth.user.role === 'librarian' ||
                        auth.user.role === 'assistant'
                    "
                    href="/dashboard/borrow_request"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith(
                            '/dashboard/borrow_request'
                        ),
                    }"
                >
                    Borrow Request
                </Link>
                <Link
                    v-if="auth.user.role === 'member'"
                    href="/dashboard/request_book"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith(
                            '/dashboard/request_book'
                        ),
                    }"
                >
                    Request Book
                </Link>

                <Link
                    v-if="auth.user.role === 'member'"
                    href="/dashboard/requested_books"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith(
                            '/dashboard/requested_books'
                        ),
                    }"
                >
                    Requested Books
                </Link>

                <Link
                    href="/dashboard/borrowed_books"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                    :class="{
                        active: $page.url.startsWith(
                            '/dashboard/borrowed_books'
                        ),
                    }"
                >
                    Borrowed Books
                </Link>

                <Link
                    href="/logout"
                    method="post"
                    class="block px-4 py-2 text-left hover:bg-gray-300 rounded-md"
                >
                    Logout
                </Link>
            </nav>

            <!-- Sidebar Toggle for Mobile -->
            <button
                @click="toggleSidebar"
                class="absolute top-2 right-2 bg-gray-800 text-white p-2 rounded-md lg:hidden"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"
                    />
                </svg>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <slot></slot>
        </div>
    </div>
</template>

<style>
.active {
    background-color: rgb(179, 179, 179);
}
</style>
