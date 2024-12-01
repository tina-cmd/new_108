<template>
    <div
        class="min-h-screen flex items-center justify-center bg-black text-white"
    >
        <div class="text-center space-y-6">
            <!-- Title -->
            <h1 class="text-4xl font-bold">
                Welcome to the Library Management System
            </h1>
            <p class="text-lg text-gray-400">
                Manage your library's books, members, and operations seamlessly.
            </p>

            <!-- Buttons -->
            <div class="space-x-4">
                <Link
                    href="/login"
                    class="px-6 py-2 bg-white text-black font-medium rounded-lg shadow-md hover:bg-gray-100 transition"
                >
                    Login
                </Link>
                <Link
                    href="/register"
                    class="px-6 py-2 border border-white text-white font-medium rounded-lg shadow-md hover:bg-gray-800 transition"
                >
                    Register
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
/* Optional customizations */
</style>
