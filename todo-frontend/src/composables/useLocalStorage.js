import { ref, watch } from 'vue';

/**
 * Composable để sync state với localStorage
 * 
 * @param {String} key - localStorage key
 * @param {*} defaultValue - Giá trị mặc định
 * @returns {Ref} - Reactive ref sync với localStorage
 */
export function useLocalStorage(key, defaultValue) {
    // ========================================
    // LOAD từ localStorage
    // ========================================
    const loadValue = () => {
        const saved = localStorage.getItem(key);
        if (saved) {
            try {
                return JSON.parse(saved);
            } catch (err) {
                console.error('Error parsing localStorage:', err);
                return defaultValue;
            }
        }
        return defaultValue;
    };

    // ========================================
    // STATE
    // ========================================
    const data = ref(loadValue());

    // ========================================
    // WATCH - Tự động lưu khi thay đổi
    // ========================================
    watch(
        data,
        (newValue) => {
            localStorage.setItem(key, JSON.stringify(newValue));
        },
        { deep: true }
    );

    return data;
}