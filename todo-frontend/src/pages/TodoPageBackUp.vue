<script setup>
import { ref, computed, watch } from 'vue';
import TodoFilter from '@/components/TodoFilter.vue';
import TodoInput from '@/components/TodoInput.vue';
import TodoList from '@/components/TodoList.vue';
import TodoStats from '@/components/TodoStats.vue';

const STORAGE_KEY = 'vue-todos';

// ========================================
// FUNCTION: Load todos from localStorage
// ========================================
const loadTodos = () => {
    // Step 1: Read data from localStorage
    const savedTodos = localStorage.getItem(STORAGE_KEY);

    // Step 2: Check data
    if (savedTodos) {
        try {
            // Has data -> Parse JSON string to array
            return JSON.parse(savedTodos);
        } catch (error) {
            // if data was corrupt -> return empty array
            console.log('Lỗi parse todos:', error);
            return [];
        }
    }
    // No data -> return default todos
    return [
        { id: 0, text: 'Học Javascript cơ bản', completed: false },
        { id: 1, text: 'Học Vue cơ bản', completed: false },
        { id: 2, text: 'Học Vue nâng cao', completed: true },
        { id: 3, text: 'Học Laravel', completed: false }
    ];
}

// --- STATE: Todos (load từ localStorage) ---
const todos = ref(loadTodos());

// --- STATE: Filter todos ---
const currentFilter = ref('all'); // default = 'all'

// --- STATE: Tracking todo đang edit ---
const editingId = ref(null); // Lưu ID của todo đang được edit

// ========================================
// FUNCTION: Filter Todo
// ========================================
const filterMap = {
    all: todos => todos,
    active: todos => todos.filter(t => !t.completed),
    completed: todos => todos.filter(t => t.completed),
};

const filteredTodos = computed(() => {
    return filterMap[currentFilter.value](todos.value);
});

// Method: Change filter
const changeFilter = (filter) => {
    currentFilter.value = filter;
    // ☝️ Khi currentFilter thay đổi → filteredTodos TỰ ĐỘNG tính lại!
    // → TodoList nhận props mới → Vue re-render
};

// const filteredTodos = computed(() => { // ← Computed: Lọc todos theo filter
//   if (currentFilter.value === 'active') {
//     return todos.value.filter(todo => !todo.completed);
//   }
//   if (currentFilter.value === 'completed') {
//     return todos.value.filter(todo => todo.completed);
//   }
//   return todos.value; // get all
// });

// ========================================
// WATCH: Tự động lưu khi todos thay đổi
// ========================================
watch(todos, (newTodos) => { // todos: ← Biến cần watch
    // ← Callback chạy khi todos thay đổi
    // Lưu vào localStorage
    localStorage.setItem(STORAGE_KEY, JSON.stringify(newTodos));
}, { deep: true }); // ← QUAN TRỌNG: Watch cả thay đổi bên trong object

// ===================================================================
// METHODS
// ===================================================================
// ========================================
// FUNCTION: Add Todo
// ========================================
// Nhận text từ TodoInput, tạo todo mới
const addTodo = (text) => {
    todos.value.push({
        id: crypto.randomUUID(),
        text: text,
        completed: false
    });
}

// ========================================
// FUNCTION: Remove Todo
// ========================================
const removeTodo = (id) => {
    todos.value = todos.value.filter(todo => todo.id !== id);
}

// ========================================
// FUNCTION: Toggle Todo
// ========================================
const toggleTodo = (id) => {
    // Bước 1: Tìm todo có id tương ứng
    const todo = todos.value.find(todo => todo.id === id);
    // Bước 2: Nếu tìm thấy → Đảo trạng thái completed
    if (todo) {
        todo.completed = !todo.completed; // Đảo trạng thái completed của todo
    }
}

// ========================================
// FUNCTION: Edit Todo
// ========================================
// --- Start Edit ---
const startEdit = (id) => {
    editingId.value = id;
    // Set id của todo đang edit
    // TodoItem sẽ nhận prop này và hiện input
}

// --- Save edit ---
const saveEdit = (id, newText) => {
    // Step 1: Validate text
    if (newText.trim().length === '') {
        alert('Todo không được rỗng!');
        return;
    }
    // Step 2: Find to do then Update todo
    const todo = todos.value.find(todo => todo.id === id);
    if (todo) {
        todo.text = newText.trim();
    }
    // Step 3: Exit edit mode
    editingId.value = null;
}

// --- Cancel edit ---
const cancelEdit = () => {
    editingId.value = null;
}

</script>

<template>
    <div class="todo-app">
        <div class="container">
            <h1>📝 Todo List</h1>
            <!-- Back to home button -->
            <RouterLink to="/" class="back-link">← Về trang chủ</RouterLink>

            <!-- Component TodoInput -->
            <TodoInput @add-todo="addTodo" />

            <!-- Filter -->
            <TodoFilter :current-filter="currentFilter" @change-filter="changeFilter" />
            <!-- :current-filter="currentFilter" -> Truyền filter hiện tại xuống (để highlight tab) -->
            <!-- @change="changeFilter" -> Khi TodoFilter emit('change', 'active')
    → Gọi changeFilter('active')
    → currentFilter.value = 'active'
    → filteredTodos tự động update -->

            <!-- Component TodoList -->
            <TodoList :todos="filteredTodos" :editing-id="editingId" @remove-todo="removeTodo" @toggle-todo="toggleTodo"
                @start-edit="startEdit" @save-edit="saveEdit" @cancel-edit="cancelEdit" />
            <!-- :todos="todos" -> Truyền array todos xuống TodoList -->
            <!-- :editing-id="editingId" -> Truyền ID todo đang edit xuống TodoList -->
            <!--  @start-edit="startEdit" -> Khi TodoList emit('start-edit', id) → Gọi startEdit(id) -->
            <!-- Tương tự với @save-edit="saveEdit" và @cancel-edit="cancelEdit" -->

            <!-- Stats -->
            <!-- ☝️ Truyền cả array todos thay vì chỉ count -->
            <!-- <TodoStats v-if="todos.length > 0" :count="todos.length" /> -->
            <TodoStats v-if="todos.length > 0" :todos="todos" />
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
    background: #faf9f5;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

/* Animation */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>