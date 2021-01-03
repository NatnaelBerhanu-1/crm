import Vue from 'vue';
import Vuex from "vuex";
import task from "./modules/tasks";
import item from "./modules/items";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        task,
        item
    }
});
