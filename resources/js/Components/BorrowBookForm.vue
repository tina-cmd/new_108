<template>
    <div v-if="isVisible" class="p-4 bg-white shadow-md rounded-md">
        <h3 class="text-lg font-bold mb-4">Borrow a Book</h3>
        <form @submit.prevent="handleBorrow">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1"
                    >Select Book</label
                >
                <select
                    v-model="selectedBook"
                    class="w-full border border-gray-300 rounded-md p-2"
                >
                    <option
                        v-for="book in books"
                        :value="book.id"
                        :key="book.id"
                    >
                        {{ book.name }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Quantity</label>
                <input
                    type="number"
                    v-model="quantity"
                    class="w-full border border-gray-300 rounded-md p-2"
                    placeholder="Enter quantity"
                    min="1"
                />
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
            >
                Borrow
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";

const isVisible = ref(true); // Show/hide the form
const selectedBook = ref("");
const quantity = ref(1);

const books = ref([
    { id: 1, name: "The Great Gatsby" },
    { id: 2, name: "1984" },
    // Add more books as needed
]);

function handleBorrow() {
    alert(
        `Borrowing book ID: ${selectedBook.value}, Quantity: ${quantity.value}`
    );
    // Add logic to submit borrow request to the server
    isVisible.value = false; // Close the form after submission
}
</script>
