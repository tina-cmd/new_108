<template>
    <div class="p-6 w-full mx-auto">
        <!-- <p v-if="error"></p> -->
        <!-- Book Table -->
        <BookTable
            :books="props.books"
            @delete-book="deleteBook"
            @edit-book="updateBook"
        />

        <!-- Add Book Form -->
        <button
            class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300"
            @click="toggleAddBookForm"
        >
            Add Book
        </button>
        <div v-if="showAddBookForm" class="mt-6">
            <AddBook @add-book="addBook" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import BookTable from "../Components/BookTable.vue";
import AddBook from "../Components/AddBook.vue";
import Layout from "../Layouts/Layout.vue";
import { useForm, usePage } from "@inertiajs/vue3";

defineOptions({ layout: Layout });

// const page = usePage();
// const {er = null} = page.props.error;
// const b = page.props.value.books;

const props = defineProps({
    books: {
        type: Array,
        default: () => [],
    },
    error: {
        type: String,
        default: "",
    },
});

const showAddBookForm = ref(false);

const toggleAddBookForm = () => {
    showAddBookForm.value = !showAddBookForm.value;
};

const book = useForm({
    name: "",
    description: "",
    qty: 0,
});

const addBook = (newBook) => {
    book.name = newBook.name;
    book.description = newBook.description;
    book.qty = newBook.quantity;

    if (confirm("Are you sure you want to add this book?")) {
        book.post("/dashboard/books");
    }
    toggleAddBookForm();
    book.name = "";
    book.description = "";
    book.qty = 0;
};

const del = useForm({});

const deleteBook = (id) => {
    if (confirm("Are you sure you want to delete this book?")) {
        confirmDelete(id);
    }
};

const confirmDelete = (id) => {
    del.delete(`/dashboard/books/${id}`);
};

const updateBook = (editBook) => {
    // alert(editBook.id);
    book.name = editBook.name;
    book.description = editBook.description;

    if (confirm("Are you sure you want to edit this record?")) {
        book.put(`/dashboard/books/${editBook.id}`);
    }
    book.name = "";
    book.description = "";
};

// onMounted(() => {
//     console.log(props);
// });
</script>
