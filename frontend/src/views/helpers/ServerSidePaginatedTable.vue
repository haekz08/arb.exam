<template>
    <div>
        <div class="card bg-light mb-3">
            <div class="card-header bg-dark text-white">
                <b-row>
                    <b-col>
                        <div v-if="!loading">
                            <font-awesome-icon icon="database" /><strong>&nbsp;{{list.total}}&nbsp;</strong>
                            <small>Result/s found</small>
                        </div>
                        <div v-else>
                            <strong>&nbsp;Fetching result...&nbsp;</strong>
                        </div>
                    </b-col>
                    <b-col class="text-right">
                        <b-button variant="secondary" size="sm" @click="clickTopRightBtn">
                            <font-awesome-icon icon="plus" /> Add New Record
                        </b-button>
                    </b-col>
                </b-row>
                
            </div>
            <div class="card-body bg-white">
                <b-row class="mb-3">
                    <b-col sm="2">
                        <b-form-select v-model="selected_display_no" :options="options" size="sm" @change="changeDisplayNo"></b-form-select>
                    </b-col>
                    <b-col sm="6" offset-sm="4">
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text class="bg-dark text-white"><font-awesome-icon icon="search" /></b-input-group-text>
                            </b-input-group-prepend>
                            <b-form-input
                                    type="text"
                                    class="form-control"
                                    placeholder="Search"
                                    autocomplete="off"
                                    size="sm"
                                    @keypress.native="searching"
                                    @keyup.native="search"
                                    v-model="search_term"
                            />
                            <b-input-group-append>
                                    <b-button @click="clearSearch" variant="dark" class="bg-dark text-white px-4" size="sm" :disabled="search_term==''">
                                        <font-awesome-icon icon="times" />
                                    </b-button>
                                    <!--<i class="fa fa-close"></i>-->
                            </b-input-group-append>
                        </b-input-group>
                    </b-col>
                </b-row>
                <b-table
                        selectable
                        selectedVariant="info"
                        select-mode="single"
                        :dark="dark"
                        :hover="hover"
                        :striped="striped"
                        :bordered="bordered"
                        :fixed="fixed"
                        responsive="sm"
                        :items="table_items"
                        :fields="captions"
                        :busy="loading"
                        show-empty
                        @row-dblclicked="rowDbClicked"
                        head-variant="dark"
                >
                    <div class="text-center  my-2" slot="table-busy">
                        <br>
                        <b-spinner small class="align-middle"></b-spinner>
                        <br><br>
                        <strong>Loading</strong>
                    </div>
                    <template v-slot:cell(action)="data">
                        <div class="text-center">
                            <b-button
                                    variant="danger"
                                    size="sm"
                                    @click="deleteRow(data.item.id)"
                            >
                                <font-awesome-icon icon="minus-circle" /> Delete
                            </b-button>
                        </div>
                    </template>
                </b-table>
                <nav v-if="list.total>0">
                    <b-pagination
                            :disabled="loading"
                            @input="getAll"
                            align="right"
                            :total-rows="total_rows"
                            :per-page="per_page"
                            v-model="list.current_page"
                            class="mb-0"
                    >
                    </b-pagination>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    import {bus} from '@/main.js'
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
        name: 'server-side-paginated-table',
        inheritAttrs: false,
        mixins:[SwalMixin],
        props: {
            hover: {
                type: Boolean,
                default: true
            },
            striped: {
                type: Boolean,
                default: true
            },
            bordered: {
                type: Boolean,
                default: true
            },
            small: {
                type: Boolean,
                default: true
            },
            fixed: {
                type: Boolean,
                default: true
            },
            fields: {
                type: [Array, Object],
                default: () => []
            },
            dark: {
                type: Boolean,
                default: false
            },
            refresh: {
                type: Boolean,
                default: false
            },
            api_url: {
                type: String,
                required: true
            },
            delete_url: {
                type: String,
                required: true
            },
            top_right_btn: {
                type: String,
                default: '',
                required: false
            },
            top_right_btn_redirect: {
                type: Boolean,
                default: true,
                required: false
            },
        },
        data(){
            return {
                selected: [],
                list: {
                    data: [],
                    from: 1,
                    to: 0,
                    current_page: 1,
                    total: 0,
                    per_page: 1,
                },
                result:[],
                loading: true,
                searchTimeout: () => ({
                    type: Function,
                    default: () => ({})
                }),
                search_term: '',
                options: [
                    { value: 10, text: 'Display 10 records' },
                    { value: 25, text: 'Display 25 records' },
                    { value: 50, text: 'Display 50 records' },
                    { value: 100, text: 'Display 100 records' }
                ],
                selected_display_no:10
            }
        },
        computed: {
            table_items: function () {
                return this.list.data;
            },
            per_page: function () {
                return parseInt(this.list.per_page);
            },
            total_rows: function () {
                return parseInt(this.list.total);
            },
            captions: function () {
                return this.fields
            },
            total_selected: function () {
                return parseInt(this.selected.length);
            }
        },
        watch: {
            refresh:{
                immediate: true,
                handler(){
                    if(this.refresh)
                        this.getAll();
                    bus.$emit('refreshDone');
                }
            }
        },
        mounted() {
            this.getAll();
        },
        methods: {
            getAll() {
                this.loading = true;
                this.axios.get(this.api_url + '?page=' + this.list.current_page + '&per_page=' + this.selected_display_no + '&search=' + this.search_term).then(response => {
                    // this.list = (response.data.data) ? response.data.data : response.data;
                    let result=response.data;
                    this.list=result
                    this.loading = false;
                    //console.log(result)
                }).catch(error => console.log(error));
            },
            clickTopRightBtn() {
                //this.$emit('openModal',this.selected);
                bus.$emit('serverSidePaginatedTableTopRightBtnClicked');
            },
            rowDbClicked(item) {
                bus.$emit('serverSidePaginatedTableDbClick',item);
            },
            searching() {
                this.loading = true;
                clearTimeout(this.searchTimeout);
            },
            search() {
                this.searchTimeout = setTimeout(() => {
                    this.list.current_page=1;
                    this.getAll();
                    clearTimeout(this.searchTimeout);
                }, 1000);
            },
            clearSearch(){
                this.search_term=''
                this.getAll();
            },
            changeDisplayNo(){
                this.loading = true;
                this.list.current_page=1;
                this.getAll();
            },
            deleteRow(row_id){
                this.swalConfirmDelete((data)=>{
                    if (data.value) {
                        this.loading=true;
                        this.axios.delete(this.delete_url,{ data: {id:row_id} }).then(response => {
                            this.getAll();
                            this.swal_transaction_completed_data.text="Record successfully deleted.";
                            this.swalTransactionCompleted();
                            this.loading=false;
                        }).catch(error => {
                            this.swalRequestError();
                            this.loading=false;
                        });
                    }
                });
            }
        }
    }
</script>
