<template>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Borrowed Books</h2>
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-2 text-left border border-gray-300">Book Name</th>
                        <th class="px-6 py-2 text-left border border-gray-300">Borrow Qty</th>
                        <th class="px-6 py-2 text-left border border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="borrowed in props.borrowedBooks" :key="borrowed.id">
                        <td class="px-6 py-2 border border-gray-300">{{ borrowed.book_name }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ borrowed.qty }}</td>
                        <td class="px-6 py-2 border border-gray-300">
                            <button @click="returnBook(borrowed.id, borrowed.inventory_id, borrowed.qty)" class="bg-blue-500 text-white px-4 py-2 rounded">Return</button>
                        </td>
                    </tr>
                    <tr v-if="props.borrowedBooks.length === 0"> 
                        <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                            No borrowed books yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from "vue";

const props = defineProps({
    borrowedBooks : {
        type: Array,
        default: () => [],
    }
});

const emit = defineEmits([
    'return-book',
])

const returnBook = (b_id, i_id, qty) => {
    emit('return-book', b_id, i_id, qty);
};
</script>

<style scoped>
table {
    border-collapse: collapse;
}
button {
    cursor: pointer;
}
</style>
