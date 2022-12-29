<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-blue-700 border
  border-transparent rounded-md font-medium text-sm leading-5 text-white hover:bg-blue-800
  focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800
  transition ease-in-out duration-150']) }}>
  {{ $slot }}
</button>