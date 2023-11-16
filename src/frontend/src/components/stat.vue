<script>
import axios from "axios";

export default {
  name: "stat",
  props: ['posts'],
  data() {
    return {
      selectedDate: new Date().toISOString().slice(0,10),
      loadedData: {}
    }
  },
  methods: {
    async loadStat(){
      const result = await axios.get('/api/get-stats',
          {
            params: {
              date: this.selectedDate,
            }
          })
      if (result.status === 200) {
        this.loadedData = result.data
      }
    }
  },
  watch: {
    async selectedDate(){
      await this.loadStat()
    }
  },
  async mounted() {
    await this.loadStat()
  }
}
</script>

<template>
  <div class="form-group">
    <div class="form-group">
      <input v-model="selectedDate" type="date" class="form-control" id="startDate">
      <div v-for="post in loadedData">
        <span>{{posts[post.post]}}: {{post.count}}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>