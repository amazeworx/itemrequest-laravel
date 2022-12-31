import "./bootstrap"

import "laravel-datatables-vite"
//import "./datatables"

import "./datatables/dataTables.responsive"

import Alpine from "alpinejs"
//import flatpickr from "flatpickr"
import { createPopper } from "@popperjs/core"

//window.flatpickr = flatpickr
window.createPopper = createPopper
window.Alpine = Alpine

Alpine.start()
