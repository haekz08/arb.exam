<template>
  <div>
      <div class="card bg-light mb-0">
          <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
              <h6 class="mb-0"><font-awesome-icon icon="plus-circle" /> Add New Expense</h6>
          </div>
          <div class="card-body bg-white position-relative">
              <b-row align-v="center" class="loader" v-if="is_saving">
                  <b-col>
                      <b-spinner></b-spinner>
                      <br><br>
                      <strong>Loading</strong>
                  </b-col>
              </b-row>
              <b-alert show variant="danger" v-if="!allowAction">You have no <b>PERMISSION</b> to make changes in this module.</b-alert>
              <b-alert show variant="warning" v-if="!isCategoryReady">No expense category yet.</b-alert>

              <b-form @submit="save">
                  <b-form-group
                          label="Expense Category:"
                          description="This field is required"
                  >
                      <select class="form-control" v-model="form.expense_category_id" required :readonly="!allowAction || !isCategoryReady">
                          <option value="">Please Select</option>
                          <option v-for="expense_category in expense_categories" :value="expense_category.id">
                              {{expense_category.name}}
                          </option>
                      </select>
                  </b-form-group>
                  <b-form-group
                          label="Amount:"
                          description="This field is required"
                  >
                      <b-form-input
                              v-model="form.amount"
                              type="number"
                              step="any"
                              required
                              :readonly="!allowAction || !isCategoryReady"
                      ></b-form-input>
                  </b-form-group>

                  <b-form-group
                          label="Entry Date:"
                          description="This field is required"
                  >
                      <b-form-input
                              v-model="form.entry_date"
                              type="date"
                              required
                              :readonly="!allowAction || !isCategoryReady"
                      ></b-form-input>
                  </b-form-group>

                  <div class="text-right">
                      <b-button variant="danger" size="sm" class="float-left" @click="deleteData" v-if="form.id!=-1 && allowAction">
                          <font-awesome-icon icon="minus-circle" /> Delete
                      </b-button>
                      <b-button variant="dark" size="sm" class="mr-1" @click="close">
                          <font-awesome-icon icon="times-circle" /> Cancel
                      </b-button>
                      <b-button type="submit" variant="dark" size="sm" v-if="allowAction && isCategoryReady"><font-awesome-icon icon="save" /> Save</b-button>
                  </div>
              </b-form>
          </div>
      </div>
  </div>
</template>
<script>
    import {permissions} from '@/constants';
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
        props: {
            selected_id: {
                type: Number,
                default: -1,
                required: false
            }
        },
      data() {
        return {
            form:{
                id:-1,
                expense_category_id: '',
                amount: '',
                entry_date: '',
            },
            form_copy:{
                id:-1,
                expense_category_id: '',
                amount: '',
                entry_date: '',
            },
            expense_categories:[],
          is_saving:false
        }
      },
      created(){
        this.form_copy=JSON.parse(JSON.stringify(this.form));
        if(this.selected_id != -1)
        this.get();

          this.getFields();
      },

        computed: {
            allowAction() {
                return (this.$store.getters.userDetails.role.permissions.find(x => x.id === permissions.expense_crud)) ? true : false;
            },
            isCategoryReady() {
                return (this.expense_categories.length>=1) ? true : false;
            }
        },
    watch: {
        selected_id:{
            immediate: true,
            handler(){
                if(this.selected_id != -1)
                    this.get();
            }
        }
    },
      methods: {

          getFields(){
              this.is_saving=true;
              this.axios.get('expense-categories/all').then(response => {
                  this.expense_categories = response.data;
                  this.is_saving=false;
              }).catch(error => console.log(error));
          },
        get(){
          this.is_saving=true;
          this.axios.get('expenses/get',{params:{id:this.selected_id}}).then(response => {
              this.form=response.data;
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        save(){
          event.preventDefault()
          this.swalConfirmSubmit((data)=>{
              if (data.value) {
                this.is_saving=true;
                this.axios.post('expenses/save',this.form).then(response => {
                    this.swalTransactionCompleted();
                    this.is_saving=false;
                    if(this.form.id==-1){
                      this.form=JSON.parse(JSON.stringify(this.form_copy));
                    }
                    this.$emit('success');
                }).catch(error => {
                    this.swal_transaction_error_data.text = error.response.data;
                    this.swalRequestError();
                    this.is_saving=false;
                });
              }
          });
        },
          close() {
              this.$emit('close');
          },

          deleteData(){
              this.swalConfirmDelete((data)=>{
                  if (data.value) {
                      this.loading=true;
                      this.axios.delete('expenses/delete',{ data: {id:this.selected_id} }).then(response => {
                          this.swal_transaction_completed_data.text="Record successfully deleted.";
                          this.swalTransactionCompleted();
                          this.is_saving=false;
                          this.$emit('success');
                      }).catch(error => {
                          this.swal_transaction_error_data.text = error.response.data;
                          this.swalRequestError();
                          this.is_saving=false;
                      });
                  }
              });
          }
      }
    }
</script>
