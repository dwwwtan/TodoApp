import api, { getCsrfToken } from '../axios';

export const authService = {
    register: async (userData) => {
        await getCsrfToken();
        const response = await api.post('/register', userData);
        return response.data;
    },

    login: async (email, password) => {
        await getCsrfToken();
        const response = await api.post('/login', { email, password });
        return response.data;
    },

    logout: async () => {
        try {
            await api.post('/logout');
        } catch (error) {
            console.error('Logout error:', error);
        }
    },

    getCurrentUser: async () => {
        const response = await api.get('/me');
        return response.data.user;
    },

    // CHECK IF LOGGED IN
    isAuthenticated: async () => {
        // KHÔNG THỂ check localStorage nữa!
        // Phải gọi API để verify
        try {
            await api.get('/me');
            return true;
        } catch {
            return false;
        }
    }

};