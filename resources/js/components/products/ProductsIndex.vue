<template>
    <div id="productsrec">

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
                                <form method = "post" name="addproduct" id="addproduct" action="#" @submit.prevent="updateProduct">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name.." v-model="product.name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Description" v-model="product.description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" v-model="product.quantity"/>
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
                            <button class="btn btn-success" v-on:click="deleteProduct()">Ok</button>
                        </div>
                        </div>

                    </div>
                </div>
            </div><div class="card">
                <div class="card-header">Products List</div><div class="card-body">
                <table class="table table-striped" v-bind:pagenumber = "pagenumber">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Description</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in laravelData.data" :key="product.id">
                        <th scope="row">{{ product.name }}</th>
                        <td>{{ product.quantity }}</td>
                        <td>{{ product.description.slice(0,50) + "....." }}</td>
                        <td><a class="text-info" href="#" v-on:click="editProduct(product.id)" data-target="#exampleModal"  data-toggle="modal" v-bind:name="product.name">Edit</a></td>
                        <td><a class="text-danger" href="#" data-target="#exampleModal2" v-on:click="deleteId(product.id)"  data-toggle="modal" v-bind:id="id"  >Delete</a></td>
                    </tr>

                    </tbody>
                </table>
                <pagination :data="laravelData" :limit="2" @pagination-change-page="productLists">
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
                product: {
                    "name": '',
                    "description": '',
                    "quantity": ''
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
            productLists(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$http.get('http://localhost:8000/api/products?page='+ page).then((response) => {
                    //this.products = response.data.data;
                    this.laravelData = response.data;
                    this.pagenumber = page;});
            },
            editProduct(productid) {
                this.$http.get('http://localhost:8000/api/products/'+ productid).
                then((data) => {
                    this.product.name = data.data.data.name;
                    this.product.description = data.data.data.description;
                    this.product.quantity = data.data.data.quantity;
                    this.id = productid;
                });
            },
            updateProduct() {
                this.$http.put('http://localhost:8000/api/products/'+this.id,{
                    'name': this.product.name,
                    'description': this.product.description,
                    'quantity': this.product.quantity
                }).
                then((data) => {
                    this.succmsg = false;
                    console.log(data);
                    this.product.name = '';
                    this.product.description = '';
                    this.product.quantity = '';
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);
                    this.actionmsg = "Data updated successfully";
                    $('#exampleModal').modal('hide');this.productLists(this.pagenumber);

                });
            },
            deleteId(productid) {
                this.id = productid;
            },
            deleteProduct() {
                this.$http.delete('http://localhost:8000/api/products/'+this.id).
                then((data) => {
                    this.succmsg = false;
                    var self = this;
                    setTimeout(function(){
                        self.succmsg = true;
                    },3000);

                    this.actionmsg = "Data deleted successfully";this.productLists(this.pagenumber);
                    $('#exampleModal2').modal('hide');

                });
            },
            hideModal() {
                $('#exampleModal2').modal('hide');
            }

        },
        mounted() {
            this.productLists();
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