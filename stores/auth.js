
export const authModule = {
    namespaced: true, // Recommended for modularity
    state: () => ({
        isAuthenticated: false,
        user: null,
        token: null,
    }),
    getters: {
        getIsAuthenticated: (state) => state.isAuthenticated,
        getUser: (state) => state.user,
        getToken: (state) => state.token,
        // Example of a getter using another getter (if needed)
        getUserRole: (state, getters) => getters.getUser ? getters.getUser.role : 'Guest',
    },
    mutations: {
        setAuthenticated(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated;
        },
        setUser(state, user) {
            state.user = user;
        },
        setToken(state, token) {
            state.token = token;
        },
        logout(state) {
            state.isAuthenticated = false;
            state.user = null;
            state.token = null;
        },
    },
    actions: {
        login({ commit }, { user, token }) {
            commit('setUser', user);
            commit('setToken', token);
            commit('setAuthenticated', true);
        },
        logout({ commit }) {
            commit('logout');
        },
    },
};