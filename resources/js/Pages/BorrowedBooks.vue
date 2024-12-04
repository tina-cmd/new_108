<template>
    <div class="p-6">
        <!-- Borrowed Books Table -->
        <BorrowedBooksTable v-if="auth.user.role === 'librarian' || auth.user.role === 'assistant'" :borrowedBooks="props.librarianSideBorrow" />

        <BorrowedBooksTableMember v-if="auth.user.role === 'member'" :borrowedBooks="props.studentSideBorrow" @return-book="handleReturn"/>

        <!-- Borrow and Return Buttons (Visible only to Members) -->
        <div v-if="auth.user.role === 'member'" class="mt-6 space-y-4">
            <!-- Borrow a Book Button -->
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps } from "vue";
import BorrowedBooksTable from "../Components/BorrowedBooksTable.vue";
import BorrowedBooksTableMember from "../Components/BorrowedBooksTableMember.vue";
import Layout from "../Layouts/Layout.vue";
import { usePage, useForm } from "@inertiajs/vue3";

defineOptions({ layout: Layout });

const {auth} = usePage().props;

const props = defineProps({
    studentSideBorrow: {
        type: Array,
        default: () => [],
    }, 
    librarianSideBorrow: {
        type: Array,
        default: () => [],
    }
});



// State to manage role and visibility of forms
const showBorrowForm = ref(false);

// Toggles
const toggleBorrowForm = () => {
    showBorrowForm.value = !showBorrowForm.value;
    showReturnForm.value = false; // Close the return form if open
};

const form = useForm({
    i_id: 0,
    b_id: 0,
    qty: 0,
});
const handleReturn = (b_id, i_id, qty) => {
    form.i_id = i_id; 
    form.b_id = b_id; 
    form.qty = qty;

    if(confirm('Are you sure you want to return book? ')) {
        form.post('/dashboard/borrowed_books');
    }
}
</script>
