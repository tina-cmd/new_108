<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">Borrowed Books</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700 border-b">Book Name</th>
                        <th class="px-6 py-2 text-left text-sm font-medium text-gray-700 border-b">Borrower</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="borrowed in borrowedBooks" :key="borrowed.id">
                        <td class="px-6 py-2 border-b">{{ borrowed.bookName }}</td>
                        <td class="px-6 py-2 border-b">{{ borrowed.borrowerName }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const borrowedBooks = ref([
    { id: 1, bookName: "The Great Gatsby", borrowerName: "John Doe" },
    { id: 2, bookName: "1984", borrowerName: "Jane Smith" },
    // Add more borrowed books as needed
]);
</script>

<style scoped>
table {
    border-collapse: collapse;
}
</style>
