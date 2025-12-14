import { ref } from 'vue';

export function useEditMode() {
    // ========================================
    // STATE
    // ========================================
    const editingId = ref(null);

    // ========================================
    // COMPUTED
    // ========================================
    const isEditing = (id) => editingId.value === id;

    // ========================================
    // METHODS
    // ========================================
    const startEdit = (id) => {
        editingId.value = id;
    };

    const cancelEdit = () => {
        editingId.value = null;
    };

    return {
        editingId,
        isEditing,
        startEdit,
        cancelEdit
    };
}