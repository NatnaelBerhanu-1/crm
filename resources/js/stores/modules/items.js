import Axios from "axios";

// initial state
const state = () => ({
    addItemStatus: "",
    editItemStatus: "",
    deleteItemStatus: "",
    items: {},
    editItem: {},
    addItem: {}
});

//getters
const getters = {
    items: (state, getters) => {
        return state.items;
    },
    addItemStatus: (state, getters) => {
        return state.addItemStatus;
    },
    editItemStatus: (state, getters) => {
        return state.editItemStatus;
    },
    deleteItemStatus: (state, getters) => {
        return state.deleteItemStatus;
    },
    editItem: (state, getters) => {
        return state.editItem;
    },
    addItem: (state, getters) => {
        return state.addItem;
    }
};
const mutations = {
    setItems(state, payload) {
        state.items = payload;
    },
    setAddItemStatus(state, payload) {
        state.addItemStatus = payload;
    },
    setEditItemStatus(state, payload) {
        state.editItemStatus = payload;
    },
    setDeleteItemStatus(state, payload) {
        state.deleteItemStatus = payload;
    },
    setEditItem(state, payload) {
        state.editItem = payload;
    },
    setAddItem(state, payload) {
        state.addItem = payload;
    },
    removeItemById(state, id) {
        state.items.data.data.data = state.items.data.data.data.filter(function(element) {
            return element.id != id;
        });
    }
};
const actions = {
    getItems({ commit, state }, data = { url: "" }) {
        if (data.url == "") {
            data.url = "/api/items?page=1";
        }
        Axios.get(data.url).then(response => {
            console.log(response.data);
            commit("setItems", response);
        });
    },
    getSingleItem({ commit, state }, id) {
        Axios.get(`/api/items/${id}`).then(response => {
            console.log(response);
            commit("setEditItem", response);
        })
    },
    addItem({ commit, state }, data) {
        commit("setAddItemStatus", "busy");
        Axios.post("/api/items", data).then(response => {
            console.log(response);
            if (response.status == 201) {
                commit("setAddItemStatus", "success");
                commit("setAddItem", {
                    location: "",
                    user_id: 1,
                    type: "",
                    package: "",
                    status: "",
                  })
            } else {
                commit("setAddItemStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setAddItemStatus", "failure");
        });
    },
    updateItem({ commit, state }, data) {
        commit("setEditItemStatus", "busy");
        data._method = "PUT";
        Axios.post(`/api/items/${data.id}`, data).then(response => {
            console.log(response);
            if(response.status==200){
                commit("setEditItemStatus", "success");
            }else{
                commit("setEditItemStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setEditItemStatus", "failure");
        })
    },
    deleteItem({ commit, state }, id) {
        commit("setDeleteItemStatus", "busy");
        Axios.delete(`/api/items/${id}`).then(response => {
            console.log(response);
            if(response.status == 204){
                commit("setDeleteItemStatus", "success");
                commit("removeItemById", id);
            }else{
                commit("setDeleteItemStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setDeleteItemStatus", "failure");

        })
    },
    resetAddItemStatus({commit, state }){
        commit("setAddItemStatus", "");
    },
    resetEditItemStatus({commit, state}){
        commit("setEditItemStatus", "");
    },
    resetAddItem({commit, state}){
        commit("setAddItem", {
            location: "",
            user_id: 1,
            type: "",
            package: "",
            status: "",
          });
    },resetDeleteItemStatus({commit, state}){
        commit("setDeleteItemStatus", "");
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
