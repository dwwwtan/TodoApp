<script setup>
import { computed } from 'vue';
const props = defineProps({
    todos: {
        type: Array,
        required: true
    }
});

// Tính số todo đã hoàn thành
const totalCount = computed(() => props.todos.length);
const completedCount = computed(() => props.todos.filter(todo => todo.completed).length);
const activeCount = computed(() => props.todos.filter(todo => !todo.completed).length);
</script>

<template>
    <div class="stats">
        <div class="stat-item">
            <span class="label">📋 Tổng: </span>
            <strong>{{ totalCount }}</strong>
        </div>
        <div class="stat-item">
            <span class="label">⏳ Active: </span>
            <strong>{{ activeCount }}</strong>
        </div>
        <div class="stat-item">
            <span class="label">✅ Completed: </span>
            <strong>{{ completedCount }}</strong>
        </div>
    </div>
</template>

<style scoped>
.stats {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    background: white;
    border-radius: 8px;
    margin-top: 20px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.label {
    font-size: 14px;
    color: #666;
}

strong {
    font-size: 24px;
    color: #42b983;
}

</style>