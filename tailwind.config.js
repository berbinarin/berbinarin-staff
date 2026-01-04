import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: ["./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php", "./storage/framework/views/*.php", "./resources/views/**/*.blade.php"],

    theme: {
        extend: {
            fontFamily: {
                plusJakartaSans: ["Plus Jakarta Sans", "sans-serif"],
            },
            colors: {
                primary: "#3986a3",
                "primary-alt": "#75badb",
                disabled: "#70787D",
                "blur-bg": "#EAF8FF",
                "blur-bg-2": "#C7F8FF",
                "blur-black": "rgba(0, 0, 0, 0.54)",
                "card-box": "#F7F7F7",
                remote: "#9E9E9E",
                viewdata: "#3B82F6",
                "editdata-dashboardBtn": "#E9B306",
                "deletedata-dashboardBtn": "#EF4444",
                "blue-transparent": "rgba(16, 102, 129, 0.2)", // The 0.2 represents 20% opacity

            },
        },
    },
    safelist: [
        "bg-[#3fa2f6]",
        "bg-[#fbb03b]",
        "bg-[#406c9b]",
        "bg-[#6a3d00]",
        "bg-[#ef5350]",
        "bg-[#4caf50]",
        "bg-[#EAF8FF}",
        "bg-[#70787D]",
        "border-gray-300",
        "focus:border-gray-300",
        "border-gray-400",
        "focus:border-gray-400",
        {
            pattern: /^col-span-(\d+)$/,
            variants: ["sm", "md", "lg", "xl"],
        },
        {
            pattern: /^border-(gray|blue|red|green|yellow)-\d+$/,
            variants: ['hover', 'focus', 'active'],
        }
    ],

    plugins: [],
}
