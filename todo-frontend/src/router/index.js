import { createRouter, createWebHistory } from 'vue-router';

// Import pages
import HomePage from '@/pages/HomePage.vue';
import TodoPage from '@/pages/TodoPage.vue';
import AboutPage from '@/pages/AboutPage.vue';

// ========================================
// DEFINE ROUTES
// ========================================
const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomePage,
        meta: { title: 'Trang chủ' }
    },
    {
        path: '/todos',
        name: 'Todos',
        component: TodoPage,
        meta: { title: 'Todo List' }
    },
    {
        path: '/about',
        name: 'About',
        component: AboutPage,
        meta: { title: 'Về dự án' }
    },
    // Catch-all route (404)
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/pages/NotFoundPage.vue')  // Lazy load
    },
    {
        path: '/todos/:id',  // ← :id là param
        name: 'TodoDetail',
        component: () => import('@/pages/TodoDetailPage.vue')
    },
    {
        path: '/test-api',
        name: 'TestAPI',
        component: () => import('@/pages/TestAPIPage.vue')
    }
];

// ========================================
// CREATE ROUTER INSTANCE
// ========================================
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

// ========================================
// NAVIGATION GUARD - Thay đổi title
// ========================================
router.beforeEach((to, from, next) => {
    // Set document title
    document.title = to.meta.title || 'Vue Todo App';
    next();
});

export default router;