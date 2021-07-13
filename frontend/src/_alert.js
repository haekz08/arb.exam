
export default {
    data:()=>({
        // currentUser:{},
    }),
    created(){
        // this.currentUser = this.$store.getters.user
    },
    methods: {
        AjaxConfirm(apiUrl, apiParameter,successText,input=null, confirmText="Your changes will be saved after this process.", confirmTitle = "Please confirm your submission.") {
            return new Promise((resolve, reject) => {
                this.$swal({
                    title: confirmTitle,
                    text: confirmText,
                    input:input,
                    inputPlaceholder: "Write your comments here...",
                    inputAttributes: {
                        maxlength: 255,
                    },
                    customClass:{
                        input:"swal-ph"
                    },
                    icon:'question',
                    showLoaderOnConfirm: true,
                    showCancelButton: true,
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: 'Wait, im not done yet!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    preConfirm: result => {
                        if(result !== null && typeof result === "string"){
                            apiParameter = Object.assign({}, apiParameter, {comment: result});
                        }
                        return this.axios
                            .post(apiUrl, apiParameter)
                            .then(response => {
                                return response;
                            })
                            .catch(error => {
                                return error.response;
                            });
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                }).then(result => {
                    if(typeof result.value === "undefined")
                        return;
                    if (result.value.status === 200 || result.value.status === 201) {
                        resolve(result.value);
                        this.$swal({
                            title: "Success",
                            text: successText,
                            icon:'success'
                        });
                    }
                    else{
                        if(!result.value){
                            reject(result);
                        }
                        else{
                            this.$swal({
                                title: "Validation Error",
                                text: result.value.data,
                                icon:'error'
                            });
                            reject(result.value);
                        }
                    }
                })
            });
        },
        Confirm(confirmTitle = "Please Confirm?.", successText, confirmText="Click ok to proceed.") {
            return new Promise((resolve, reject) => {
                this.$swal({
                    title: confirmTitle,
                    text: confirmText,
                    cancelButtonColor: 'red',
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Ok"
                }).then(result => {
                    if(result.value){
                        resolve(result);
                    }
                })
            });

        },
        Alert(alertTitle = "Oops!", alertText="Something went wrong",type="error", timer = null) {
            this.$swal({
                title: alertTitle,
                html:alertText,
                icon: type,
                timer:timer
            });
        }
    }

}
