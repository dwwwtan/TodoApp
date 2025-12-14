<script setup>
import { ref } from 'vue';
import { todoService } from '@/api';

const todos = ref([]);
const loading = ref(false);
const error = ref(null);

const fetchTodos = async () => {
    loading.value = true;
    error.value = null;

    try {
        const data = await todoService.getAll();
        todos.value = data.slice(0, 5);  // Chỉ lấy 5 todos đầu
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="test-api">
        <div class="container">
            <h1>🧪 Test API Setup</h1>

            <button @click="fetchTodos" :disabled="loading" class="btn-fetch">
                {{ loading ? 'Loading...' : 'Fetch Todos' }}
            </button>

            <div v-if="error" class="error">❌ {{ error }}</div>

            <div v-if="todos.length > 0" class="todos">
                <h2>✅ Fetched {{ todos.length }} todos:</h2>
                <ul>
                    <li v-for="todo in todos" :key="todo.id">
                        {{ todo.title }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
.test-api {
    min-height: 100vh;
    padding: 40px;
    background: #f5f5f5;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 32px;
    border-radius: 12px;
}

h1 {
    margin-bottom: 24px;
}

.btn-fetch {
    padding: 12px 24px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

.btn-fetch:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.error {
    margin-top: 20px;
    padding: 16px;
    background: #fee;
    border-left: 4px solid #f44;
    border-radius: 4px;
}

.todos {
    margin-top: 24px;
}

.todos ul {
    list-style: none;
    padding: 0;
}

.todos li {
    padding: 12px;
    background: #f9f9f9;
    margin-bottom: 8px;
    border-radius: 6px;
}
</style>