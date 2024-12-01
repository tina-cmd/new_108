<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Borrow Requests</h1>

        <table
            class="table-auto w-full border-collapse border border-gray-300 shadow-lg"
        >
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Book Name</th>
                    <th class="border border-gray-300 px-4 py-2">
                        Borrower Name
                    </th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(request, index) in borrowRequests"
                    :key="index"
                    class="odd:bg-gray-100 even:bg-white"
                >
                    <td class="border border-gray-300 px-4 py-2">
                        {{ request.bookName }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ request.borrowerName }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <button
                            @click="approveRequest(index)"
                            class="bg-green-500 text-white px-4 py-1 rounded-md hover:bg-green-600"
                        >
                            Approve
                        </button>
                        <button
                            @click="declineRequest(index)"
                            class="bg-red-500 text-white px-4 py-1 rounded-md ml-2 hover:bg-red-600"
                        >
                            Decline
                        </button>
                    </td>
                </tr>
                <tr v-if="borrowRequests.length === 0">
                    <td
                        colspan="3"
                        class="border border-gray-300 px-4 py-2 text-center text-gray-500"
                    >
                        No borrow requests available.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Layout from "../Layouts/Layout.vue";

defineOptions({ layout: Layout });

// Sample data for borrow requests
const borrowRequests = ref([
    { bookName: "The Great Gatsby", borrowerName: "John Doe" },
    { bookName: "1984", borrowerName: "Jane Smith" },
    { bookName: "To Kill a Mockingbird", borrowerName: "Alice Johnson" },
]);

// Approve request handler
const approveRequest = (index) => {
    const request = borrowRequests.value[index];
    alert(
        `Approved: ${request.borrowerName}'s request for "${request.bookName}"`
    );
    borrowRequests.value.splice(index, 1); // Remove the approved request
};

// Decline request handler
const declineRequest = (index) => {
    const request = borrowRequests.value[index];
    alert(
        `Declined: ${request.borrowerName}'s request for "${request.bookName}"`
    );
    borrowRequests.value.splice(index, 1); // Remove the declined request
};
</script>

<style scoped>
/* Optional styling for better appearance */
.container {
    width: 100%;
}
</style>
