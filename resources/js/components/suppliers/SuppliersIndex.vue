<template>
    <div id="suppliersrec">

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
                                <form method = "post" name="addsupplier" id="addsupplier" action="#" @submit.prevent="updateSupplier">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name.." v-model="supplier.name" />
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
                            <button class="btn btn-success" v-on:click="deleteSupplier()">Ok</button>
                        </div>
                        </div>

                    </div>
                </div>
            </div><div class="card">
                <div class="card-header">Suppliers List</div><div class="card-body">
                <table class="table table-striped" v-bind:pagenumber = "pagenumber">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="supplier in laravelData.data" :key="supplier.id">
                        <th scope="row">{{ supplier.name }}</th>
                        <td><a class="text-info" href="#" v-on:click="editSupplier(supplier.id)" data-target="#exampleModal"  data-toggle="modal" v-bind:name="supplier.name">Edit</a></td>
                        <td><a class="text-danger" href="#" data-target="#exampleModal2" v-on:click="deleteId(supplier.id)"  data-toggle="modal" v-bind:id="id"  >Delete</a></td>
                    </tr>

                    </tbody>
                </table>
                <pagination :data="laravelData" :limit="2" @pagination-change-page="supplierLists">
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
                supplier: {
                    "name": ''
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
            supplierLists(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$http.get('http://localhost:8000/api/suppliers?page='+ page).then((response) => {
                    //this.suppliers = response.data.data;
                    this.laravelData = response.data;
                    this.pagenumber = page;});
            },
            editSupplier(supplierid) {
                this.$http.get('http://localhost:8000/api/suppliers/'+ supplierid).
                then((data) => {
                    this.supplier.name = data.data.data.name;
                    this.id = supplierid;
                });
            },
            updateSupplier() {
                this.$http.put('http://localhost:8000/api/suppliers/'+this.id,{
                    'name': this.supplier.name,
                }).
                then((data) => {
                    this.succmsg = false;
                    console.log(data);
                    this.supplier.name = '';
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);
                    this.actionmsg = "Data updated successfully";
                    $('#exampleModal').modal('hide');this.supplierLists(this.pagenumber);

                });
            },
            deleteId(supplierid) {
                this.id = supplierid;
            },
            deleteSupplier() {
                this.$http.delete('http://localhost:8000/api/suppliers/'+this.id).
                then((data) => {
                    this.succmsg = false;
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);

                    this.actionmsg = "Data deleted successfully";this.supplierLists(this.pagenumber);
                    $('#exampleModal2').modal('hide');

                });
            },
            hideModal() {
                $('#exampleModal2').modal('hide');
            }

        },
        mounted() {
            this.supplierLists();
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
    }</style>