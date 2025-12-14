<script setup>
import { ref, nextTick } from 'vue';
const props = defineProps({
    todo: {
        type: Object,
        required: true
    },
    isEditing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['remove-todo', 'toggle-todo', 'start-edit', 'save-edit', 'cancel-edit']);

// ========================================
// STATE LOCAL: Text đang edit
// ========================================
const editText = ref('');
// Lưu text tạm khi user đang chỉnh sửa

// ========================================
// REF: Input element
// ========================================
const editInputRef = ref(null);
// Reference to input element to focus

const handleRemove = () => emit('remove-todo', props.todo.id); // Gửi id vào parent
const handleToggle = () => emit('toggle-todo', props.todo.id); // Gửi id vào parent

const handleStartEdit = async () => {
    editText.value = props.todo.text; // Step 1: Sao chép text hiện tại vào editText
    emit('start-edit', props.todo.id); // Step 2: Emit event lên cha
    // Bước 3: Đợi Vue render input, rồi focus
    await nextTick(); // Wait for Vue to render the input element ← QUAN TRỌNG!
    const input = editInputRef.value;
    if (input) {
        input.focus(); // focs vào input 
        input.select(); // select all text
    }

// ☝️ Giải thích nextTick():
// Vấn đề:
// 1. emit('start-edit') → App.vue set editingId
// 2. TodoItem nhận isEditing = true
// 3. Input hiện ra
// 4. Nhưng editInputRef.value VẪN null vì Vue chưa render!

// Giải pháp:
// await nextTick() → Đợi Vue render xong
// → editInputRef.value có giá trị
// → focus() hoạt động!
}

const handleSaveEdit = () => {
    emit('save-edit', props.todo.id, editText.value); // Gửi id + text mới lên cha
}

const handleCancelEdit = () => {
    emit('cancel-edit');
}

const handleKeydown = (event) => {
    if (event.key === 'Enter') {
        handleSaveEdit();
    } else if (event.key === 'Escape') {
        handleCancelEdit();
    }
}

</script>

<template>
    <!-- ← Thêm class dynamic -->
    <li class="todo-item" :class="{ completed: todo.completed }">
        <!-- ========================================
            CHECKBOX
            ======================================== -->
        <!-- Nếu todo.completed === true → Thêm class completed
        CSS .completed .todo-text sẽ gạch ngang text -->
        <input type="checkbox" :checked="todo.completed" @change="handleToggle" class="todo-checkbox">
        <!-- @change="handleToggle" → Khi click checkbox → gọi handleToggle() -->

        <!-- ========================================
            CHẾ ĐỘ 1: EDIT MODE (khi isEditing = true)
            ======================================== -->
        <!-- Nếu isEditing === true → Thêm class edit -->
        <input
            v-if="isEditing"
            ref="editInputRef"
            v-model="editText"
            @keydown="handleKeydown"
            @blur="handleSaveEdit"
            class="edit-input"
            type="text"
        />
        <!--
            ref="editInputRef" -> Lưu reference để focus 
            v-model="editText" -> Bind với editText (text tạm)
            @blur="handleSaveEdit" -> Khi click ra ngoài → Lưu
        -->
        
        <!-- ========================================
            CHẾ ĐỘ 2: VIEW MODE (khi isEditing = false)
            ======================================== -->
        <span
            v-else
            @dblclick="handleStartEdit"
            class="todo-text"
            title="Double-click để chỉnh sửa"
        >
            {{ todo.text }}
        <!-- @dblclick="handleStartEdit" -> Double-click vào text → Vào edit mode -->
        </span>

        <!-- ========================================
            BUTTONS (chỉ hiện khi KHÔNG edit)
            ======================================== -->
        <div v-if="!isEditing" class="todo-actions">
            <button @click="handleStartEdit" class="btn-edit" title="Edit todo">Edit</button>
            <button @click="handleRemove" class="btn-delete" title="Delete todo">Delete</button>
        </div>
    </li>

</template>

<style scoped>
.todo-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-bottom: 1px solid #eee;
    transition: background 0.2s;
}

.todo-item:hover {
    background: #f5f5f5;
}

.todo-item.completed .todo-text {
    text-decoration: line-through;
    opacity: 0.6;
    color: #999;
}

.todo-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.todo-text {
    flex: 1;
    cursor: pointer;
    user-select: none;
}

.todo-text:hover {
    color: #42b983;
}

/* ← CSS cho edit input */
.edit-input {
    flex: 1;
    padding: 5px 10px;
    border: 2px solid #42b983;
    border-radius: 4px;
    font-size: 14px;
    outline: none;
}

.todo-actions {
    display: flex;
    gap: 5px;
}

.btn-edit {
    background: #4CAF50;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-edit:hover {
    background: #45a049;
}

.btn-delete {
    background: #ff4444;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-delete:hover {
    background: #cc0000;
}
</style>