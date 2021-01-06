import Axios from "axios";
import {parse} from "json2csv";

// initial state
const state = () => ({
    addReportStatus: "",
    editReportStatus: "",
    deleteReportStatus: "",
    printReportStatus: "",
    toPrint: {},
    reports: {},
    editReport: {},
    addReport: {}
});

//getters
const getters = {
    reports: (state, getters) => {
        return state.reports;
    },
    addReportStatus: (state, getters) => {
        return state.addReportStatus;
    },
    editReportStatus: (state, getters) => {
        return state.editReportStatus;
    },
    deleteReportStatus: (state, getters) => {
        return state.deleteReportStatus;
    },
    printReportStatus: (state, getters) => {
        return state.printReportStatus;
    },
    editReport: (state, getters) => {
        return state.editReport;
    },
    addReport: (state, getters) => {
        return state.addReport;
    },
    toPrint: (state, getters) => {
        return state.toPrint;
    }
};
const mutations = {
    setReports(state, payload) {
        state.reports = payload;
    },
    setAddReportStatus(state, payload) {
        state.addReportStatus = payload;
    },
    setEditReportStatus(state, payload) {
        state.editReportStatus = payload;
    },
    setDeleteReportStatus(state, payload) {
        state.deleteReportStatus = payload;
    },
    setPrintReportStatus(state, payload) {
        state.printReportStatus = payload;
    },
    setEditReport(state, payload) {
        state.editReport = payload;
    },
    setAddReport(state, payload) {
        state.addReport = payload;
    },
    removeReportById(state, id) {
        state.reports.data.data.data = state.reports.data.data.data.filter(
            function(element) {
                return element.id != id;
            }
        );
    },
    setToPrint(state, payload) {
        state.toPrint = payload;
    }
};
const actions = {
    getReports({ commit, state }, data = { url: "" }) {
        if (data.url == "") {
            data.url = "/api/reports?page=1";
        }
        Axios.get(data.url).then(response => {
            console.log(response.data);
            commit("setReports", response);
        });
    },
    getSingleReport({ commit, state }, id) {
        Axios.get(`/api/reports/${id}`).then(response => {
            console.log(response);
            commit("setEditReport", response);
        });
    },
    getToPrint({ commit, state }, data) {
        commit("setPrintReportStatus", "busy");
        Axios.get(`/api/reports?from=${data.from}&to=${data.to}`)
            .then(response => {

                if (response.status == 200) {
                    if(response.data.data.length > 0){
                        var fields = ['income_amount', 'income_description', 'expense_amount', 'expense_description', 'date'];
                        var opts = {fields};
                        var csv = parse(response.data.data, opts);
                        var a = document.createElement("a");
                        var file = new Blob([csv], {type: 'text/plain'});
                        a.href = URL.createObjectURL(file);
                        a.download = 'report.csv';
                        a.click();
                    }else{
                        alert('No data to generate within selected date range');
                    }
                    console.log(csv);
                    commit("setToPrint", response.data.data);
                    commit("setPrintReportStatus", "success");
                }
            })
            .catch(error => {
                commit("setPrintReportStatus", "failure");
            });
    },
    addReport({ commit, state }, data) {
        commit("setAddReportStatus", "busy");
        Axios.post("/api/reports", data)
            .then(response => {
                console.log(response);
                if (response.status == 201) {
                    commit("setAddReportStatus", "success");
                    commit("setAddReport", {});
                } else {
                    commit("setAddReportStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setAddReportStatus", "failure");
            });
    },
    updateReport({ commit, state }, data) {
        commit("setEditReportStatus", "busy");
        data._method = "PUT";
        Axios.post(`/api/reports/${data.id}`, data)
            .then(response => {
                console.log(response);
                if (response.status == 200) {
                    commit("setEditReportStatus", "success");
                } else {
                    commit("setEditReportStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setEditReportStatus", "failure");
            });
    },
    deleteReport({ commit, state }, id) {
        commit("setDeleteReportStatus", "busy");
        Axios.delete(`/api/reports/${id}`)
            .then(response => {
                console.log(response);
                if (response.status == 204) {
                    commit("setDeleteReportStatus", "success");
                    commit("removeReportById", id);
                } else {
                    commit("setDeleteReportStatus", "failure");
                }
            })
            .catch(error => {
                console.log(error);
                commit("setDeleteReportStatus", "failure");
            });
    },
    resetAddReportStatus({ commit, state }) {
        commit("setAddReportStatus", "");
    },
    resetEditReportStatus({ commit, state }) {
        commit("setEditReportStatus", "");
    },
    resetAddReport({ commit, state }) {
        commit("setAddReport", {
            location: "",
            user_id: 1,
            type: "",
            package: "",
            status: ""
        });
    },
    resetDeleteReportStatus({ commit, state }) {
        commit("setDeleteReportStatus", "");
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
