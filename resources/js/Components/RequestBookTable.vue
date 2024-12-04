<template>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Requested Books</h2>
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-2 text-left border border-gray-300">Book Name</th>
                        <th class="px-6 py-2 text-left border border-gray-300">Request Qty</th>
                        <th class="px-6 py-2 text-left border border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="requested in props.requestedBooks" :key="requested.request_id">
                        <td class="px-6 py-2 border border-gray-300">{{ requested.book_name }}</td>
                        <td class="px-6 py-2 border border-gray-300">{{ requested.request_qty }}</td>
                        <td class="px-6 py-2 border border-gray-300">
                            <button @click="cancelRequest(requested.request_id)" class="bg-blue-500 text-white px-4 py-2 rounded">Cancel</button>
                        </td>
                    </tr>
                    <tr v-if="props.requestedBooks.length === 0"> 
                        <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                            No requested books yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    requestedBooks : {
        type: Array,
        default: () => [],
    }
});

const emit = defineEmits([
    'cancel-request',
])

const cancelRequest = (id) => {
    emit('cancel-request', id);
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
