<script setup>
import { ref } from 'vue';

const features = ref([
    { icon: '✅', title: 'Tạo Todo', desc: 'Thêm công việc cần làm' },
    { icon: '✏️', title: 'Chỉnh sửa', desc: 'Sửa todo bất kỳ lúc nào' },
    { icon: '🗑️', title: 'Xóa', desc: 'Xóa todo đã hoàn thành' },
    { icon: '💾', title: 'Lưu trữ', desc: 'Data được lưu trong database' }
]);
</script>

<template>
    <div class="home-page">
        <div class="hero">
            <h1>📝 Vue Todo App</h1>
            <p class="tagline">Quản lý công việc hiệu quả với Vue 3 + Laravel</p>

            <div class="cta">
                <RouterLink to="/todos" class="btn-primary">
                    Bắt đầu ngay →
                </RouterLink>
            </div>
        </div>

        <div class="features">
            <h2>✨ Tính năng</h2>
            <div class="feature-grid">
                <div v-for="feature in features" :key="feature.title" class="feature-card">
                    <div class="feature-icon">{{ feature.icon }}</div>
                    <h3>{{ feature.title }}</h3>
                    <p>{{ feature.desc }}</p>
                </div>
            </div>
        </div>

        <footer class="home-footer">
            <p>Phát triển bởi <strong>Dex</strong> | 2025</p>
        </footer>
    </div>
</template>

<style scoped>
.home-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.hero {
    text-align: center;
    padding: 80px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    margin-bottom: 60px;
}

.hero h1 {
    font-size: 48px;
    margin-bottom: 16px;
}

.tagline {
    font-size: 20px;
    opacity: 0.9;
    margin-bottom: 32px;
}

.btn-primary {
    display: inline-block;
    padding: 16px 40px;
    background: white;
    color: #667eea;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 18px;
    transition: transform 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.features h2 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 40px;
    color: #333;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
}

.feature-card {
    background: white;
    padding: 32px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.2s;
}

.feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.feature-card h3 {
    color: #333;
    margin-bottom: 8px;
}

.feature-card p {
    color: #666;
    font-size: 14px;
}

.home-footer {
    text-align: center;
    margin-top: 80px;
    padding-top: 40px;
    border-top: 1px solid #eee;
    color: #999;
}
</style>