import api from '../axios';

// ========================================
// TODO SERVICE - Tất cả API calls về todos
// ========================================
export const todoService = {

    // GET /api/todos
    getAll: async () => {
        const response = await api.get('/todos');
        return response.data;
    },

    // GET /api/todos/:id
    getById: async (id) => {
        const response = await api.get(`/todos/${id}`);
        return response.data;
    },

    // POST /api/todos
    create: async (todoData) => {
        const response = await api.post('/todos', todoData);
        return response.data;
    },

    // PUT /api/todos/:id
    update: async (id, todoData) => {
        const response = await api.put(`/todos/${id}`, todoData);
        return response.data;
    },

    // DELETE /api/todos/:id
    delete: async (id) => {
        const response = await api.delete(`/todos/${id}`);
        return response.data;
    },

    // PATCH /api/todos/:id/toggle
    toggle: async (id) => {
        const response = await api.patch(`/todos/${id}/toggle`);
        return response.data;
    }

};
