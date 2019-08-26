<template>
    <div id="ordersrec">

        <div class="row justify-content-center">
            <div v-bind:class="{ succmsg: succmsg }">
                <div class="col-md-12 col-lg-12">
                    <div class="alert alert-success cusmsg">{{ actionmsg }}</div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Button trigger modal -->

                <!-- Modal -->

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-bind:class="{ showmodal:showmodal }">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method = "post" name="addorder" id="addorder" action="#" @submit.prevent="updateOrder">
                                    <div class="form-group">
                                        <label for="order_number">Name</label>
                                        <input type="text" name="order_number" id="order_number" class="form-control" placeholder="Order Number.." v-model="order.order_number" />
                                    </div>
                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Submit</button>
                                    </div></form>
                            </div>

                        </div>
                    </div>
                </div><div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Are you sure you want to delete this record?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group text-center">
                                <button class="btn btn-danger" v-on:click="hideModal()">Cancel</button>
                            </div><div class="form-group text-center">
                            <button class="btn btn-success" v-on:click="deleteOrder()">Ok</button>
                        </div>
                        </div>

                    </div>
                </div>
            </div><div class="card">
                <div class="card-header">Orders List</div><div class="card-body">
                <table class="table table-striped" v-bind:pagenumber = "pagenumber">
                    <thead>
                    <tr>
                        <th scope="col">Order Number</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in laravelData.data" :key="order.id">
                        <th scope="row">{{ order.order_number }}</th>
                        <td><a class="text-info" href="#" v-on:click="editOrder(order.id)" data-target="#exampleModal"  data-toggle="modal" v-bind:name="order.order_number">Edit</a></td>
                        <td><a class="text-danger" href="#" data-target="#exampleModal2" v-on:click="deleteId(order.id)"  data-toggle="modal" v-bind:id="id"  >Delete</a></td>
                    </tr>

                    </tbody>
                </table>
                <pagination :data="laravelData" :limit="2" @pagination-change-page="orderLists">
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
            </div>
            </div>
        </div>
    </div>
</template><script>

    export default {

        data() {
            return {
                order: {
                    "order_number": ''
                },
                laravelData: {},
                id: '',
                succmsg:  true,
                showmodal: false,
                pagenumber: 1,
                actionmsg: '',
            }
        },
        methods: {
            orderLists(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$http.get('http://localhost:8000/api/orders?page='+ page).then((response) => {
                    //this.orders = response.data.data;
                    this.laravelData = response.data;
                    this.pagenumber = page;});
            },
            editOrder(orderid) {
                this.$http.get('http://localhost:8000/api/orders/'+ orderid).
                then((data) => {
                    this.order.order_number = data.data.data.order_number;
                    this.id = orderid;
                });
            },
            updateOrder() {
                this.$http.put('http://localhost:8000/api/orders/'+this.id,{
                    'order_number': this.order.order_number,
                }).
                then((data) => {
                    this.succmsg = false;
                    console.log(data);
                    this.order.order_number = '';
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);
                    this.actionmsg = "Data updated successfully";
                    $('#exampleModal').modal('hide');this.orderLists(this.pagenumber);

                });
            },
            deleteId(orderid) {
                this.id = orderid;
            },
            deleteOrder() {
                this.$http.delete('http://localhost:8000/api/orders/'+this.id).
                then((data) => {
                    this.succmsg = false;
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);

                    this.actionmsg = "Data deleted successfully";this.orderLists(this.pagenumber);
                    $('#exampleModal2').modal('hide');

                });
            },
            hideModal() {
                $('#exampleModal2').modal('hide');
            }

        },
        mounted() {
            this.orderLists();
        }
    }
</script>
<style scoped>
    .succmsg {
        display: none;
    }
    .showmodal {
        display: none !important;
        opacity: 0;
    }
</style>