<template>
    <div class="p-6">
        <!-- Borrowed Books Table -->
        <RequestBookTable :requestedBooks="requestBooks" @cancel-request="handleCancel"/>
    </div>
</template>

<script setup>
import { ref, defineProps } from "vue";
import Layout from "../Layouts/Layout.vue";
import { useForm } from "@inertiajs/vue3";
import RequestBookTable from "../Components/RequestBookTable.vue";

defineOptions({ layout: Layout });


const props = defineProps({
    requestBooks: {
        type: Array,
        default: () => [],
    }
});


const form = useForm({
    id: 0,
});
const handleCancel = (r_id) => {
    form.id = r_id; 
    
    if(confirm('Are you sure you want to cancel request? ')) {
        form.post('/dashboard/requested_books');
    }
}
</script>
