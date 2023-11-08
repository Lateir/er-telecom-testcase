<script>
export default {
  name: "NewEmployeeModal",
  data() {
    return {
      posts: [
        {
          id: 1,
          name: 'Default',
        },
        {
          id: 2,
          name: 'Supervisor'
        }
      ],
      name: '',
      secondName: '',
      thirdName: '',
      post: 1,
      startDate: new Date().toISOString().slice(0,10),
      file: null,

      nameError: false,
      secondNameError: false,
    }
  },
  methods: {
    async addEmployeeHandler() {
      const data = {
        name: this.name,
        secondName: this.secondName,
        thirdName: this.thirdName,
        post: this.post,
        startDate: this.startDate,
        photo: this.file
      }
      console.log(data)
    }
  },
  watch: {
    async name() {
      this.nameError = this.name === ''
    },
    async secondName() {
      this.secondNameError = this.secondName === ''
    }
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
              <label for="name" class="col-form-label">Имя</label>
              <input :class="{'is-invalid':nameError}" v-model="name" required type="text" class="form-control" id="name" placeholder="Необходимо">
            </div>
            <div class="form-group">
              <label for="name" class="col-form-label">Фамилия</label>
              <input :class="{'is-invalid':secondNameError}" v-model="secondName" required type="text" class="form-control" id="2nd-name" placeholder="Необходимо">
            </div>
            <div class="form-group">
              <label for="3rd-name" class="col-form-label">Отчество (при наличии)</label>
              <input v-model="thirdName" type="text" class="form-control" id="3rd-name">
            </div>
            <div class="form-group">
              <label for="post" class="col-form-label">Должность</label>
              <select v-model="post" class="form-control" name="post" id="post">
                <option v-for="post in posts" :value="post.id">{{post.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="startDate" class="col-form-label">Дата трудоустройства</label>
              <input v-model="startDate" type="date" class="form-control" id="startDate">
            </div>
            <div class="form-group">
              <label for="image" class="col-form-label">Фотография</label>
              <input ref="file" @change="file = this.$refs.file.files[0]" required type="file" class="form-control" id="image">
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