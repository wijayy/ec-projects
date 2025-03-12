import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
                Inter: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mine: {
                    100: "#EAF6F6",
                    200: "#66BFBF",
                    300: "#FF0063",
                },
            },
            boxShadow: {
                mine: "4px 4px 10px rgba(0, 0, 0, 0.2)",
            },
        },
    },

    plugins: [forms],
};
