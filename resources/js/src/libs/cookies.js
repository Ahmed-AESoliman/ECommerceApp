// cookiesPlugin.js
import Cookies from "js-cookie";

const CookiesPlugin = {
  install(app) {
    app.config.globalProperties.$cookies = Cookies;
  }
};

export default CookiesPlugin;
