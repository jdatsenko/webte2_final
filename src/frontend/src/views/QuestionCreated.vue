<template>
  <div class="container">
    <h1 class="text">{{ $t('Created.title') }} {{ questionCode }}</h1>
  </div>
  
</template>

<script>
    import Button from 'primevue/button';
    import { router } from "../router";
export default {
  data() {
    return {
      questionCode: null
    };
  },
  mounted() {
    this.questionCode = this.$route.query.code;
  }
};
</script>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40vh; 
}

.text {
  color: rgb(164, 63, 63);
  font-size: 40px; 
  text-align: center;
}
</style>


  