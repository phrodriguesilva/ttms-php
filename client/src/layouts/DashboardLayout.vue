&lt;template>
  &lt;v-app>
    &lt;v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
      @click="rail = false"
    >
      &lt;v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
        :title="userStore.name || 'Usuário'"
        nav
      >
        &lt;template v-slot:append>
          &lt;v-btn
            variant="text"
            icon="mdi-chevron-left"
            @click.stop="rail = !rail"
          >&lt;/v-btn>
        &lt;/template>
      &lt;/v-list-item>

      &lt;v-divider>&lt;/v-divider>

      &lt;v-list density="compact" nav>
        &lt;v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard" to="/" />
        &lt;v-list-item prepend-icon="mdi-calendar" title="Reservas" value="bookings" to="/bookings" />
        &lt;v-list-item prepend-icon="mdi-car" title="Veículos" value="vehicles" to="/vehicles" />
        &lt;v-list-item prepend-icon="mdi-account-group" title="Motoristas" value="drivers" to="/drivers" />
        &lt;v-list-item prepend-icon="mdi-package-variant" title="Estoque" value="supplies" to="/supplies" />
        &lt;v-list-item prepend-icon="mdi-airport" title="Aeroportos" value="airports" to="/airports" />
        &lt;v-list-item prepend-icon="mdi-account" title="Clientes" value="clients" to="/clients" />
      &lt;/v-list>

      &lt;template v-slot:append>
        &lt;div class="pa-2">
          &lt;v-list>
            &lt;v-list-item prepend-icon="mdi-cog" title="Configurações" value="settings" to="/settings" />
            &lt;v-list-item prepend-icon="mdi-logout" title="Sair" value="logout" @click="logout" />
          &lt;/v-list>
        &lt;/div>
      &lt;/template>
    &lt;/v-navigation-drawer>

    &lt;v-app-bar>
      &lt;v-app-bar-title>TTMS&lt;/v-app-bar-title>
      &lt;v-spacer>&lt;/v-spacer>
      &lt;v-btn icon="mdi-bell" variant="text">
        &lt;v-badge
          :content="notifications.length"
          :model-value="notifications.length > 0"
          color="error"
        >
        &lt;/v-badge>
      &lt;/v-btn>
    &lt;/v-app-bar>

    &lt;v-main class="bg-grey-lighten-3">
      &lt;v-container fluid>
        &lt;router-view>&lt;/router-view>
      &lt;/v-container>
    &lt;/v-main>
  &lt;/v-app>
&lt;/template>

&lt;script setup lang="ts">
import { ref } from 'vue'
import { useUserStore } from '@/stores/user'

const drawer = ref(true)
const rail = ref(false)
const userStore = useUserStore()
const notifications = ref([])

const logout = () => {
  // Implementar lógica de logout
}
&lt;/script>

&lt;style scoped>
.v-navigation-drawer {
  border-right: 1px solid rgba(0, 0, 0, 0.12);
}
&lt;/style>
