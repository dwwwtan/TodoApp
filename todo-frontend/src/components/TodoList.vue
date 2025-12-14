<script setup>
import TodoItem from './TodoItem.vue';

// Nhận props từ App.vue
const props = defineProps({
    todos: {
        type: Array,
        required: true,
    },
    editingId: {
        type: Number,
        required: true,
    },
});
// ☝️ props.todos = [{ id: 1, text: '...', completed: false }, ...]

const emit = defineEmits(['remove-todo', 'toggle-todo', 'start-edit', 'save-edit', 'cancel-edit']);

// TodoList chỉ chuyển tiếp events từ TodoItem lên App.vue
const handleRemove = (id) => emit('remove-todo', id);
// TodoItem emit('remove-todo', id) → TodoList nhận
// → TodoList emit('remove-todo', id) lên App.vue
const handleToggle = (id) => emit('toggle-todo', id);
const handleStartEdit = (id) => emit('start-edit', id);
const handleSaveEdit = (id, newText) => emit('save-edit', id, newText);
const handleCancelEdit = () => emit('cancel-edit');

// ☝️ TodoList đóng vai trò "TRUNG GIAN"
// Không xử lý logic, chỉ chuyển tiếp events
</script>

<template>
    <!-- empty state -->
    <div v-if="todos.length === 0" class="empty-state">
        <p>Nothing to do!</p>
    </div>

    <!-- Todo list -->
    <ul v-else class="todo-list">
        <TodoItem v-for="todo in todos"
            :key="todo.id"
            :todo="todo"
            :is-editing="editingId === todo.id"
            @remove-todo="handleRemove"
            @toggle-todo="handleToggle"
            @start-edit="handleStartEdit"
            @save-edit="handleSaveEdit"
            @cancel-edit="handleCancelEdit"
        />
    </ul>
</template>
<!-- 
    :is-editing="editingId === todo.id" -> TodoItem nhận prop boolean:
        - true nếu todo này đang được edit
        - false nếu không
    
    VD: editingId = 2
    → Todo id=2 nhận isEditing = true
    → Các todo khác nhận isEditing = false
    -->

<style scoped>
.empty-state {
    text-align: center;
    padding: 40px;
    color: #999;
    font-size: 18px;
}

.todo-list {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}
</style>