<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goHome = () => {
    router.push('/');
}
</script>

<template>
    <div class="not-found">
        <div class="content">
            <h1>404</h1>
            <h2>Trang không tồn tại</h2>
            <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <button @click="goHome" class="btn-home">
                🏠 Về trang chủ
            </button>
        </div>
    </div>
</template>

<style scoped>
.not-found {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.content {
    text-align: center;
}

h1 {
    font-size: 120px;
    margin: 0;
    font-weight: 800;
}

h2 {
    font-size: 32px;
    margin: 20px 0;
}

p {
    font-size: 18px;
    opacity: 0.9;
    margin-bottom: 40px;
}

.btn-home {
    padding: 16px 40px;
    background: white;
    color: #667eea;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
}

.btn-home:hover {
    transform: translateY(-2px);
}
</style>