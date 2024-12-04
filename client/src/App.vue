<template>
  <v-app>
    <v-navigation-drawer 
      v-model="drawer" 
      :rail="rail" 
      permanent 
      color="grey-lighten-4"
      class="elevation-1"
    >
      <!-- Logo -->
      <div class="px-4 py-3 d-flex align-center justify-center">
        <div v-if="!rail" class="text-h6 font-weight-bold">TTMS</div>
        <div v-else class="text-h6 font-weight-bold">T</div>
      </div>

      <!-- Navigation Menu -->
      <v-list>
        <v-list-item
          prepend-icon="mdi-view-dashboard"
          title="Dashboard"
          value="dashboard"
          to="/"
        />
        
        <v-list-item
          prepend-icon="mdi-calendar"
          title="Reservas"
          value="reservations"
          to="/reservations"
        />

        <v-list-item
          prepend-icon="mdi-bus"
          title="Frota"
          value="fleet"
          to="/fleet"
        />

        <v-list-item
          prepend-icon="mdi-account-group"
          title="Motoristas"
          value="drivers"
          to="/drivers"
        />

        <v-list-item
          prepend-icon="mdi-map-marker-path"
          title="Roteiros"
          value="routes"
          to="/routes"
        />

        <v-list-item
          prepend-icon="mdi-tools"
          title="Manutenção"
          value="maintenance"
          to="/maintenance"
        />

        <v-list-item
          prepend-icon="mdi-package-variant"
          title="Estoque"
          value="inventory"
          to="/inventory"
        />

        <v-list-item
          prepend-icon="mdi-cash-multiple"
          title="Financeiro"
          value="financial"
          to="/financial"
        />
      </v-list>

      <!-- Toggle Button -->
      <template v-slot:append>
        <div class="pa-2">
          <v-btn
            block
            variant="text"
            icon="mdi-chevron-left"
            @click.stop="rail = !rail"
          />
        </div>
      </template>
    </v-navigation-drawer>

    <!-- Top Bar -->
    <v-app-bar color="white" elevation="1">
      <v-app-bar-title>{{ currentPageTitle }}</v-app-bar-title>
      
      <template v-slot:append>
        <v-btn icon="mdi-bell" variant="text" />
        <v-btn icon="mdi-cog" variant="text" />
        
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn
              class="ml-2"
              v-bind="props"
            >
              <v-avatar size="32" class="mr-2">
                <v-icon>mdi-account-circle</v-icon>
              </v-avatar>
              John Doe
              <v-icon right>mdi-chevron-down</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="(item, index) in profileMenu"
              :key="index"
              :value="index"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </template>
    </v-app-bar>

    <!-- Main Content -->
    <v-main class="bg-grey-lighten-4">
      <v-container fluid class="pa-6">
        <router-view v-slot="{ Component }">
          <component :is="Component" />
        </router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

const drawer = ref(true)
const rail = ref(false)

const currentPageTitle = computed(() => {
  // You can implement logic to get the current page title based on route
  return 'Dashboard'
})

const profileMenu = [
  { title: 'Perfil' },
  { title: 'Configurações' },
  { title: 'Sair' }
]
</script>

<style lang="scss">
.v-navigation-drawer {
  .v-list {
    padding: 8px;
    
    .v-list-item {
      margin-bottom: 4px;
      border-radius: 8px;
    }
  }
}
</style>
