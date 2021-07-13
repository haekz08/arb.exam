<template>
  <div>
    <b-row align-v="center" class="loader" v-if="status">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
  </div>
</template>
<script>
    export default {
      props:{
            status: {
                type: Boolean,
                default: false,
                required: false
            },
      },
      watch: {
        status:{
            immediate: true,
            deep:true,
            handler(){
            }
        }
      },
      data() {
        return {
          
        }
      },
      created(){
      },
      methods: {
        
      }
    }
</script>
