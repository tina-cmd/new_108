<template>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Pending Returned Books</h2>
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-2 text-left border border-gray-300">Book Name</th>
                        <th class="px-6 py-2 text-left border border-gray-300">Return Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="returned in props.returnedBooks" :key="returned.return_id">
                        <td class="px-6 py-2 border border-gray-300">{{ returned.book_name }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ returned.qty }}</td>
                    </tr>
                    <tr v-if="props.returnedBooks.length === 0"> 
                        <td colspan="2" class="border border-gray-300 px-6 py-2 text-center">
                            No pending returned books.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    returnedBooks: {
        type: Array,
        default: () => [],
    }
});
</script>

<style scoped>
table {
    border-collapse: collapse;
}
</style>
