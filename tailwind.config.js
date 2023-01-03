const defaultTheme = require("tailwindcss/defaultTheme")

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class", '[data-theme="dark"]'],
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/views/**/*.js",
    "./app/DataTables/*.php",
    "./vendor/rawilk/laravel-form-components/src/**/*.php",
    "./vendor/rawilk/laravel-form-components/resources/**/*.php",
    "./vendor/rawilk/laravel-form-components/resources/js/*.js",
  ],
  safelist: [
    "bg-gray-900",
    "bg-opacity-50",
    "block",
    "border-0",
    "cursor-pointer",
    "dark:bg-opacity-80",
    "dark:hover:bg-gray-600",
    "dark:text-gray-400",
    "dark:text-white",
    "fixed",
    "flex-1",
    "font-medium",
    "font-semibold",
    "grid-cols-7",
    "grid",
    "h-6",
    "hover:bg-gray-100",
    "inset-0",
    "leading-6",
    "leading-9",
    "p-1",
    "rounded-lg",
    "text-center",
    "text-gray-500",
    "text-gray-900",
    "text-sm",
    "w-64",
    "z-40",
    "inline-flex",
    "gap-x-2",
    "flex-col",
    "flex-row",
    "sm:flex-row",
    "md:justify-end",
    "md:block",
    "capitalize",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: [...defaultTheme.fontFamily.sans],
      },
    },
  },

  corePlugins: {
    aspectRatio: false,
  },

  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/aspect-ratio"),
    require("daisyui"),
    //require("flowbite/plugin"),
  ],

  // daisyUI config (optional)
  daisyui: {
    styled: true,
    themes: false,
    base: true,
    utils: true,
    logs: true,
    rtl: false,
    prefix: "",
    darkTheme: "dark",
  },
}
