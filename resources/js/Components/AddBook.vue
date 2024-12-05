<template>
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add a New Book</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label
                    class="block text-gray-700 font-medium mb-2"
                    for="bookName"
                    >Book Name</label
                >
                <input
                    id="bookName"
                    v-model="form.name"
                    type="text"
                    placeholder="Enter book name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                    required
                />
            </div>

            <div class="mb-4">
                <label
                    class="block text-gray-700 font-medium mb-2"
                    for="description"
                    >Description</label
                >
                <textarea
                    id="description"
                    v-model="form.description"
                    placeholder="Enter description"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                    required
                ></textarea>
            </div>

            <div class="mb-4">
                <label
                    class="block text-gray-700 font-medium mb-2"
                    for="quantity"
                    >Quantity</label
                >
                <input
                    id="quantity"
                    v-model="form.quantity"
                    type="number"
                    min="1"
                    placeholder="Enter quantity"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                    required
                />
            </div>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300"
            >
                Add Book
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";



const emit = defineEmits(["add-book"]);

const form = useForm({
    name: '',
    description: '',
    quantiry: 0,
});

const submitForm = () => {
    
    const newBook = {
        name: form.name,
        description: form.description,
        quantity: parseInt(form.quantity, 10),
    };
    emit("add-book", newBook);
    form.reset();
};

</script>
