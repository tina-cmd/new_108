<template>
    <div class="p-6 w-full mx-auto">
        <!-- Book Table -->
        <UserTable :users="props.users"/>
        
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import UserTable from "../Components/UserTable.vue";
import Layout from "../Layouts/Layout.vue";

defineOptions({ layout: Layout });

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

// const localBooks = ref([...props.books]);




</script>
