<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Return Book Requests</h1>

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
                        Return Qty
                    </th>
                    <th class="border border-gray-300 px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="request in props.books"
                    :key="request.id"
                    class="odd:bg-gray-100 even:bg-white"
                >
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.book_name }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.student_name }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2">
                        {{ request.qty }}
                    </td>
                    <td class="border border-gray-300 px-6 py-2 text-center">
                        <button
                            @click="approveReturnRequest(request)"
                            class="bg-green-500 text-white px-6 py-1 rounded-md hover:bg-green-600"
                        >
                            Approve
                        </button>
                    </td>
                </tr>
                <tr v-if="props.books.length === 0"> 
                    <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                        No return requests found.
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
    books: {
        type: Array,
        default: () => [],
    },
});
onMounted(() => {
    console.log(props.books);
});

const form = useForm({
    id: "",
    user_id: "",
    book_id: "",
    return_qty: "",
});

// Approve return request handler
const approveReturnRequest = (request) => {
    form.id = request.id;
    form.user_id = request.student_id;
    form.book_id = request.book_id;
    form.return_qty = request.qty;
    if (confirm("Approve return request?")) {
        form.post("/dashboard/return_request/approve");
    }
    form.reset();
};
</script>

<style scoped>
/* Optional styling for better appearance */
.container {
    width: 100%;
}
</style>
