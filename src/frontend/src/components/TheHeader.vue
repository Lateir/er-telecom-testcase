<script>
export default {
  name: "TheHeader",
  data() {
    return {
      searchValue: ""
    }
  },
  watch: {
    searchValue() {
      this.$emit('search', this.searchValue)
    }
  }
}
</script>

<template>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">База сотрудников</a>
    <input v-model="searchValue" class="form-control form-control-dark w-100" type="text" placeholder="Поиск..." aria-label="Search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a @click.prevent="this.$emit('addNew')" class="nav-link" href="#">Добавить сотрудника</a>
      </li>
    </ul>
  </nav>
</template>

<style scoped>

</style>