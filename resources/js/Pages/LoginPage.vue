<script setup>
import { computed, onMounted, defineProps } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
// import { usePage } from "@inertiajs/vue3";

// const {error} = usePage().props.value;

const props = defineProps({
    error: String,
});

// Initialize form using useForm
const form = useForm({
    username: "",
    password: "",
    role: "",
    remember: false,
});

// Computed property to check form validity
const isFormValid = computed(() => {
    return form.username && form.password && form.role;
});

// Handle login action
const handleLogin = () => {
    // alert(`creds: ${form.username} ${form.password} ${form.role}`);

    form.post("/login", {
        onError: (errors) => {
            console.error(errors); // Log errors for debugging
        },
    });
    clearFields();
};

onMounted(() => {
    clearFields();
});

const clearFields = () => {
    console.log("clearing input fields");
    form.username = "";
    form.password = "";
    form.role = "";
    form.remember = false;
};
</script>

<template>
    <Head>
        <title>Library Management System</title>
    </Head>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Login
            </h1>

            <form @submit.prevent="handleLogin" class="space-y-4">
                <!-- Username -->
                <div>
                    <p v-if="error" class="text-center text-red-900">
                        {{ error }}
                    </p>

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

                <!-- Role Selection -->
                <div>
                    <label
                        for="role"
                        class="block text-sm font-medium text-gray-700"
                        >Select Role</label
                    >
                    <select
                        id="role"
                        v-model="form.role"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="" disabled>Select a role</option>
                        <option value="librarian">Librarian</option>
                        <option value="assistant">Assistant</option>
                        <option value="member">Member</option>
                    </select>
                    <!-- Error message for role -->
                    <p
                        v-if="form.errors.role"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.role }}
                    </p>
                    <p v-if="error"></p>
                </div>
                <div>
                    <input
                        type="checkbox"
                        v-model="form.remember"
                        name="remember"
                        id="remember"
                    />
                    <label for="remember">Remember Me</label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-medium rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isFormValid"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Additional customizations if needed */
</style>
