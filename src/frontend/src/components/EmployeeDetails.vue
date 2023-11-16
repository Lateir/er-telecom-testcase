<script>
import axios from "axios";

export default {
  name: "EmployeeDetails",
  props: ['id', 'posts'],
  data() {
    return {
      dataToView: {},
      loading: false,
      error: false,
      editable: false,
      loadedData: {},
      fioError: false,
    }
  },
  methods: {
    async loadEmployee() {
      this.loading = true;
      this.error = false;
      this.editable = false;
      const result = await axios.get('/api/get-employee',
          {
            params: {
              id: this.id,
            }
          })
      if (result.status === 200) {
        this.loadedData = result.data

        const dateStart = new Date(Date.parse(this.loadedData.employment_date))
        const dateEnd = this.loadedData.end_date ? new Date(Date.parse(this.loadedData.end_date)) : false
        const birthday = this.loadedData.birth_date ? new Date(Date.parse(this.loadedData.birth_date)) : false

        this.dataToView = {
          id: this.loadedData.id,
          full_name: this.loadedData.full_name,
          post: this.posts[this.loadedData.post],
          birthday: birthday ? birthday.toLocaleDateString() : '-',
          phone: this.loadedData.phone_number ? this.loadedData.phone_number : '-',
          email: this.loadedData.email ? this.loadedData.email : '-',
          start_date: dateStart.toLocaleDateString(),
          end_date: dateEnd ? dateEnd.toLocaleDateString() : '-',
          active: dateEnd ? (dateEnd > new Date() ? 'Активен' : 'Уволен') : 'Активен',
          avatar: this.loadedData.avatar_url
        }
        this.loading = false
      } else {
        this.error = true;
        this.loading = false
      }
    },

    async fire() {
      await axios.post('/api/update-employee?id=' + this.id,
          {
            end_date: new Date().toISOString().slice(0,10),
          })
      this.$emit('edited')
      await this.loadEmployee()
    },

    async edit() {
      this.fioError = false
      if (this.loadedData.full_name === '') {
        this.fioError = true
        return
      }
      this.editable = false;
      this.loadedData.phone_number = this.loadedData.phone_number ? this.loadedData.phone_number.toString() : ''
      await axios.post('/api/update-employee?id=' + this.id,this.loadedData)
      this.$emit('edited')
      await this.loadEmployee()
    }
  },
  watch: {
    async id() {
      await this.loadEmployee()
    }
  }
}
</script>

<template>
  <div v-if="id">
    <div v-if="loading">
      Загрузка...
    </div>
    <div v-else-if="error">
      Произошла ошибка загрузки
    </div>
    <div v-else-if="editable">
      <form>
        <div class="form-group">
          <label for="name" class="col-form-label">ФИО</label>
          <input :class="{'is-invalid':fioError}" v-model="loadedData.full_name" required type="text" class="form-control" id="name" placeholder="Необходимо">
        </div>
        <div class="form-group">
          <label for="post" class="col-form-label">Должность</label>
          <select v-model="loadedData.post" class="form-control" name="post" id="post">
            <option v-for="(post, id) in posts" :value="id">{{post}}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="birthday" class="col-form-label">Дата рождения</label>
          <input v-model="loadedData.birth_date" type="date" class="form-control" id="birthday">
        </div>
        <div class="form-group">
          <label for="phone" class="col-form-label">Номер телефона</label>
          <input v-model="loadedData.phone_number" type="number" class="form-control" id="phone">
        </div>
        <div class="form-group">
          <label for="email" class="col-form-label">E-Mail</label>
          <input v-model="loadedData.email" type="text" class="form-control" id="email">
        </div>
        <div class="form-group">
          <label for="image" class="col-form-label">Ссылка на фото</label>
          <input v-model="loadedData.avatar_url" type="text" class="form-control" id="image">
        </div>
      </form>
      <div class="d-flex justify-content-md-between mt-4">
        <button @click="editable = false" class="btn btn-secondary">Отмена</button>
        <button @click="edit()" class="btn btn-success">Сохранить</button>
      </div>
    </div>
    <div v-else>
      <div>
        <div v-if="dataToView.avatar">
          <img class="card-img" :src="dataToView.avatar" alt="avatar">
        </div>
        <div v-else>
          <svg class="card-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="300px" width="300px" version="1.1" id="Layer_1" viewBox="0 0 512 512" xml:space="preserve">
          <g>
            <g>
              <path d="M333.187,237.405c32.761-23.893,54.095-62.561,54.095-106.123C387.282,58.893,328.389,0,256,0    S124.718,58.893,124.718,131.282c0,43.562,21.333,82.23,54.095,106.123C97.373,268.57,39.385,347.531,39.385,439.795    c0,39.814,32.391,72.205,72.205,72.205H400.41c39.814,0,72.205-32.391,72.205-72.205    C472.615,347.531,414.627,268.57,333.187,237.405z M164.103,131.282c0-50.672,41.225-91.897,91.897-91.897    s91.897,41.225,91.897,91.897S306.672,223.18,256,223.18S164.103,181.954,164.103,131.282z M400.41,472.615H111.59    c-18.097,0-32.82-14.723-32.82-32.821c0-97.726,79.504-177.231,177.231-177.231s177.231,79.504,177.231,177.231    C433.231,457.892,418.508,472.615,400.41,472.615z"/>
            </g>
          </g>
          </svg>
        </div>
      </div>
      <div class="pt-5">
        <span>ID: {{dataToView.id}}</span><br>
        <span>ФИО: {{dataToView.full_name}}</span><br>
        <span>Должность: {{dataToView.post}}</span><br>
        <span>Дата рождения: {{dataToView.birthday}}</span><br>
        <span>К.Т.: {{dataToView.phone}}</span><br>
        <span>E-Mail: {{dataToView.email}}</span><br>
        <span>Дата трудоустройства: {{dataToView.start_date}}</span><br>
        <span>Дата увольнения: {{dataToView.end_date}}</span><br>
        <span>Статус: {{dataToView.active}}</span><br>
      </div>
      <div class="d-flex justify-content-md-between mt-4">
        <button @click="editable = true" class="btn btn-secondary">Редактировать</button>
        <button @click="fire()" v-if="dataToView.active !== 'Уволен'" class="btn btn-danger">Уволить</button>
      </div>
    </div>
  </div>
  <div v-else>
    <span>Выберите сотрудника в таблице</span>
  </div>
</template>

<style scoped>

</style>