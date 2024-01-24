import Alpine from "alpinejs";
import axios from "axios";

window.Alpine = Alpine;
Alpine.start();

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
