// import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes.js";
import loadFramePlugin from "./plugins/loadFramePlugin.js";

const app = createApp(App);
app.use(router);
app.use(loadFramePlugin);
app.mount("#app");
