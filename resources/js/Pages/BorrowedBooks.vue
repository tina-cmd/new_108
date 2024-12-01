<template>
    <div class="p-6">
        <!-- Borrowed Books Table -->
        <BorrowedBooksTable />

        <!-- Borrow and Return Buttons (Visible only to Members) -->
        <div v-if="isMember" class="mt-6 space-y-4">
            <!-- Borrow a Book Button -->
            <button
                @click="toggleBorrowForm"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
            >
                {{ showBorrowForm ? "Cancel Borrow" : "Borrow a Book" }}
            </button>

            <!-- Return a Book Button -->
            <button
                @click="toggleReturnForm"
                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
            >
                {{ showReturnForm ? "Cancel Return" : "Return a Book" }}
            </button>

            <!-- Borrow Form -->
            <BorrowBookForm v-if="showBorrowForm" />

            <!-- Return Form -->
            <ReturnBookForm v-if="showReturnForm" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import BorrowedBooksTable from "../Components/BorrowedBooksTable.vue";
import BorrowBookForm from "../Components/BorrowBookForm.vue";
import ReturnBookForm from "../Components/ReturnBookForm.vue";
import Layout from "../Layouts/Layout.vue";

defineOptions({ layout: Layout });

// Example session role (Replace with real session data or API call)
const userRole = "member"; // Possible values: "member", "admin", "assistant"

// State to manage role and visibility of forms
const isMember = ref(userRole === "member");
const showBorrowForm = ref(false);
const showReturnForm = ref(false);

// Toggles
const toggleBorrowForm = () => {
    showBorrowForm.value = !showBorrowForm.value;
    showReturnForm.value = false; // Close the return form if open
};

const toggleReturnForm = () => {
    showReturnForm.value = !showReturnForm.value;
    showBorrowForm.value = false; // Close the borrow form if open
};
</script>
