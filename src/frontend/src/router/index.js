import { createRouter, createWebHistory } from 'vue-router'
import EmployeesTable from '../views/EmployeesTable.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Главная',
      component: EmployeesTable
    },
    {
      path: '/employee/:id',
      name: 'Страница сотрудника',
      component: () => import('../views/Employee.vue')
    }
  ]
})

export default router
