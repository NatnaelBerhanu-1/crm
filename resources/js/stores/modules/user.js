import Axios from "axios";
import localService from "../../localservice";

// initial state
const state = () => ({
    addUserStatus: "",
    editUserStatus: "",
    deleteUserStatus: "",
    addUserError: "Failed adding user",
    editUserError: "Failed updating user",
    changePasswordStatus: "",
    users: {},
    editUser: {},
    addUser: { role: "" },
    changePasswordMessage: ""
});

//getters
const getters = {
    users: (state, getters) => {
        return state.users;
    },
    addUserStatus: (state, getters) => {
        return state.addUserStatus;
    },
    editUserStatus: (state, getters) => {
        return state.editUserStatus;
    },
    deleteUserStatus: (state, getters) => {
        return state.deleteUserStatus;
    },
    editUser: (state, getters) => {
        return state.editUser;
    },
    addUser: (state, getters) => {
        return state.addUser;
    },
    addUserError: (state, getters) => {
        return state.addUserError;
    },
    editUserError: (state, getters) => {
        return state.editUserError;
    },
    changePasswordStatus: (state, getters) => {
        return state.changePasswordStatus;
    },
    changePasswordMessage: (state, getters) => {
        return state.changePasswordMessage;
    }
};
const mutations = {
    setUsers(state, payload) {
        state.users = payload;
    },
    setAddUserStatus(state, payload) {
        state.addUserStatus = payload;
    },
    setEditUserStatus(state, payload) {
        state.editUserStatus = payload;
    },
    setDeleteUserStatus(state, payload) {
        state.deleteUserStatus = payload;
    },
    setEditUser(state, payload) {
        state.editUser = payload;
    },
    setAddUser(state, payload) {
        state.addUser = payload;
    },
    removeUserById(state, id) {
        state.users.data.data.data = state.users.data.data.data.filter(function(
            element
        ) {
            return element.id != id;
        });
    },
    setAddUserError(state, payload) {
        state.addUserError = payload;
    },
    setEditUserError(state, payload) {
        state.editUserError = payload;
    },
    setChangePasswordStatus(state, payload) {
        state.changePasswordStatus = payload;
    },
    setChangePasswordMessage(state, payload) {
        state.changePasswordMessage = payload;
    }
};
const actions = {
    getUsers({ commit, state }, data = null) {
        var url = "/api/users";
        if(data != null){
            if(data.only == "staff"){
            url = url + "?only=staff"
        }
        }

        Axios.get(url).then(response => {
            console.log(response.data);
            commit("setUsers", response);
        });
    },
    getSingleUser({ commit, state }, id) {
        Axios.get(`/api/users/${id}`).then(response => {
            console.log(response);
            commit("setEditUser", response);
        });
    },
    addUser({ commit, state }, data) {
        commit("setAddUserStatus", "busy");
        Axios.post("/api/users", data)
            .then(response => {
                console.log(response);
                if (response.status == 201) {
                    commit("setAddUserStatus", "success");
                    commit("setAddUser", {
                        role: ""
                    });
                } else {
                    commit("setAddUserStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error.response.status);
                if (error.response.status == 400) {
                    commit("setAddUserError", "phone number already in use.");
                    commit("setAddUserStatus", "failure");
                }
                commit("setAddUserStatus", "failure");
            });
    },
    updateUser({ commit, state }, data) {
        commit("setEditUserStatus", "busy");
        data._method = "PUT";
        Axios.post(`/api/users/${data.id}`, data)
            .then(response => {
                console.log(response);
                if (response.status == 200) {
                    commit("setEditUserStatus", "success");
                } else {
                    commit("setEditUserStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error.response.status);
                if (error.response.status == 400) {
                    commit("setEditUserError", "phone number already in use.");
                    commit("setEditUserStatus", "failure");
                }
                commit("setEditUserStatus", "failure");
            });
    },
    deleteUser({ commit, state }, id) {
        commit("setDeleteUserStatus", "busy");
        Axios.delete(`/api/users/${id}`)
            .then(response => {
                console.log(response);
                if (response.status == 204) {
                    commit("setDeleteUserStatus", "success");
                    commit("removeUserById", id);
                } else {
                    commit("setDeleteUserStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setDeleteUserStatus", "failure");
            });
    },
    resetAddUserStatus({ commit, state }) {
        commit("setAddUserStatus", "");
        commit("setAddUserError", "Failed adding user");
    },
    resetEditUserStatus({ commit, state }) {
        commit("setEditUserStatus", "");
    },
    resetAddUser({ commit, state }) {
        commit("setAddUser", {
            location: "",
            user_id: 1,
            type: "",
            package: "",
            status: ""
        });
    },
    resetDeleteUserStatus({ commit, state }) {
        commit("setDeleteUserStatus", "");
    },
    changePassword({ commit, state }, data) {
        commit("setChangePasswordStatus", "busy");
        data.id = localService.user().id;
        data._method = "PUT";
        Axios.post("/api/changePassword", data)
            .then(response => {
                console.log(response);
                if (response.status == 200) {
                    commit("setChangePasswordStatus", "success");
                    commit(
                        "setChangePasswordMessage",
                        "Password changed successfully"
                    );
                } else {
                    commit("setChangePasswordStatus", "failure");
                    commit(
                        "setChangePasswordMessage",
                        "Something wen't wrong try again"
                    );
                }
            })
            .catch(error => {
                console.log(error.response);
                if (error.response.status == 401) {
                    commit("setChangePasswordStatus", "failure");
                    commit(
                        "setChangePasswordMessage",
                        "Old password not correct"
                    );
                } else {
                    commit("setChangePasswordStatus", "failure");
                    commit(
                        "setChangePasswordMessage",
                        "Something wen't wrong try again"
                    );
                }
            });
    },
    resetChangePasswordStatus({ commit, state }) {
        commit("setChangePasswordStatus", "");
        commit("setChangePasswordMessage", "");
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
