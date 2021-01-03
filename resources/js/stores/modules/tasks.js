import Axios from "axios";

// initial state
const state = () => ({
    addTaskStatus: "",
    editTaskStatus: "",
    deleteTaskStatus: "",
    tasks: {},
    editTask: {},
    addTask: {
        location: "",
        user_id: 1,
        type: "",
        package: "",
        status: "",
      }
});

//getters
const getters = {
    tasks: (state, getters) => {
        return state.tasks;
    },
    addTaskStatus: (state, getters) => {
        return state.addTaskStatus;
    },
    editTaskStatus: (state, getters) => {
        return state.editTaskStatus;
    },
    deleteTaskStatus: (state, getters) => {
        return state.deleteTaskStatus;
    },
    editTask: (state, getters) => {
        return state.editTask;
    },
    addTask: (state, getters) => {
        return state.addTask;
    }
};
const mutations = {
    setTasks(state, payload) {
        state.tasks = payload;
    },
    setAddTaskStatus(state, payload) {
        state.addTaskStatus = payload;
    },
    setEditTaskStatus(state, payload) {
        state.editTaskStatus = payload;
    },
    setDeleteTaskStatus(state, payload) {
        state.deleteTaskStatus = payload;
    },
    setEditTask(state, payload) {
        state.editTask = payload;
    },
    setAddTask(state, payload) {
        state.addTask = payload;
    },
    removeTaskById(state, id) {
        state.tasks.data.data.data = state.tasks.data.data.data.filter(function(element) {
            return element.id != id;
        });
    }
};
const actions = {
    getTasks({ commit, state }, data = { url: "" }) {
        if (data.url == "") {
            data.url = "/api/tasks?page=1";
        }
        Axios.get(data.url).then(response => {
            console.log(response.data);
            commit("setTasks", response);
        });
    },
    getSingleTask({ commit, state }, id) {
        Axios.get(`/api/tasks/${id}`).then(response => {
            console.log(response);
            commit("setEditTask", response);
        })
    },
    addTask({ commit, state }, data) {
        commit("setAddTaskStatus", "busy");
        Axios.post("/api/tasks", data).then(response => {
            console.log(response);
            if (response.status == 201) {
                commit("setAddTaskStatus", "success");
                commit("setAddTask", {
                    location: "",
                    user_id: 1,
                    type: "",
                    package: "",
                    status: "",
                  })
            } else {
                commit("setAddTaskStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setAddTaskStatus", "failure");
        });
    },
    updateTask({ commit, state }, data) {
        commit("setEditTaskStatus", "busy");
        data._method = "PUT";
        Axios.post(`/api/tasks/${data.id}`, data).then(response => {
            console.log(response);
            if(response.status==200){
                commit("setEditTaskStatus", "success");
            }else{
                commit("setEditTaskStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setEditTaskStatus", "failure");
        })
    },
    deleteTask({ commit, state }, id) {
        commit("setDeleteTaskStatus", "busy");
        Axios.delete(`/api/tasks/${id}`).then(response => {
            console.log(response);
            if(response.status == 201){
                commit("setDeleteTaskStatus", "success");
                commit("removeTaskById", id);
            }else{
                commit("setDeleteTaskStatus", "failure");
            }
        })
        .catch(error => {
            console.log(error);
            commit("setDeleteTaskStatus", "failure");

        })
    },
    resetAddTaskStatus({commit, state }){
        commit("setAddTaskStatus", "");
    },
    resetEditTaskStatus({commit, state}){
        commit("setEditTaskStatus", "");
    },
    resetAddTask({commit, state}){
        commit("setAddTask", {
            location: "",
            user_id: 1,
            type: "",
            package: "",
            status: "",
          });
    },resetDeleteTaskStatus({commit, state}){
        commit("setDeleteTaskStatus", "");
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
