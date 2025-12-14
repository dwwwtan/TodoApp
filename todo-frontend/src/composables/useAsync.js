import { ref } from 'vue';

/**
 * Composable để xử lý async operations với loading/error states
 * 
 * @param {Function} asyncFn - Async function cần chạy
 * @returns {Object} - { loading, error, execute, reset }
 */
export function useAsync(asyncFn) {
    // ========================================
    // STATE
    // ========================================
    const loading = ref(false);
    const error = ref(null);
    const data = ref(null);

    // ========================================
    // EXECUTE - Chạy async function
    // ========================================
    const execute = async (...args) => {
        loading.value = true;
        error.value = null;

        try {
            data.value = await asyncFn(...args);
            return data.value;
        } catch (err) {
            error.value = err.message || 'An error occurred';
            console.error('useAsync error:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    // ========================================
    // RESET - Reset states
    // ========================================
    const reset = () => {
        loading.value = false;
        error.value = null;
        data.value = null;
    };

    return {
        loading,
        error,
        data,
        execute,
        reset
    };
}