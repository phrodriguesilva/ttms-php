<template>
  <div>
    <!-- Stats Cards -->
    <v-row>
      <v-col cols="12" md="3">
        <v-card class="rounded-lg">
          <v-card-text>
            <div class="d-flex justify-space-between align-center">
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Total de Reservas</div>
                <div class="text-h4 mt-2">127</div>
                <div class="text-caption text-success mt-1">
                  <v-icon small color="success">mdi-arrow-up</v-icon>
                  12% que o mês anterior
                </div>
              </div>
              <v-icon size="48" color="primary" class="opacity-6">mdi-calendar-check</v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="rounded-lg">
          <v-card-text>
            <div class="d-flex justify-space-between align-center">
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Receita Mensal</div>
                <div class="text-h4 mt-2">R$ 45.750</div>
                <div class="text-caption text-success mt-1">
                  <v-icon small color="success">mdi-arrow-up</v-icon>
                  8% que o mês anterior
                </div>
              </div>
              <v-icon size="48" color="success" class="opacity-6">mdi-cash-multiple</v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="rounded-lg">
          <v-card-text>
            <div class="d-flex justify-space-between align-center">
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Veículos Ativos</div>
                <div class="text-h4 mt-2">18</div>
                <div class="text-caption text-info mt-1">
                  <v-icon small color="info">mdi-circle</v-icon>
                  95% da frota
                </div>
              </div>
              <v-icon size="48" color="info" class="opacity-6">mdi-car-multiple</v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="rounded-lg">
          <v-card-text>
            <div class="d-flex justify-space-between align-center">
              <div>
                <div class="text-subtitle-2 text-medium-emphasis">Motoristas Disponíveis</div>
                <div class="text-h4 mt-2">12</div>
                <div class="text-caption text-warning mt-1">
                  <v-icon small color="warning">mdi-circle</v-icon>
                  80% do total
                </div>
              </div>
              <v-icon size="48" color="warning" class="opacity-6">mdi-account-group</v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Charts Row -->
    <v-row class="mt-4">
      <v-col cols="12" md="8">
        <v-card class="rounded-lg">
          <v-card-title class="d-flex align-center px-6 py-4">
            <span>Reservas por Período</span>
            <v-spacer></v-spacer>
            <v-btn-toggle v-model="timeRange" mandatory>
              <v-btn value="week" size="small">Semana</v-btn>
              <v-btn value="month" size="small">Mês</v-btn>
              <v-btn value="year" size="small">Ano</v-btn>
            </v-btn-toggle>
          </v-card-title>
          <v-card-text>
            <line-chart :chart-data="bookingsChartData" :options="chartOptions" height="300" />
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card class="rounded-lg">
          <v-card-title class="px-6 py-4">Status da Frota</v-card-title>
          <v-card-text>
            <doughnut-chart :chart-data="fleetChartData" :options="doughnutOptions" height="250" />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Latest Bookings and Maintenance -->
    <v-row class="mt-4">
      <v-col cols="12" md="6">
        <v-card class="rounded-lg">
          <v-card-title class="px-6 py-4">
            Últimas Reservas
            <v-spacer></v-spacer>
            <v-btn color="primary" variant="text">Ver todas</v-btn>
          </v-card-title>
          <v-card-text class="px-4">
            <v-list lines="two">
              <v-list-item
                v-for="booking in latestBookings"
                :key="booking.id"
                :title="booking.client"
                :subtitle="booking.date"
              >
                <template v-slot:prepend>
                  <v-avatar color="primary" variant="tonal">
                    <v-icon>mdi-calendar</v-icon>
                  </v-avatar>
                </template>
                <template v-slot:append>
                  <v-chip
                    :color="booking.status === 'confirmed' ? 'success' : 'warning'"
                    size="small"
                  >
                    {{ booking.status === 'confirmed' ? 'Confirmado' : 'Pendente' }}
                  </v-chip>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card class="rounded-lg">
          <v-card-title class="px-6 py-4">
            Manutenções Programadas
            <v-spacer></v-spacer>
            <v-btn color="primary" variant="text">Ver todas</v-btn>
          </v-card-title>
          <v-card-text class="px-4">
            <v-list lines="two">
              <v-list-item
                v-for="maintenance in maintenanceSchedule"
                :key="maintenance.id"
                :title="maintenance.vehicle"
                :subtitle="maintenance.service"
              >
                <template v-slot:prepend>
                  <v-avatar :color="maintenance.priority === 'high' ? 'error' : 'warning'" variant="tonal">
                    <v-icon>mdi-wrench</v-icon>
                  </v-avatar>
                </template>
                <template v-slot:append>
                  <div class="text-caption">{{ maintenance.date }}</div>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Line as LineChart, Doughnut as DoughnutChart } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, ArcElement } from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, ArcElement)

const timeRange = ref('month')

// Dados de exemplo para os gráficos
const bookingsChartData = ref({
  labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
  datasets: [{
    label: 'Reservas',
    data: [65, 59, 80, 81, 56, 55],
    borderColor: '#1867C0',
    tension: 0.4
  }]
})

const fleetChartData = ref({
  labels: ['Disponível', 'Em Uso', 'Manutenção'],
  datasets: [{
    data: [12, 5, 1],
    backgroundColor: ['#4CAF50', '#1867C0', '#FFC107']
  }]
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
}

const doughnutOptions = {
  responsive: true,
  maintainAspectRatio: false,
  cutout: '70%'
}

// Dados de exemplo para as listas
const latestBookings = ref([
  { id: 1, client: 'João Silva', date: '15/12/2023 - Transfer Aeroporto', status: 'confirmed' },
  { id: 2, client: 'Maria Santos', date: '16/12/2023 - City Tour', status: 'pending' },
  { id: 3, client: 'Pedro Costa', date: '17/12/2023 - Transfer Hotel', status: 'confirmed' },
])

const maintenanceSchedule = ref([
  { id: 1, vehicle: 'Van Mercedes 415 - ABC1234', service: 'Troca de Óleo', date: '18/12/2023', priority: 'normal' },
  { id: 2, vehicle: 'Van Sprinter - DEF5678', service: 'Revisão dos Freios', date: '19/12/2023', priority: 'high' },
  { id: 3, vehicle: 'Van Master - GHI9012', service: 'Alinhamento', date: '20/12/2023', priority: 'normal' },
])

onMounted(() => {
  // Aqui você pode fazer chamadas à API para buscar os dados reais
})
</script>

<style scoped>
.opacity-6 {
  opacity: 0.6;
}
</style>
