import "./bootstrap"

//import "laravel-datatables-vite"
//import $ from "jquery"
//import "./datatables"
//import DataTable from "datatables.net"
//import "datatables.net-buttons"
//import "datatables.net-select"
import "laravel-datatables-vite/js/dataTables.buttons.js"
import "laravel-datatables-vite/js/dataTables.renderers.js"

import Alpine from "alpinejs"
import { createPopper } from "@popperjs/core"

window.createPopper = createPopper
window.Alpine = Alpine

Alpine.start()
