<script>
import axios from "axios";

export default {
  name: "NewEmployeeModal",
  props: ['posts'],
  data() {
    return {
      name: '',
      email: '',
      phone: '',
      post: 1,
      birthdayDate: '',
      avatar: '',

      nameError: false,
    }
  },
  methods: {
    async addEmployeeHandler() {
      let data = {
        full_name: this.name,
        post: this.post,
        employment_date: new Date().toISOString().slice(0,10),
      }
      if (this.birthdayDate) {
        data.birth_date = this.birthdayDate
      }
      if (this.avatar) {
        data.avatar_url = this.avatar
      }
      if (this.email) {
        data.email = this.email
      }
      if (this.phone) {
        data.phone_number = this.phone.toString()
      }
      const result = await axios.post('/api/add-employee',data)
      if (result.status === 200 && result.data.success) {
        this.$emit('success')
      }
    }
  },
  watch: {
    async name() {
      this.nameError = this.name === ''
    },
  }
}
</script>

<template>
  <div class="modal" tabindex="-1" style="display: block">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Добавить нового сотрудника</h5>
          <button class="btn " @click="this.$emit('close')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="name" class="col-form-label">Фио</label>
              <input :class="{'is-invalid':nameError}" v-model="name" required type="text" class="form-control" id="name" placeholder="Необходимо">
            </div>
            <div class="form-group">
              <label for="post" class="col-form-label">Должность</label>
              <select v-model="post" class="form-control" name="post" id="post">
                <option v-for="(post, id) in posts" :value="id">{{post}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="email" class="col-form-label">E-Mail</label>
              <input v-model="email" type="text" class="form-control" id="email">
            </div>
            <div class="form-group">
              <label for="phone" class="col-form-label">Номер телефона</label>
              <input v-model="phone" type="number" class="form-control" id="phone">
            </div>
            <div class="form-group">
              <label for="birthdayDate" class="col-form-label">Дата рождения</label>
              <input v-model="birthdayDate" type="date" class="form-control" id="birthdayDate">
            </div>
            <div class="form-group">
              <label for="image" class="col-form-label">Ссылка на фотографию</label>
              <input v-model="avatar" type="text" class="form-control" id="image">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="this.$emit('close')">Отмена</button>
          <button type="button" class="btn btn-primary" @click="addEmployeeHandler()">Добавить</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>