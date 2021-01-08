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
        status: ""
    },
    calendarTasks: [],
    initData: {}
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
    },
    calendarTasks: (state, getters) => {
        return state.calendarTasks;
    },
    initData: (state, getters) => {
        return state.initData;
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
        state.tasks.data.data.data = state.tasks.data.data.data.filter(function(
            element
        ) {
            return element.id != id;
        });
    },
    setCalendarTasks(state, payload) {
        state.calendarTasks = payload;
    },
    setInitData(state, payload) {
        state.initData = payload;
    }
};
const actions = {
    getTasks({ commit, state }, data = {page: 1, search: null}) {
        var baseUrl = '/api/tasks?page=';
        var url = baseUrl+ data.page;
        if(data.search!=null){
            url = url +  `&search=${data.search}`
        }
        console.log(url);
        console.log(data.search);
        Axios.get(url).then(response => {
            // console.log(editResponseWithPagination(response));
            // console.log(editResponseWithPagination(response));
            commit("setTasks", editResponseWithPagination(response));
        });
    },
    getSingleTask({ commit, state }, id) {
        Axios.get(`/api/tasks/${id}`).then(response => {
            console.log(response);
            commit("setEditTask", response);
        });
    },
    addTask({ commit, state }, data) {
        commit("setAddTaskStatus", "busy");
        Axios.post("/api/tasks", data)
            .then(response => {
                console.log(response);
                if (response.status == 201) {
                    commit("setAddTaskStatus", "success");
                    commit("setAddTask", {
                        location: "",
                        user_id: 1,
                        type: "",
                        package: "",
                        status: ""
                    });
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
        Axios.post(`/api/tasks/${data.id}`, data)
            .then(response => {
                console.log(response);
                if (response.status == 200) {
                    commit("setEditTaskStatus", "success");
                } else {
                    commit("setEditTaskStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setEditTaskStatus", "failure");
            });
    },
    deleteTask({ commit, state }, id) {
        commit("setDeleteTaskStatus", "busy");
        Axios.delete(`/api/tasks/${id}`)
            .then(response => {
                console.log(response);
                if (response.status == 204) {
                    commit("setDeleteTaskStatus", "success");
                    commit("removeTaskById", id);
                } else {
                    commit("setDeleteTaskStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setDeleteTaskStatus", "failure");
            });
    },
    getCalendarTasks({ commit, state }) {
        return new Promise((resolve, reject) => {
            Axios.get("/api/tasks?groupBy=date").then(response => {
                // console.log(response);
                response.data.data.forEach(element => {

                    element.display = 'list-item';
                    if(element.type == 'print'){
                    element.backgroundColor = '#ff0000';
                        element.title = element.title + ' Printing';
                    }else{
                        element.title = element.title + ' Photo Shoot';
                    }
                });
                commit("setCalendarTasks", response.data.data);
                resolve();
            });
        });
    },
    resetAddTaskStatus({ commit, state }) {
        commit("setAddTaskStatus", "");
    },
    resetEditTaskStatus({ commit, state }) {
        commit("setEditTaskStatus", "");
    },
    resetAddTask({ commit, state }) {
        commit("setAddTask", {
            location: "",
            user_id: 1,
            type: "",
            package: "",
            status: ""
        });
    },
    resetDeleteTaskStatus({ commit, state }) {
        commit("setDeleteTaskStatus", "");
    },
    getInitData({commit, state}) {
        Axios.get('/api/init').then(response=> {
            console.log(response);
            if(response.status == 200)
            commit("setInitData", response);
        })
        .catch(error => {
            console.log(error.response);
        })
    }
};

function editResponseWithPagination(response) {
    if(response.data.data.next_page_url != null){
        response.data.data.next_page_url = response.data.data.next_page_url.slice(-1);
    }
    if(response.data.data.prev_page_url !=null){
        response.data.data.prev_page_url = response.data.data.prev_page_url.slice(-1);
    }

    return response;
}

export default {
    state,
    getters,
    actions,
    mutations
};
