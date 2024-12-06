<template>
    <div class="p-6">
        <!-- Pending Returned Books Table -->
        <PendingReturnedBooksTable :returnedBooks="returnedBooks" />
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import Layout from "../Layouts/Layout.vue";
import PendingReturnedBooksTable from "../Components/PendingReturnedBooksTable.vue";

defineOptions({ layout: Layout });

const props = defineProps({
    returnedBooks: {
        type: Array,
        default: () => [],
    }
});
</script>
