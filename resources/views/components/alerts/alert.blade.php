@props(['alertId' => 'alert', 'type' => 'success', 'icon' => false, 'dismiss' => false])

@php
switch ($type) {
case 'success':
$alertId = 'alert-success';
$alertClasses = 'bg-green-100 dark:bg-green-200';
$textClasses = 'text-green-700 dark:text-green-800';
$iconClasses = 'text-green-700 dark:text-green-800';
$dismissClasses = 'bg-green-100 text-green-500 focus:ring-2 focus:ring-green-400 hover:bg-green-200 dark:bg-green-200
dark:text-green-600 dark:hover:bg-green-300';
break;
default:
$id = 'alert-success';
$alertClasses = 'bg-green-100 dark:bg-green-200';
$textClasses = 'text-green-700 dark:text-green-800';
$iconClasses = 'text-green-700 dark:text-green-800';
$dismissClasses = 'bg-green-100 text-green-500 focus:ring-2 focus:ring-green-400 hover:bg-green-200 dark:bg-green-200
dark:text-green-600 dark:hover:bg-green-300';
break;
}

@endphp

<div id="{{ $alertId }}" role="alert" class="flex p-4 mb-4 gap-x-3 rounded-lg {{ $alertClasses }}">

  @if ($icon)
  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 {{ $iconClasses }}" fill="currentColor" viewBox="0 0 20 20"
    xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd"
      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
      clip-rule="evenodd"></path>
  </svg>
  @endif

  <div class="text-sm font-medium {{ $textClasses }}">
    {{ $slot }}
  </div>

  @if ($dismiss)
  <button id="dismiss-{{ $alertId }}" type="button"
    class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 {{ $dismissClasses }}" aria-label="Close">
    <span class="sr-only">Close</span>
    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd"
        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
        clip-rule="evenodd"></path>
    </svg>
  </button>
  <script>
    // target element that will be dismissed
    const targetEl = document.getElementById({{ $alertId }});

    // options object
    const options = {
      triggerEl: document.getElementById('dismiss-{{ $alertId }}'),
      transition: 'transition-opacity',
      duration: 1000,
      timing: 'ease-out',

      // callback functions
      onHide: (context, targetEl) => {
        console.log('element has been dismissed')
        console.log(targetEl)
      }
    };

    const dismiss = new Dismiss(targetEl, options);

    dismiss.hide();
  </script>
  @endif

</div>