const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  prefix: '',
  important: false,
  separator: ':',
  purge: {
    content: ['app/templates/**/*.ss', 'app/client/src/scripts/**/*.js'],
  },
  theme: {
    fontSize: {
      xs: ['0.75rem', { lineHeight: '1rem' }],
      sm: ['0.875rem', { lineHeight: '1.15rem' }],
      base: ['1rem', { lineHeight: '1.3rem' }],
      lg: ['1.125rem', { lineHeight: '1.5rem' }],
      xl: ['1.25rem', { lineHeight: '1.65rem' }],
      '2xl': ['1.5rem', { lineHeight: '2rem' }],
      '3xl': ['2rem', { lineHeight: '2.6rem' }],
      '4xl': ['2.5rem', { lineHeight: '1' }],
      '5xl': ['3rem', { lineHeight: '1' }],
      '6xl': ['3.5rem', { lineHeight: '1' }],
      '7xl': ['4rem', { lineHeight: '1' }],
      '8xl': ['5rem', { lineHeight: '1' }],
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
          200: '#D6D4DD',
          300: '#BDBAC9',
          400: '#8C86A0',
          500: '#5A5277',
          600: '#514A6B',
          700: '#363147',
          800: '#292536',
        },
        secondary: {
          200: '#DAEFD2',
          300: '#C4E6B7',
          400: '#97D381',
          500: '#6BC04B',
          600: '#60AD44',
          700: '#40732D',
          800: '#305622',
        },
        accent: {
          200: '#FFF4DF',
          300: '#FFEDCC',
          400: '#FFE0A5',
          500: '#FFD27F',
          600: '#E6BD72',
          700: '#997E4C',
          800: '#735F39',
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
    hidden: ['responsive', 'hover', 'focus', 'group-hover', 'group-focus'],
  },
  corePlugins: {
    container: false,
  },
  plugins: [],
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true,
    defaultLineHeights: true,
    standardFontWeights: true,
  },
}
