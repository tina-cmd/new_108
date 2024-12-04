<template>
    <div class="max-h-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">User Management</h2>
        <table class="min-w-full rounded-md border border-gray-300">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="user in sortedUsers"
                    :key="user.id"
                    class="odd:bg-white even:bg-gray-100"
                >
                    <td class="px-4 py-2 border">{{ user.name }}</td>
                    <td class="px-4 py-2 border">{{ user.username }}</td>
                    <td class="px-4 py-2 border">
                        <span v-if="user.role === 'librarian'">Librarian</span>
                        <select
                            v-else
                            v-model="user.role"
                            class="border rounded p-1"
                            @change="confirmUpdate(user)"
                        >
                            <option value="assistant">Assistant</option>
                            <option value="member">Member</option>
                        </select>
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <button
                            v-if="user.role !== 'librarian'"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 mr-2"
                            @click="confirmDelete(user.id)"
                        >
                            Delete
                        </button>
                        <span v-else class="text-gray-500 italic">
                            Actions Restricted
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

// Props for users array
const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

// // Define the order for sorting roles
const order = ["librarian", "assistant", "member"];

// // Sort function to compare users by role
const sortRoles = (userA, userB) => {
    return order.indexOf(userA.role) - order.indexOf(userB.role);
};

// // Compute sorted users based on roles
const sortedUsers = computed(() => {
    return [...props.users].sort(sortRoles);
});

const del = useForm({});

// Function to handle the delete action with confirmation
const confirmDelete = (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
        deleteUser(id);
    }
};

// Function to delete a user
const deleteUser = (id) => {
    del.delete(`/dashboard/users/${id}`);
};

const up = useForm({
    role: "",
});

const confirmUpdate = (user) => {
    if (confirm("Are you sure you want to update this user?")) {
        up.role = user.role;
        updateRole(user);
    }
};
// Function to handle role updates
const updateRole = (user) => {
    up.put(`/dashboard/users/${user.id}`);
};
</script>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}
th,
td {
    text-align: left;
}
</style>
