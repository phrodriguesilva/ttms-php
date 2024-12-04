import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useDashboardStore = defineStore('dashboard', () => {
  const stats = ref({
    totalBookings: 0,
    monthlyRevenue: 0,
    activeVehicles: 0,
    availableDrivers: 0
  })

  const bookings = ref([])
  const maintenanceSchedule = ref([])
  const bookingsChart = ref({
    labels: [],
    data: []
  })
  const fleetStatus = ref({
    available: 0,
    inUse: 0,
    maintenance: 0
  })

  async function fetchDashboardData() {
    try {
      // Aqui você fará as chamadas à API
      const response = await fetch('/api/dashboard')
      const data = await response.json()
      
      // Atualizar os dados
      stats.value = data.stats
      bookings.value = data.bookings
      maintenanceSchedule.value = data.maintenance
      bookingsChart.value = data.bookingsChart
      fleetStatus.value = data.fleetStatus
    } catch (error) {
      console.error('Erro ao carregar dados do dashboard:', error)
    }
  }

  return {
    stats,
    bookings,
    maintenanceSchedule,
    bookingsChart,
    fleetStatus,
    fetchDashboardData
  }
})
