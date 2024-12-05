<template>
    <div class="p-6">
        <LogsTable :data="logs" />
    </div>
</template>

<script setup>
import Layout from "../Layouts/Layout.vue";
import LogsTable from "../Components/LogsTable.vue";
import { defineProps } from "vue";

const props = defineProps({
    logs: {
        type: Array,
        default: () => [],
    },
});

defineOptions({ layout: Layout });
</script>
