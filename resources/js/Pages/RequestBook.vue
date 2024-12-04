<template>
    <div class="flex-1 p-6 max-h-full">
        <h1 class="text-2xl font-bold">Request a Book</h1>

        <!-- Search Bar -->
        <div class="mt-4 flex items-center">
            <input 
                v-model="searchQuery"
                type="text"
                placeholder="Search for a book..."
                class="px-4 py-2 border rounded-md w-full"
            />
            <button 
                @click="performSearch"
                class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                Search
            </button>
        </div>

        <!-- Book Table Section -->
        <div class="mt-4">
            <table class="min-w-full table-auto bg-white border-collapse border border-gray-200 shadow-md">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2 border border-gray-300 text-left">Book Name</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Description</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-gray-50" v-for="record in filteredRecords" :key="record.id">
                        <td class="px-4 py-2 border border-gray-300">{{ record.name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ record.description }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            <button @click="openRequestModal(record)" class="text-green-500 hover:underline">Request</button>
                        </td>
                    </tr>
                    <tr v-if="props.records.length === 0"> 
                        <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                            No books found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Request Modal -->
        <div v-if="isRequesting" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-lg font-bold mb-4">Request Book</h3>
                <form @submit.prevent="requestBook(currentRecord.id)">
                    <p><b>Book name: </b>{{ currentRecord.name }}</p>
                    <div class="mb-4">
                        <label for="request-quantity" class="text-gray-700"><b>Quantity: </b></label>
                        <input
                            id="request-quantity"
                            v-model="form.requestQty"
                            type="number"
                            class="px-4 py-2 border rounded-md w-full"
                            required
                        />
                    </div>
                    <div class="text-center">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Request</button>
                        <button @click="closeRequestModal" type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import Layout from "../Layouts/Layout.vue";
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    records: {
        type: Array,
        default: () => [],
    },
});

// Define the layout using Composition API
defineOptions({ layout: Layout });

const searchQuery = ref("");
const isRequesting = ref(false);
const currentRecord = ref({});

const form = useForm({
    id: 0,
    requestQty: 0,
});


// Filtered records based on search query
const filteredRecords = computed(() => {
    if (!searchQuery.value) {
        return props.records;
    }
    return props.records.filter(record =>
        record.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        record.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const openRequestModal = (record) => {
    isRequesting.value = true;
    currentRecord.value = record;
    requestQty.value = 0;
};

const closeRequestModal = () => {
    isRequesting.value = false;
    currentRecord.value = {};
};

const requestBook = (i_id) => {
    isRequesting.value = false;
    form.id = i_id;
    if(confirm("Sure to request the book?")) {
        form.post('/dashboard/request_book');
    }
};

const performSearch = () => {
    // This function gets triggered every time the search input changes
    console.log("Performing search for:", searchQuery.value);
};
</script>

<style scoped>
/* You can add custom styles here if necessary */
</style>
