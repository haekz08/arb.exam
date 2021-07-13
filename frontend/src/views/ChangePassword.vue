<template>
	<div>

		<b-row>
			<b-col cols="5">
				<div class="card bg-light mb-0">
					<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
						<h6 class="mb-0"><font-awesome-icon icon="lock" /> Change your password</h6>
					</div>
					<div class="card-body bg-white position-relative">
						<b-row align-v="center" class="loader" v-if="is_saving">
							<b-col>
								<b-spinner></b-spinner>
								<br><br>
								<strong>Loading</strong>
							</b-col>
						</b-row>
						<b-form @submit="save">
							<b-form-group
									label="Old Password:"
									description="This field is required"
							>
								<b-form-input
										v-model="form.old_password"
										type="password"
										required
								></b-form-input>
							</b-form-group>

							<b-form-group
									label="New Password:"
									description="This field is required"
							>
								<b-form-input
										v-model="form.new_password"
										type="password"
										required
								></b-form-input>
							</b-form-group>

							<div class="text-right">
								<b-button type="submit" variant="dark" size="sm"><font-awesome-icon icon="save" /> Change Password</b-button>
							</div>
						</b-form>
					</div>
				</div>
			</b-col>
		</b-row>
	</div>
</template>

<script>

    import SwalMixin from '@/views/mixins/Swal.js'
export default {
	name: 'Dashboard',
    mixins:[SwalMixin],
	data() {
		return {
            form:{
                old_password:'',
				new_password:''
			},
            is_saving:false
		}
	},
    created(){
    },
	methods: {

        save(){
            event.preventDefault()
            this.swalConfirmSubmit((data)=>{
                if (data.value) {
                    this.is_saving=true;
                    this.axios.post('users/change-password',this.form).then(response => {
                        this.is_saving=false;
                        this.swalTransactionCompleted();
                        this.form.old_password='';
                        this.form.new_password='';
                    }).catch(error => {
                        this.swal_transaction_error_data.text = error.response.data;
                        this.swalRequestError();
                        this.is_saving=false;
                    });
                }
            });
        },
	}
}
</script>
