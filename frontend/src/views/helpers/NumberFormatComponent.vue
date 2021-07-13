<template>
  <div class="d-inline text-nowrap">
    <template v-if="currency">₱ </template>{{input_value.toLocaleString('en-US',{ minimumFractionDigits: decimal })}}
  </div>
</template>
<script>
    export default {
      props:{
            input_value: {
                type: [Number,String],
                default: 0,
                required: true
            },
            decimal: {
                type: Number,
                default: 2,
                required: false
            },
            currency: {
                type: Boolean,
                default: true,
                required: false
            },
      },
      data() {
        return {
          
        }
      },
      created(){
        //this.getProducts();
      },
      methods: {
        
      }
    }
</script>
