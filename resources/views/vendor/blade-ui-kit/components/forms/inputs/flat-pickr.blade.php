<div class="relative">
  <input x-data="{
        picker: null,
        initPicker() {
            if (this.picker) return;

            this.picker = flatpickr(this.$el, {{ $jsonOptions() }});
        }
    }" x-on:mouseenter="initPicker()" name="{{ $name }}" type="text" id="{{ $id }}"
    class="input input-bordered w-full focus:outline-offset-0" placeholder="{{ $placeholder }}" @if($value)
    value="{{ $value }}" @endif {{ $attributes }} />
  <div class="absolute top-0 right-0 px-3 py-3">
    <svg class="h-6 w-6 text-slate-400" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M19,4H17V3a1,1,0,0,0-2,0V4H9V3A1,1,0,0,0,7,3V4H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm1,15a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V12H20Zm0-9H4V7A1,1,0,0,1,5,6H7V7A1,1,0,0,0,9,7V6h6V7a1,1,0,0,0,2,0V6h2a1,1,0,0,1,1,1Z" />
    </svg>
  </div>
</div>