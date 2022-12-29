@props(['value', 'id'])

<style>
  [x-cloak] {
    display: none;
  }
</style>

<div x-data="datepicker()" x-init="[initDate(), getNoOfDays()]" x-cloak>
  <div class="relative">
    <input type="hidden" id="{{ $id }}" name="{{ $id }}" x-model="selectedDateValue" x-ref="date">
    <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker"
      @keydown.escape="showDatepicker = false" class="input input-bordered w-full focus:outline-offset-0"
      placeholder="Select date">

    <div class="absolute top-0 right-0 px-3 py-3">
      <svg class="h-6 w-6 text-slate-400" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19,4H17V3a1,1,0,0,0-2,0V4H9V3A1,1,0,0,0,7,3V4H5A3,3,0,0,0,2,7V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm1,15a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V12H20Zm0-9H4V7A1,1,0,0,1,5,6H7V7A1,1,0,0,0,9,7V6h6V7a1,1,0,0,0,2,0V6h2a1,1,0,0,1,1,1Z" />
      </svg>
    </div>

    {{-- <div x-text="no_of_days.length"></div>
    <div x-text="32 - new Date(year, month, 32).getDate()"></div>
    <div x-text="new Date(year, month).getDay()"></div> --}}

    <div class="bg-slate-50 mt-12 rounded-lg shadow-md p-4 absolute top-0 left-0" style="width: 17rem"
      x-show.transition="showDatepicker" @click.away="showDatepicker = false">

      <div class="flex justify-between items-center mb-2">
        <div>
          <span x-text="MONTH_NAMES[month]" class="text-base font-bold text-gray-800"></span>
          <span x-text="year" class="ml-1 text-base text-gray-600 font-normal"></span>
        </div>
        <div>
          <button type="button"
            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
            :class="{'cursor-not-allowed opacity-25': month == 0 }" :disabled="month == 0 ? true : false"
            @click="month--; getNoOfDays()">
            <svg class="h-5 w-5 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button type="button"
            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
            :class="{'cursor-not-allowed opacity-25': month == 11 }" :disabled="month == 11 ? true : false"
            @click="month++; getNoOfDays()">
            <svg class="h-5 w-5 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

      <div class="grid grid-cols-7 mb-3">
        <template x-for="(day, index) in DAYS" :key="index">
          <div x-text="day" class="text-gray-800 font-semibold text-center text-xs"></div>
        </template>
      </div>

      <div class="grid grid-cols-7 gap-0.5">
        <template x-for="blankday in blankdays">
          <div class="text-center border border-transparent text-sm"></div>
        </template>
        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
          <div class="aspect-w-1 aspect-h-1">
            <div @click="getDateValue(date)" x-text="date"
              class="flex items-center justify-center cursor-pointer text-center text-xs rounded-full transition ease-in-out duration-100 border border-transparent"
              :class="{'bg-transparent border-primary text-primary' : isToday(date) == true, 'text-gray-700 hover:bg-primary/20' : isToday(date) == false }">
            </div>
          </div>
        </template>
      </div>
    </div>

  </div>
</div>

<script>
  const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

  function datepicker() {
    return {
      showDatepicker: false,
      datepickerValue: '',
      selectedDateValue: '',
      month: '',
      year: '',
      no_of_days: [],
      blankdays: [],
      days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

      initDate() {
        let today = new Date();
        this.month = today.getMonth();
        this.year = today.getFullYear();
        this.datepickerValue = today.toLocaleDateString('id-ID');
        this.selectedDateValue = today.toISOString().slice(0, 10);
        console.log(`{{ $id }}`, this.datepickerValue);
        console.log(`{{ $value }}`, this.selectedDateValue);
      },

      isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);

        return today.toDateString() === d.toDateString() ? true : false;
      },

      getDateValue(date) {
        let selectedDate = new Date(this.year, this.month, date);
        this.datepickerValue = selectedDate.toLocaleDateString('id-ID');
        let selectedYear = selectedDate.getFullYear();
        let selectedMonth = selectedDate.getMonth() + 1;
        let selectedDay = selectedDate.getDate();
        this.$refs.date.value = selectedYear + "-" + ('0' + selectedMonth).slice(-2) + "-" + ('0' + selectedDay).slice(-2);

        //console.log(this.$refs.date.value);

        this.showDatepicker = false;

      },

      getNoOfDays() {
        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

        // find where to start calendar day of week
        let dayOfWeek = new Date(this.year, this.month).getDay();
        let blankdaysArray = [];
        for ( var i=1; i <= dayOfWeek; i++) {
            blankdaysArray.push(i);
        }

        let daysArray = [];
        for ( var i=1; i <= daysInMonth; i++) {
            daysArray.push(i);
        }

        this.blankdays = blankdaysArray;
        this.no_of_days = daysArray;
      }
    }
  }
</script>