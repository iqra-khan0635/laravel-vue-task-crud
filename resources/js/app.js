import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Task from "./components/Task.vue";

const app = createApp({
    components: {
        Task,
    },
});
app.mount("#app");
