export default {
    install(app) {
        app.config.globalProperties.$loadFrame = () => {
            if (typeof loadFrame === "function") {
                loadFrame();
            }
        };
    },
};
