import api from '../axios'

// ========================================
// AUTH SERVICE - Authentication APIs
// ========================================
export const authService = {

    // POST /api/login
    login: async (email, password) => {
        const response = await api.post('/login', { email, password });

        // Lưu token
        if (response.data.token) {
            localStorage.setItem('auth_token', response.data.token);
        }

        return response.data;
    },

    // POST /api/register
    register: async (userData) => {
        const response = await api.post('/register', userData);
        return response.data;
    },

    // POST /api/logout
    logout: async () => {
        const response = await api.post('/logout');

        // Xóa token
        localStorage.removeItem('auth_token');

        return response.data;
    },

    // GET /api/user (get current user)
    getCurrentUser: async () => {
        const response = await api.get('/user');
        return response.data;
    }

};
