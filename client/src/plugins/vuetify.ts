import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

const ttmsTheme = {
  dark: false,
  colors: {
    primary: '#B4CD3A',
    secondary: '#FF9800',
    accent: '#2196F3',
    error: '#F44336',
    warning: '#FF9800',
    info: '#2196F3',
    success: '#4CAF50'
  }
}

export default createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'ttmsTheme',
    themes: {
      ttmsTheme
    }
  }
})
