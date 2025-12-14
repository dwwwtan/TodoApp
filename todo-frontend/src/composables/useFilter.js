import { ref, computed } from 'vue';

export function useFilter(items) {
    // ========================================
    // STATE
    // ========================================
    const currentFilter = ref('all');

    // ========================================
    // COMPUTED - Filtered items
    // ========================================
    /*
    const filteredItems = computed(() => {
        if (currentFilter.value === 'active') {
            return items.value.filter(item => !item.completed);
        }
        if (currentFilter.value === 'completed') {
            return items.value.filter(item => item.completed);
        }
        return items.value;
    });
    */

    const filterMap = {
        all: items => items,
        active: items => items.filter(item => !item.completed),
        completed: items => items.filter(item => item.completed),
    };

    const filteredItems = computed(() => {
        return filterMap[currentFilter.value](items.value);
    });

    // ========================================
    // COMPUTED - Counts
    // ========================================
    const activeCount = computed(() =>
        items.value.filter(item => !item.completed).length
    );

    const completedCount = computed(() =>
        items.value.filter(item => item.completed).length
    );

    // ========================================
    // METHODS
    // ========================================
    const setFilter = (filter) => {
        currentFilter.value = filter;
    };

    return {
        currentFilter,
        filteredItems,
        activeCount,
        completedCount,
        setFilter
    };
}
