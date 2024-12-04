<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Borrow Requests</h1>

        <table
            class="table-auto w-full border border-white shadow-lg"
        >
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border border-gray-300 px-6 py-2">Book Name</th>
                    <th class="border border-gray-300 px-6 py-2">
                        Borrower Name
                    </th>
                    <th class="border border-gray-300 px-6 py-2">
                        Request Qty
                    </th>
                    <th class="border border-gray-300 px-6 py-2">
                        Inventory Qty
                    </th>
                    <th class="border border-gray-300 px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="request in props.borrowRequests"
                    :key="request.request_id"
                    class="odd:bg-gray-100 even:bg-white"
                >
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.book_name }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.user_name }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.request_qty }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.available_qty }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2 text-center">
                        <button
                            @click="approveRequest(request)"
                            class="bg-green-500 text-white px-6 py-1 rounded-md hover:bg-green-600"
                        >
                            Approve
                        </button>
                        <button
                            @click="declineRequest(request.request_id)"
                            class="bg-red-500 text-white px-6 py-1 rounded-md ml-2 hover:bg-red-600"
                        >
                            Decline
                        </button>
                    </td>
                </tr>
                <tr v-if="props.borrowRequests.length === 0"> 
                    <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                        No borrow requests found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, defineProps, onMounted } from "vue";
import Layout from "../Layouts/Layout.vue";
import { useForm } from "@inertiajs/vue3";

defineOptions({ layout: Layout });

const props = defineProps({
    borrowRequests: {
        type: Array,
        default: () => [],
    },
});
onMounted(() => {
    console.log(props.borrowRequests);
});

const form = useForm({
    request_id: "",
    user_id: "",
    book_id: "",
    inventory_id: "",
    request_qty: "",
});
// Approve request handler
const approveRequest = (index) => {
    form.request_id = index.request_id;
    form.user_id = index.user_id;
    form.book_id = index.book_id;
    form.inventory_id = index.inventory_id;
    form.request_qty = index.request_qty;
    if (confirm("Approve request?")) {
        form.post("/dashboard/borrow_request/approve");
    }
    form.reset();
};


const dec = useForm({
    id: 0,
});

// Decline request handler
const declineRequest = (index) => {
    dec.id = index;
    if (confirm("Decline request?")) {
        dec.post("/dashboard/borrow_request/decline");
    }
    dec.reset();
};
</script>

<style scoped>
/* Optional styling for better appearance */
.container {
    width: 100%;
}
</style>
