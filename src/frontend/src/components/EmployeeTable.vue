<script>
export default {
  name: "EmployeeTable",
  props: ['employees', 'posts'],
  data(){
    return {
      dataToView: []
    }
  },
  watch: {
    async employees() {
      console.log(this.employees)
      let resData = []
      this.employees.forEach(employee => {
        const dateStart = new Date(Date.parse(employee.employment_date))
        const dateEnd = employee.end_date ? new Date(Date.parse(employee.end_date)) : false
        const birthday = employee.birth_date ? new Date(Date.parse(employee.birth_date)) : false
        resData.push({
          id: employee.id,
          full_name: employee.full_name,
          post: this.posts[employee.post],
          birthday: birthday ? birthday.toLocaleDateString() : '-',
          phone: employee.phone_number ? employee.phone_number : '-',
          email: employee.email ? employee.email : '-',
          start_date: dateStart.toLocaleDateString(),
          end_date: dateEnd ? dateEnd.toLocaleDateString() : '-',
          active: dateEnd ? (dateEnd > new Date() ? 'Активен' : 'Уволен') : 'Активен'
        })
      })
      this.dataToView = resData
    }
  }
}
</script>

<template>
  <div class="table-responsive ">
    <table class="table table-striped table-sm table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Должность</th>
        <th>Дата рождения</th>
        <th>К.Т.</th>
        <th>E-Mail</th>
        <th>Дата трудоустройства</th>
        <th>Дата увольнения</th>
        <th>Статус</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="employee in dataToView" @click="$emit('select', employee.id)" style="cursor:pointer">
        <td>{{employee.id}}</td>
        <td>{{employee.full_name}}</td>
        <td>{{employee.post}}</td>
        <td>{{employee.birthday}}</td>
        <td>{{employee.phone}}</td>
        <td>{{employee.email}}</td>
        <td>{{employee.start_date}}</td>
        <td>{{employee.end_date}}</td>
        <td>{{employee.active}}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>

</style>