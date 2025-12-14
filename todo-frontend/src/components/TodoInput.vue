<script setup>
import { ref } from 'vue';

const emit = defineEmits(['add-todo']);

const newTodo = ref('');

const handleAdd = () => {
    if (newTodo.value.trim() === '') {
        alert('Please enter a todo');
        return;
    }

    emit('add-todo', newTodo.value.trim()); // Gửi text lên cha
    newTodo.value = ''; // Reset text
}
</script>

<template>
    <div class="add-todo">
        <input v-model="newTodo" @keyup.enter="handleAdd" type="text" placeholder="Todo is ..." class="input">
        <button @click="handleAdd">Add</button>
    </div>
</template>

<style scoped>
.add-todo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px 0;
}

.input {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin-right: 10px;
}

.add-todo button {
    background-color: rgb(174, 0, 255);
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}
</style>