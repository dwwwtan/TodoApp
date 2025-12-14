import { ref } from 'vue';
import { todoService } from '@/api';

// 1. Quy tắc đặt tên: Luôn bắt đầu bằng "use..."
export function useTodos() {

    // --- A. STATE (Dữ liệu) ---
    // ========================================
    // STATE
    // Những biến này chỉ phục vụ cho việc quản lý Todo
    // ========================================
    const todos = ref([]);
    const loading = ref(false);
    const error = ref(null);

    // --- B. METHODS (Hành động) ---
    // ========================================
    // FETCH ALL TODOS
    // ========================================
    const fetchTodos = async () => {
        loading.value = true;
        error.value = null; // reset error

        try {
            // Goi Service Layer
            todos.value = await todoService.getAll();
        } catch (err) {
            error.value = err.message || 'Failed to fetch todos'; // Lưu lỗi để Component hiển thị
            console.error('Error fetching todos:', err);
        } finally {
            loading.value = false;
        }
    };

    // ========================================
    // ADD TODO
    // ========================================
    const addTodo = async (text) => {
        if (text.trim() === '') {
            alert('Vui lòng nhập nội dung');
            return;
        }

        try {
            // Goi API
            const newTodo = await todoService.create({
                text: text.trim(),
                completed: false
            });

            // Cập nhật State ngay lập tức để giao diện hiển thị
            todos.value.unshift(newTodo);  // Thêm vào đầu mảng
        } catch (err) {
            alert('Lỗi thêm todo: ' + (err.message || 'Unknown error'));
            console.error('Error adding todo:', err);
        }
    };

    // ========================================
    // REMOVE TODO
    // ========================================
    const removeTodo = async (id) => {
        if (!confirm("Chắc chắn xóa chứ?")) return;
        try {
            await todoService.delete(id);
            todos.value = todos.value.filter(todo => todo.id !== id);
        } catch (err) {
            alert('Lỗi xóa todo: ' + (err.message || 'Unknown error'));
            console.error('Error removing todo:', err);
        }
    };

    // ========================================
    // TOGGLE TODO
    // ========================================
    const toggleTodo = async (id) => {
        try {
            const updatedTodo = await todoService.toggle(id);

            // Update local state
            const todo = todos.value.find(t => t.id === id);
            if (todo) {
                todo.completed = updatedTodo.completed;
            }
        } catch (err) {
            alert('Lỗi toggle todo: ' + (err.message || 'Unknown error'));
            console.error('Error toggling todo:', err);
        }
    };

    // ========================================
    // EDIT TODO
    // ========================================
    const editTodo = async (id, newText) => {
        if (newText.trim() === '') {
            alert('Todo không được rỗng!');
            return;
        }

        try {
            const updatedTodo = await todoService.update(id, {
                text: newText.trim()
            });

            // Update local state
            const todo = todos.value.find(t => t.id === id);
            if (todo) {
                todo.text = updatedTodo.text;
            }
        } catch (err) {
            alert('Lỗi sửa todo: ' + (err.message || 'Unknown error'));
            console.error('Error editing todo:', err);
        }
    };

    // --- C. RETURN (Xuất khẩu) ---
    // Trả về những gì Component ĐƯỢC PHÉP dùng
    return {
        // State
        // Component cần biến để hiển thị
        todos,
        loading,
        error,

        // Methods
        // Component cần hàm để gắn vào nút bấm
        fetchTodos,
        addTodo,
        removeTodo,
        toggleTodo,
        editTodo
    };
}