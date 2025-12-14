<script setup>
import { onMounted } from 'vue';
import { useTodos } from '@/composables/useTodos';
import { useFilter } from '@/composables/useFilter';
import { useEditMode } from '@/composables/useEditMode';
import TodoInput from '@/components/TodoInput.vue';
import TodoFilter from '@/components/TodoFilter.vue';
import TodoList from '@/components/TodoList.vue';
import TodoStats from '@/components/TodoStats.vue';

// ========================================
// USE COMPOSABLE - 1. "Thuê" logic về dùng
// ========================================
// Todos logic
const {
    todos,
    loading,
    error,
    fetchTodos,
    addTodo,
    removeTodo,
    toggleTodo,
    editTodo
} = useTodos();

// Filter logic
const {
    currentFilter,
    filteredItems: filteredTodos,
    setFilter
} = useFilter(todos);

// Edit mode logic
const {
    editingId,
    startEdit,
    cancelEdit
} = useEditMode();

// ========================================
// METHODS
// ========================================
const saveEdit = async (id, newText) => {
    await editTodo(id, newText);
    cancelEdit();
};

// ========================================
// LIFECYCLE
// ========================================
onMounted(() => {
    fetchTodos(); // Gọi hàm từ Composable - Load todos khi component mount
});
</script>

<template>
    <div class="todo-app">
        <div class="container">
            <h1>📝 Todo List</h1>
            <RouterLink to="/" class="back-link">← Về trang chủ</RouterLink>

            <!-- Loading State -->
            <div v-if="loading" class="loading">
                <div class="spinner"></div>
                <p>Đang tải todos...</p>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="error">
                ❌ {{ error }}
                <button @click="fetchTodos" class="btn-retry">Thử lại</button>
            </div>

            <!-- Main Content -->
            <template v-else>
                <TodoInput @add-todo="addTodo" />
                <TodoFilter :current-filter="currentFilter" @set-filter="setFilter" />
                <TodoList :todos="filteredTodos" :editing-id="editingId" @remove-todo="removeTodo" @toggle-todo="toggleTodo"
                    @start-edit="startEdit" @save-edit="saveEdit" @cancel-edit="cancelEdit" />
                <TodoStats v-if="todos.length > 0" :todos="todos" />
            </template>
        </div>
    </div>
</template>

<style scoped>
.todo-app {
    min-height: 100vh;
    background: #f5f5f5;
    padding: 40px 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.back-link:hover {
    text-decoration: underline;
}

/* Loading */
.loading {
    text-align: center;
    padding: 40px;
}

.spinner {
    width: 40px;
    height: 40px;
    margin: 0 auto 16px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Error */
.error {
    text-align: center;
    padding: 24px;
    background: #fee;
    border-left: 4px solid #f44;
    border-radius: 4px;
    color: #c33;
}

.btn-retry {
    margin-top: 16px;
    padding: 8px 16px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-retry:hover {
    background: #5568d3;
}
</style>