<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();

console.log(route.params.id);  // VD: "123"
</script>

<template>
    <div>
        <h1>Todo Detail #{{ route.params.id }}</h1>
    </div>
</template>