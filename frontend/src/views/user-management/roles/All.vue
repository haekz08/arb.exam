<template>
  <div class="animated fadeIn">
    <server-side-paginated-table
            :fields="table_settings.fields"
            :api_url="table_settings.api_url"
            :delete_url="table_settings.delete_url"
            ref="displayTable"
            :refresh="refresh"
    />

    <b-modal ref="modal" v-model="modal" centered size="lg" body-class="p-0" :hide-footer="true" :hide-header="true" @hidden="selected_id=-1">
      <modal @success="refresh=true;modal=false" :selected_id="selected_id" @close="close()"/>
    </b-modal>
  </div>
</template>
<script>
    import {bus} from '@/main.js';
    import ServerSidePaginatedTable from '@/views/helpers/ServerSidePaginatedTable.vue';
    import Modal from './Modal.vue';
    export default {
      components: {ServerSidePaginatedTable,Modal},
      data: () => {
          return {
              table_settings:{
                  api_url:'roles/all',
                  delete_url:'roles/delete',
                  fields:[
                    {key: 'name', label:'Display Name'},
                    {key: 'description', label:'Description'},
                    {key: 'formatted_created_at.other_formats.format_1', label:'Created At'}
                  ]
              },
              modal:false,
              refresh:false,
              selected_id:-1,
          }
      },
      created(){
          bus.$on('serverSidePaginatedTableDbClick', (data)=>{
              this.modal=true;
              this.selected_id = data.id;
          });
          bus.$on('serverSidePaginatedTableTopRightBtnClicked', ()=>{
              this.modal=true;
          });
          bus.$on('refreshDone', ()=>{
              this.refresh=false;
          });
      },
      methods: {
          close() {
              this.$refs['modal'].hide()
          }
      }
    }
</script>
