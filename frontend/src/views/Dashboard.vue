<template>
	<div>
		<div class="card bg-light mb-0">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<h6 class="mb-0"><font-awesome-icon icon="list" /> My Expenses</h6>
			</div>
			<div class="card-body bg-white position-relative">
				<b-row align-v="center" class="loader" v-if="is_saving">
					<b-col>
						<b-spinner></b-spinner>
						<br><br>
						<strong>Loading</strong>
					</b-col>
				</b-row>
				<b-alert v-model="alert_modal" variant="warning" dismissible v-if="expense_categories.length==0">
					No records found.
				</b-alert>
				<b-row v-if="expense_categories.length>=1">
					<b-col>
						<table class="table border mb-0">
							<thead class="bg-light text-dark">
							<tr>
								<th scope="col">Expense Categories</th>
								<th scope="col" class="text-right">Total</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="(row, index) in expense_categories">
								<th scope="row">{{row.description}}</th>
								<td class="text-right">
									<number-format-component :input_value="Number(row.total_expenses.default)"/>
								</td>
							</tr>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="2" class="text-right">
									<strong><number-format-component :input_value="Number(total)"/></strong>
								</td>
							</tr>
							</tfoot>
						</table>
					</b-col>
					<b-col>
						<GChart
								type="PieChart"
								:data="chartData"
								:options="chartOptions"
						/>
					</b-col>
				</b-row>
			</div>
		</div>
	</div>
</template>

<script>
    import { GChart } from 'vue-google-charts'
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
export default {
	name: 'Dashboard',components: {
        GChart,
        NumberFormatComponent
    },
	data() {
		return {
            chartData: [
                ['a', 'a'],
            ],
            chartOptions: {
                width: 720,
                height: 500,
				legend:{
                    position:'labeled'
				}
            },
            is_saving:false,
            expense_categories:[],
            alert_modal:true
		}
	},
    computed: {
        total(){
            return this.expense_categories.reduce((total, value)=>{
                return total + Number(value.total_expenses.default);
            },0);
        },
    },
    created(){
        this.getData();
    },
	methods: {
        getData(){
            this.is_saving=true;
            this.axios.get('expense-categories/all').then(response => {
                this.expense_categories = response.data;

                this.is_saving=false;
                response.data.forEach((value, index) => {
                    let new_category=[value.description,value.total_expenses.default];
                    this.chartData.push(new_category);
                });
            }).catch(error => console.log(error));
        },
	}
}
</script>
