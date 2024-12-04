<template>
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Book List</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex items-center">
            <input 
                v-model="searchQuery"
                type="text"
                placeholder="Search for a book..."
                class="px-4 py-2 border rounded-md w-full"
            />
            <button 
                @click="performSearch"
                class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                Search
            </button>
        </div>

        <div class="overflow-y-auto max-h-full border border-gray-300">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-800 text-white border-b">
                        <th class="px-4 py-2 text-left font-medium">Book Name</th>
                        <th class="px-4 py-2 text-left font-medium">Description</th>
                        <th class="px-4 py-2 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in filteredBooks" :key="book.id" class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ book.name }}</td>
                        <td class="px-4 py-2">{{ book.description }}</td>
                        <td class="px-4 py-2 text-center">
                            <button @click="editBook(book)" class="text-blue-500 hover:underline">Edit</button>
                            <button @click="deleteBook(book.id)" class="text-red-500 hover:underline ml-2">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="props.books.length === 0"> 
                        <td colspan="5" class="border border-gray-300 px-6 py-2 text-center">
                            No books found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Edit Form -->
        <div v-if="isEditing" class="mt-4 p-4 border border-gray-300 rounded-md bg-gray-50">
            <h3 class="text-lg font-bold mb-4">Edit Book</h3>
            <form @submit.prevent="updateBook">
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700">Book Name:</label>
                    <input
                        id="edit-name"
                        v-model="currentBook.name"
                        type="text"
                        class="w-full px-4 py-2 border rounded-md"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="edit-description" class="block text-gray-700">Description:</label>
                    <input
                        id="edit-description"
                        v-model="currentBook.description"
                        type="text"
                        class="w-full px-4 py-2 border rounded-md"
                        required
                    />
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save</button>
                    <button @click="cancelEdit" type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { defineProps, defineEmits } from 'vue';

// Define props
const props = defineProps({
    books: {
        type: Array,
        required: true,
    },
});

// Define emits
const emit = defineEmits(['delete-book', 'edit-book']);

const isEditing = ref(false);
const currentBook = ref(null);
const searchQuery = ref('');

// Computed property for filtered books based on search query
const filteredBooks = computed(() => {
    if (!searchQuery.value) {
        return props.books;
    }
    return props.books.filter(book =>
        book.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        book.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Function to start editing
const editBook = (book) => {
    isEditing.value = true;
    currentBook.value = { ...book };
};

// Function to cancel editing
const cancelEdit = () => {
    isEditing.value = false;
    currentBook.value = null;
};

// Function to update the book
const updateBook = () => {
    emit('edit-book', currentBook.value);
    isEditing.value = false;
    currentBook.value = null;
};

// Function to delete the book
const deleteBook = (id) => {
    emit('delete-book', id);
};

// Function to perform search
const performSearch = () => {
    console.log('Performing search for:', searchQuery.value);
};
</script>
