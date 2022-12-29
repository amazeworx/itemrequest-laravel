import "./bootstrap"

import "laravel-datatables-vite"
import "./datatables"

import Alpine from "alpinejs"
import flatpickr from "flatpickr"
import { createPopper } from "@popperjs/core"

window.flatpickr = flatpickr
window.createPopper = createPopper
window.Alpine = Alpine

Alpine.start()
