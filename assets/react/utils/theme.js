// color design tokens export
export const tokens = (mode) => ({
  ...(mode === "dark"
    ? {
        grey: {
          100: "#e0e0e0",
          200: "#c2c2c2",
          300: "#a3a3a3",
          400: "#858585",
          500: "#666666",
          600: "#525252",
          700: "#3d3d3d",
          800: "#292929",
          900: "#141414",
        },
        primary: {
          100: "#d0d1d5",
          200: "#a1a4ab",
          300: "#727681",
          400: "#1F2A40",
          500: "#141b2d",
          600: "#101624",
          700: "#0c101b",
          800: "#080b12",
          900: "#040509",
        },
        greenAccent: {
          100: "#dbf5ee",
          200: "#b7ebde",
          300: "#94e2cd",
          400: "#8ec541",
          500: "#4cceac",
          600: "#3da58a",
          700: "#2e7c67",
          800: "#1e5245",
          900: "#0f2922",
        },
        redAccent: {
          100: "#f8dcdb",
          200: "#f1b9b7",
          300: "#e99592",
          400: "#e2726e",
          500: "#db4f4a",
          600: "#af3f3b",
          700: "#832f2c",
          800: "#58201e",
          900: "#2c100f",
        },
        blueAccent: {
          100: "#e1e2fe",
          200: "#c3c6fd",
          300: "#a4a9fc",
          400: "#868dfb",
          500: "#6870fa",
          600: "#535ac8",
          700: "#3e4396",
          800: "#2a2d64",
          900: "#151632",
        },
      }
    : {
        grey: {
          100: "#141414",
          200: "#292929",
          300: "#3d3d3d",
          400: "#525252",
          500: "#666666",
          600: "#858585",
          700: "#a3a3a3",
          800: "#c2c2c2",
          900: "#e0e0e0",
        },
        primary: {
          100: "#040509",
          200: "#080b12",
          300: "#0c101b",
          400: "#f2f0f0", // manually changed
          500: "#141b2d",
          600: "#1F2A40",
          700: "#727681",
          800: "#a1a4ab",
          900: "#d0d1d5",
        },
        greenAccent: {
          100: "#0f2922",
          200: "#1e5245",
          300: "#2e7c67",
          400: "#3da58a",
          500: "#4cceac",
          600: "#8ec541",
          700: "#94e2cd",
          800: "#b7ebde",
          900: "#dbf5ee",
        },
        redAccent: {
          100: "#2c100f",
          200: "#58201e",
          300: "#832f2c",
          400: "#af3f3b",
          500: "#db4f4a",
          600: "#e2726e",
          700: "#e99592",
          800: "#f1b9b7",
          900: "#f8dcdb",
        },
        blueAccent: {
          100: "#151632",
          200: "#2a2d64",
          300: "#3e4396",
          400: "#535ac8",
          500: "#6870fa",
          600: "#868dfb",
          700: "#a4a9fc",
          800: "#c3c6fd",
          900: "#e1e2fe",
        },
      }),
});

// mui theme settings
export const themeSettings = (mode) => {
  const colors = tokens(mode);
  return {
    palette: {
      mode: mode,
      ...(mode === "dark"
        ? {
            // palette values for dark mode
            primary: {
              main: colors.primary[500],
            },
            secondary: {
              main: colors.greenAccent[500],
            },
            neutral: {
              dark: colors.grey[700],
              main: colors.grey[500],
              light: colors.grey[100],
            },
            background: {
              default: colors.primary[500],
            },
            sidebar: {
              backgroundColor: "#0b2948",
              color: "#8ba1b7",
            },
            entete: {
              title: colors.redAccent[400],
              subtitle1: colors.blueAccent[300],
              subtitle2: colors.greenAccent[600],
              address: colors.grey[900],
            },
            welcome: {
              content: "#59d0ff",
              gradient: {
                first: colors.blueAccent[500],
                second: colors.blueAccent[200],
              },
            },
            menu: {
              menuContent: "#082440",
              icon: "#59d0ff",
              hover: {
                backgroundColor: "#00458b",
                color: "#b6c8d9",
              },
              disabled: {
                color: "#3e5e7e",
              },
            },
          }
        : {
            // palette values for light mode
            primary: {
              main: colors.primary[100],
            },
            secondary: {
              main: colors.greenAccent[500],
            },
            neutral: {
              dark: colors.grey[700],
              main: colors.grey[500],
              light: colors.grey[100],
            },
            background: {
              default: "#fcfcfc",
            },
            sidebar: {
              backgroundColor: "#ffffff",
              color: "#607489",
            },
            welcome: {
              content: "#0098e5",
              gradient: {
                first: colors.blueAccent[500],
                second: colors.blueAccent[600],
              },
            },
            entete: {
              title: colors.redAccent[400],
              subtitle1: colors.blueAccent[300],
              subtitle2: colors.greenAccent[600],
              address: colors.grey[200],
            },
            menu: {
              menuContent: "#fbfcfd",
              icon: "#0098e5",
              hover: {
                backgroundColor: "#c5e4ff",
                color: "#44596e",
              },
              disabled: {
                color: "#9fb6cf",
              },
            },
          }),
    },
    typography: {
      allVariants: {
        fontSize: 11,
        textTransform: "none",
      },
      h1: {
        fontWeight: 700,
        fontSize: "32px",
        lineHeight: "40px",
        textTransform: "uppercase",
      },
      h2: {
        fontWeight: 700,
        fontSize: "28px",
        lineHeight: "36px",
        textTransform: "capitalize",
      },
      h3: {
        fontWeight: 700,
        fontSize: "24px",
        lineHeight: "32px",
        textTransform: "capitalize",
      },
      h4: {
        fontSize: 20,
      },
      h5: {
        textTransform: "uppercase",
        fontSize: 16,
      },
      h6: {
        fontSize: 14,
        fontWeight: 900,
      },
    },
    components: {
      MuiPaper: {
        styleOverrides: {
          root: ({ theme }) => ({
            backgroundColor: theme.palette.menu.menuContent,
            color:
              theme.palette.mode == "dark"
                ? theme.palette.grey[100]
                : theme.palette.grey[900],
          }),
        },
      },
    },
  };
};
