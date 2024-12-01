<script setup>
import { computed, onMounted } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

// Initialize form using useForm
const form = useForm({
    name: "",
    username: "",
    password: "",
    student: false, // Checkbox for student role
});

// Computed property to check form validity
const isFormValid = computed(() => {
    return form.name.trim() && form.username.trim() && form.password.trim();
});

// Handle register action
const handleRegister = () => {
    form.post("/register", {
        onError: (errors) => {
            console.error(errors); // Log errors for debugging
        },
    });
    clearFields();
};

// Clear form fields
const clearFields = () => {
    console.log("clearing input fields");
    form.name = "";
    form.username = "";
    form.password = "";
    form.student = false; // Reset checkbox
};

// Automatically clear fields when the page loads
onMounted(() => {
    clearFields();
});
</script>

<template>
    <Head>
        <title>Register - Library Management System</title>
    </Head>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Register
            </h1>

            <form @submit.prevent="handleRegister" class="space-y-4">
                <!-- Name -->
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        placeholder="Enter your full name"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    />
                    <!-- Error message for name -->
                    <p
                        v-if="form.errors.name"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Username -->
                <div>
                    <label
                        for="username"
                        class="block text-sm font-medium text-gray-700"
                        >Username</label
                    >
                    <input
                        type="text"
                        id="username"
                        v-model="form.username"
                        placeholder="Enter your username"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    />
                    <!-- Error message for username -->
                    <p
                        v-if="form.errors.username"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.username }}
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        v-model="form.password"
                        placeholder="Enter your password"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    />
                    <!-- Error message for password -->
                    <p
                        v-if="form.errors.password"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Student Checkbox -->
                <div>
                    <input
                        type="checkbox"
                        v-model="form.student"
                        name="student"
                        id="student"
                    />
                    <label for="student">Are you a student?</label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-green-600 text-white font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isFormValid"
                >
                    Register
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Additional customizations if needed */
</style>
