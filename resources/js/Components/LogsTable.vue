<template>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">System Logs</h2>
        <div class="overflow-y-auto">
            <table class="w-full bg-white border border-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Table Name
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Action
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Record ID
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Affected Columns
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Performed By
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Log Date
                        </th>
                        <th class="px-6 py-2 text-left border border-gray-300">
                            Log Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log in props.data" :key="log.id">
                        <td class="px-6 py-2 border border-gray-300">
                            {{ log.table_name }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ log.action }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ log.record_id }}
                        </td>
                        <td
                            class="px-6 py-2 border border-gray-300 break-words"
                        >
                            {{ log.affected_columns }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ log.performed_by }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ formatDate(log.log_time).date }}
                        </td>
                        <td class="px-6 py-2 border border-gray-300">
                            {{ formatDate(log.log_time).time }}
                        </td>
                    </tr>
                    <tr v-if="props.data.length === 0">
                        <td
                            colspan="6"
                            class="border border-gray-300 px-6 py-2 text-center"
                        >
                            No logs available.
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
    data: {
        type: Array,
        default: () => [],
    },
});

// Format the timestamp to a more readable format
const formatDate = (timestamp) => {
    const date = new Date(timestamp);

    // Get the date in the format: January 23, 2024
    const dateOptions = { year: "numeric", month: "long", day: "numeric" };
    const formattedDate = date.toLocaleDateString("en-US", dateOptions);

    // Get the time in the format: 14:30:00
    const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    };
    const formattedTime = date.toLocaleTimeString("en-US", timeOptions);

    return { date: formattedDate, time: formattedTime };
};

// Fetch logs when the component is mounted
</script>

<style scoped>
.container {
    width: 100%;
}

.break-words {
    word-wrap: break-word;
}

.overflow-y-auto {
    max-height: 600px; /* Fixed height for scrollable container */
    overflow-y: auto; /* Enable vertical scrolling */
}
</style>
