<script setup>
const props = defineProps({
    currentFilter: {
        type: String,
        default: 'all',
        validator: (value) => ['all', 'active', 'completed'].includes(value) // only accept 3 values
    } 
});

const emit = defineEmits(['set-filter']); // Gọi emit lên App.vue

const handleFilter = (filter) => {
    emit('set-filter', filter); // Gửi filter lên cha
}
</script>

<template>
    <div class="filter-tabs">
<!-- @click="handleFilter('all')" → gọi handleFilter('all') → emit('set-filter', 'all') lên App.vue -->
        <button :class="{ active: currentFilter === 'all' }" @click="handleFilter('all')">
            All
        </button>
        <button :class="{ active: currentFilter === 'active' }" @click="handleFilter('active')">
            Active
        </button>
        <button :class="{ active: currentFilter === 'completed' }" @click="handleFilter('completed')">
            Completed
        </button>
    </div>
</template>

<style scoped>
.filter-tabs {
    display: flex;
    gap: 10px;
    margin: 20px 0;
    justify-content: center;
}

.filter-tabs button {
    padding: 10px 20px;
    border: 2px solid #ddd;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #666;
    transition: all 0.3s ease;
}

.filter-tabs button:hover {
    border-color: #42b983;
    color: #42b983;
}

/* ← CSS cho tab đang active */
.filter-tabs button.active {
    background: #42b983;
    color: white;
    border-color: #42b983;
}
</style>