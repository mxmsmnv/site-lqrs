tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ["Riviera Nights", "sans-serif"],
                geist: ["Geist", "sans-serif"],
            },
            fontSize: {
                xs: "0.75rem", // 12px
                sm: "0.875rem", // 14px
                base: "1.125rem", // 18px
                lg: "1.25rem", // 20px
                xl: "1.5rem", // 24px
                "2xl": "1.875rem", // 30px
                "3xl": "2.25rem", // 36px
                "4xl": "3rem", // 48px
                "5xl": "3.75rem", // 60px
                "6xl": "4.5rem", // 72px
            },
            animation: {
                marquee: 'marquee 60s linear infinite',
                marquee2: 'marquee2 60s linear infinite',
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                marquee: {
                    "0%": { transform: "translateX(0%)" },
                    "100%": { transform: "translateX(-100%)" },
                },
                marquee2: {
                    "0%": { transform: "translateX(100%)" },
                    "100%": { transform: "translateX(0%)" },
                },
            },
            colors: {
                stromboli: {
                    "50": "#f1f8f5",
                    "100": "#ddeee4",
                    "200": "#bedccc",
                    "300": "#92c3ac",
                    "400": "#64a388",
                    "500": "#43866c",
                    "600": "#316a55",
                    "700": "#255142",
                    "800": "#214438",
                    "900": "#1c382f",
                    "950": "#0f1f1a",
                },

                mindaro: {
                    "50": "#fbfee7",
                    "100": "#f5fccb",
                    "200": "#eafa9c",
                    "300": "#daf46b",
                    "400": "#c3e833",
                    "500": "#a5ce14",
                    "600": "#80a40c",
                    "700": "#617d0e",
                    "800": "#4d6311",
                    "900": "#415413",
                    "950": "#212e05",
                },

                mustard: {
                    "50": "#fffceb",
                    "100": "#fef5c7",
                    "200": "#fce98b",
                    "300": "#fbd955",
                    "400": "#fac425",
                    "500": "#f3a50d",
                    "600": "#d87d07",
                    "700": "#b3580a",
                    "800": "#91440f",
                    "900": "#773810",
                    "950": "#451c03",
                },
            },
        },
    },
};
