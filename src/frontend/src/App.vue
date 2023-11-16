<script setup>
import { RouterLink, RouterView } from 'vue-router'
import TheHeader from "@/components/TheHeader.vue";
import {onMounted, ref, watch} from "vue";
import NewEmployeeModal from "@/components/NewEmployeeModal.vue";
import axios from "axios";
import EmployeeTable from "@/components/EmployeeTable.vue";
import Stat from "@/components/stat.vue";
import EmployeeDetails from "@/components/EmployeeDetails.vue";

const posts = ref({})
const employees = ref([])
const selectedEmployee = ref(false)

onMounted(async () => {
  await loadPosts()
  await loadEmployees()
})


const page = ref(1)
const totalPages = ref(1)
const searchValue = ref('')

watch(searchValue, async () => {
  page.value = 1
  await loadEmployees()
})

watch(page, async () => {
  if (page.value > totalPages.value) {
    page.value = totalPages.value
  }
  await loadEmployees()
})

async function loadPosts() {
  const result = await axios.get('/api/get-posts')
  if (result.status === 200) {
    result.data.forEach(post => {
      posts.value[post.id] = post.name
    })
  }
}
async function loadEmployees() {
  const result = await axios.get('/api/get-employees',
      {
        params: {
          search: searchValue.value,
          page: page.value
        }
      })
  if (result.status === 200) {
    employees.value = result.data.employees
    totalPages.value = result.data.pageCount
  }
}


async function selectEmployee(id) {
  selectedEmployee.value = id
}

const isNewEmployeeModalVisible = ref(false)
</script>

<template>
  <NewEmployeeModal v-if="isNewEmployeeModalVisible"
      :posts="posts"
      @close="isNewEmployeeModalVisible = false"
      @success="isNewEmployeeModalVisible = false; loadEmployees()"
  />
  <TheHeader
      @search="(query) => {searchValue = query}"
      @addNew="isNewEmployeeModalVisible = true"
  />
  <div class="row my-4 mx-2">
    <div class="col-9">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div class="">
            <h5>Все сотрудники</h5>
          </div>
          <div>
            <div class="d-flex">
              <button class="col-2 btn btn-sm" @click="page = 1" v-if="page != 1">«</button>
              <button class="btn btn-sm" @click="page--" v-if="page != 1">{{ page - 1 }}</button>
              <button class="btn btn-sm btn-primary disabled">{{ page }}</button>
              <button class="btn btn-sm"  @click="page++" v-if="page < totalPages">{{ page + 1 }}</button>
              <button class="btn btn-sm" @click="page = totalPages" v-if="page < totalPages">»</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <EmployeeTable
              :employees="employees"
              :posts="posts"

              @select="selectEmployee"
          />
        </div>
        <div class="card-footer d-flex justify-content-center">
          <div class="d-flex">
            <button class="col-2 btn btn-sm" @click="page = 1" v-if="page != 1">«</button>
            <button class="btn btn-sm" @click="page--" v-if="page != 1">{{ page - 1 }}</button>
            <button class="btn btn-sm btn-primary disabled">{{ page }}</button>
            <button class="btn btn-sm"  @click="page++" v-if="page < totalPages">{{ page + 1 }}</button>
            <button class="btn btn-sm" @click="page = totalPages" v-if="page < totalPages">»</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-header">
          <h5>Карточка сотрудника</h5>
        </div>
        <div class="card-body">
          <EmployeeDetails
              :id="selectedEmployee"
              :posts="posts"

              @edited="loadEmployees()"
          />
        </div>
      </div>
      <div class="card mt-4">
        <div class="card-header">
          <h5>Статистика</h5>
        </div>
        <div class="card-body">
          <stat
              :posts="posts"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
