const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  prefix: '',
  important: false,
  separator: ':',
  purge: ['app/templates/**/*.ss', 'app/client/src/scripts/**/*.js'],
  theme: {
    fontSize: {
      xs: '12px',
      sm: '14px',
      base: '16px',
      lg: '18px',
      xl: ['22px', '1.4'],
      '2xl': ['24px', '1.3'],
      '3xl': ['32px', '1.2'],
      '4xl': ['40px', '1.2'],
      '5xl': ['48px', '1.1'],
      '6xl': ['56px', '1.1'],
      '7xl': ['64px', '1.1'],
      '8xl': ['72px', '1.1'],
    },
    letterSpacing: {
      tightest: '-.5em',
      tighter: '-.1em',
      tight: '-.05em',
      normal: '0',
      wide: '.05em',
      wider: '.1em',
      widest: '.5em',
    },
    extend: {
      colors: {
        primary: {
          lightest: '#D6D4DD',
          lighter: '#BDBAC9',
          light: '#8C86A0',
          default: '#5A5277',
          dark: '#514A6B',
          darker: '#363147',
          darkest: '#292536',
        },
        secondary: {
          lightest: '#DAEFD2',
          lighter: '#C4E6B7',
          light: '#97D381',
          default: '#6BC04B',
          dark: '#60AD44',
          darker: '#40732D',
          darkest: '#305622',
        },
        accent: {
          lightest: '#FFF4DF',
          lighter: '#FFEDCC',
          light: '#FFE0A5',
          default: '#FFD27F',
          dark: '#E6BD72',
          darker: '#997E4C',
          darkest: '#735F39',
        },
      },
      fontFamily: {
        sans: [
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica',
          'Arial',
          'sans-serif',
          ...defaultTheme.fontFamily.sans,
        ],
      },
      screens: {
        'sm-down': {
          max: '767px',
        },
        'md-down': {
          max: '1023px',
        },
        '2xl': '1440px',
        '3xl': '1920px',
        print: {
          raw: 'print',
        },
      },
    },
  },
  variants: {
    fontFamily: false,
  },
  corePlugins: {
    container: false,
  },
  plugins: [],
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true,
  },
}
