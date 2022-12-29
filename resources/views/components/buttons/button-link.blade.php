@php
// Style
// elevated
// filled
// tonal
// outlined
// text

$buttonClasses = '';

switch ($style) {
case 'text':
$buttonClasses .= ' bg-transparent text-blue-700 hover:text-blue-800 focus:ring-blue-300 dark:text-blue-600
dark:hover:text-blue-700 dark:focus:ring-blue-800';
break;
default:
$buttonClasses .= ' text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700
dark:focus:ring-blue-800';
break;
}

// Theme
// primary
// red
switch ($theme) {
case 'red':
if ($style == 'text') {
$buttonClasses .= ' text-red-700 hover:text-red-800 focus:ring-red-300 dark:text-red-400 dark:hover:text-red-500
dark:focus:rign-red-300';
}
break;
default:
$buttonClasses .= '';
break;
}

// Icon
switch ($icon) {
case 'trash';
$iconCode = '<div class="text-base leading-5 w-5 h-5 text-center -ml-2"><i class="uil uil-trash-alt"></i></div>';
break;
default:
$iconCode = '';
break;
}

@endphp
<a {{ $attributes->merge(['class' => 'inline-flex gap-x-2 items-center px-6 py-2.5 border
  border-transparent rounded-md font-medium text-sm leading-[20px]
  focus:outline-none focus:ring-4 transition ease-in-out duration-150 cursor-pointer ' . $buttonClasses]) }}>
  @if ($icon)
  {!! $iconCode !!}
  @endif
  <span>{{ $slot }}</span>
</a>