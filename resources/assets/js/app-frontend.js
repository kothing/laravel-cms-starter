import axios from "axios";
import * as coreui from "@coreui/coreui";
import { Livewire } from "~vendor/livewire/livewire/dist/livewire.esm";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Livewire.start();

/**
 * Enable tooltips everywhere
 */
(function ininTooltip() {
    const tooltipTriggerList = document.querySelectorAll('[data-toggle="tooltip"]') || [];
    [...tooltipTriggerList].map((tooltipTriggerEl) => new coreui.Tooltip(tooltipTriggerEl));
})();
