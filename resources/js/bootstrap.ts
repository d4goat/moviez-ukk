import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import jQuery from "jquery";

window.$ = window.jQuery = jQuery;

import Swal from "sweetalert2";

window.Swal = Swal;