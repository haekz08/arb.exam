export default {
    data(){
        return{
            swal_confirm_submit_data:{
                title: 'Please confirm your submission.',
                text: "Your changes will be saved after this process.",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Wait, im not done yet!'
            },
            swal_confirm_delete_data:{
                title: 'Are you sure you want to delete this record?',
                text: "Note: This action will not be undone.",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No, I dont want to delete it!'
            },
            swal_transaction_completed_data:{
                title: 'Transaction Completed!',
                text: "Data Successfully Saved.",
                icon: "success",
                showConfirmButton: false,
                timer: 1000
            },
            swal_transaction_warning_data:{
                title: 'Warning!',
                text: "Complete all necessary fields!",
                icon: "warning"
            },
            swal_transaction_error_data:{
                title: 'Error!',
                text: "Please contact your Administrator.",
                icon: "error"
            }
        }
    },
    methods:{
        swalConfirmSubmit(callback){
            this.$swal(this.swal_confirm_submit_data).then((result) => {
                callback(result);
            })
        },
        swalFieldsRequired(){
            this.$swal.fire(
                'Error!',
                'Please fill out all required fields',
                "error"
            )
        },
        swalRequestError(){
            this.$swal.fire(this.swal_transaction_error_data);
        },
        swalTransactionCompleted(){
            this.$swal.fire(this.swal_transaction_completed_data);
        },
        swalConfirmDelete(callback){
            this.$swal(this.swal_confirm_delete_data).then((result) => {
                callback(result);
            })
        },
        swalTransactionWarning(){
            this.$swal.fire(this.swal_transaction_warning_data);
        }
    }
}
