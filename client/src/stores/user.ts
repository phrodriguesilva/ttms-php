import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUserStore = defineStore('user', () => {
  const user = ref({
    id: null,
    name: '',
    email: '',
    avatar: '',
    role: ''
  })

  const isAuthenticated = ref(false)

  async function fetchUser() {
    try {
      const response = await fetch('/api/user')
      const data = await response.json()
      user.value = data
      isAuthenticated.value = true
    } catch (error) {
      console.error('Erro ao carregar dados do usuário:', error)
    }
  }

  async function login(credentials: { email: string; password: string }) {
    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
      })
      
      if (!response.ok) {
        throw new Error('Credenciais inválidas')
      }

      const data = await response.json()
      user.value = data.user
      isAuthenticated.value = true
      
      return true
    } catch (error) {
      console.error('Erro no login:', error)
      return false
    }
  }

  function logout() {
    user.value = {
      id: null,
      name: '',
      email: '',
      avatar: '',
      role: ''
    }
    isAuthenticated.value = false
  }

  return {
    user,
    isAuthenticated,
    fetchUser,
    login,
    logout
  }
})
