<script setup>
import { ref } from 'vue';

const techStack = ref([
    { name: 'Vue 3', desc: 'Progressive JavaScript Framework', icon: '💚' },
    { name: 'Vue Router', desc: 'Official routing library', icon: '🚦' },
    { name: 'Laravel', desc: 'PHP Framework (Coming soon)', icon: '🔴' },
    { name: 'MySQL', desc: 'Database (Coming soon)', icon: '🗄️' }
]);

const author = ref({
    name: 'Đào Quang Tân (Dex)',
    role: 'IT Student | Web Developer',
    github: 'https://github.com/dex',
    email: 'dex@example.com'
});
</script>

<template>
    <div class="about-page">
        <div class="container">
            <RouterLink to="/" class="back-link">← Về trang chủ</RouterLink>

            <div class="about-header">
                <h1>🎯 Về Dự Án</h1>
                <p class="subtitle">Todo App được xây dựng với Vue 3 & Laravel</p>
            </div>

            <section class="tech-stack">
                <h2>🛠️ Công Nghệ Sử Dụng</h2>
                <div class="tech-grid">
                    <div v-for="tech in techStack" :key="tech.name" class="tech-card">
                        <div class="tech-icon">{{ tech.icon }}</div>
                        <h3>{{ tech.name }}</h3>
                        <p>{{ tech.desc }}</p>
                    </div>
                </div>
            </section>

            <section class="author">
                <h2>👨‍💻 Tác Giả</h2>
                <div class="author-card">
                    <h3>{{ author.name }}</h3>
                    <p class="role">{{ author.role }}</p>
                    <div class="author-links">
                        <a :href="author.github" target="_blank">GitHub</a>
                        <a :href="`mailto:${author.email}`">Email</a>
                    </div>
                </div>
            </section>

            <section class="version">
                <p>Version: <strong>1.0.0</strong></p>
                <p>Last updated: <strong>{{ new Date().toLocaleDateString('vi-VN') }}</strong></p>
            </section>
        </div>
    </div>
</template>

<style scoped>
.about-page {
    min-height: 100vh;
    background: #f9f9f9;
    padding: 40px 20px;
}

.container {
    max-width: 800px;
    margin: 0 auto;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.back-link:hover {
    text-decoration: underline;
}

.about-header {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 12px;
    margin-bottom: 40px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.about-header h1 {
    font-size: 36px;
    color: #333;
    margin-bottom: 12px;
}

.subtitle {
    color: #666;
    font-size: 18px;
}

section {
    background: white;
    padding: 32px;
    border-radius: 12px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

section h2 {
    color: #333;
    margin-bottom: 24px;
    font-size: 24px;
}

.tech-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.tech-card {
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    text-align: center;
}

.tech-icon {
    font-size: 40px;
    margin-bottom: 12px;
}

.tech-card h3 {
    color: #333;
    margin-bottom: 8px;
}

.tech-card p {
    color: #666;
    font-size: 14px;
}

.author-card {
    text-align: center;
    padding: 24px;
}

.author-card h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 8px;
}

.role {
    color: #667eea;
    font-weight: 500;
    margin-bottom: 20px;
}

.author-links {
    display: flex;
    gap: 16px;
    justify-content: center;
}

.author-links a {
    padding: 8px 20px;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.2s;
}

.author-links a:hover {
    background: #5568d3;
}

.version {
    text-align: center;
}

.version p {
    color: #666;
    margin: 8px 0;
}
</style>