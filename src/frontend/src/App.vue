<script setup>
import { RouterLink, RouterView } from 'vue-router'
import TheHeader from "@/components/TheHeader.vue";
import {ref} from "vue";
import NewEmployeeModal from "@/components/NewEmployeeModal.vue";

async function searchEmployee(query) {
  console.log('Search employee: ' + query)
}

const isNewEmployeeModalVisible = ref(false)
</script>

<template>
  <NewEmployeeModal v-if="isNewEmployeeModalVisible"
      @close="isNewEmployeeModalVisible = false"
  />
  <TheHeader
      @search="searchEmployee"
      @addNew="isNewEmployeeModalVisible = true"
  />

  <RouterView />
</template>

<style scoped>

</style>
