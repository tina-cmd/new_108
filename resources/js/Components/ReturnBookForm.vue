<template>
    <div v-if="isVisible" class="p-4 bg-white shadow-md rounded-md">
        <h3 class="text-lg font-bold mb-4">Return a Book</h3>
        <form @submit.prevent="handleReturn">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1"
                    >Select Borrowed Book</label
                >
                <select
                    v-model="selectedBorrowedBook"
                    class="w-full border border-gray-300 rounded-md p-2"
                >
                    <option
                        v-for="borrowed in borrowedBooks"
                        :value="borrowed.id"
                        :key="borrowed.id"
                    >
                        {{ borrowed.bookName }}
                    </option>
                </select>
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
            >
                Return
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";

const isVisible = ref(true); // Show/hide the form
const selectedBorrowedBook = ref("");

const borrowedBooks = ref([
    { id: 1, bookName: "The Great Gatsby", borrowerName: "John Doe" },
    { id: 2, bookName: "1984", borrowerName: "Jane Smith" },
    // Add more borrowed books as needed
]);

function handleReturn() {
    alert(`Returning book ID: ${selectedBorrowedBook.value}`);
    // Add logic to submit return request to the server
    isVisible.value = false; // Close the form after submission
}
</script>
