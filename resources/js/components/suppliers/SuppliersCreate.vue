<template>
    <div class="container">
        <div v-bind:class="{ succmsg: succmsg }">
            <div class="col-md-12 col-lg-12">
                <div class="alert alert-success">Supplier created successfully</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 com-lg-7  offset-md-3">
                <form method = "post" name="addsupplier" id="addsupplier" action="#" enctype="multipart/form-data" @submit.prevent="addSupplier">
                    <div class="form-group">
                        <label for="name">Supplier Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Number.." v-model="supplier.name"/>
                    </div>
                    <div class="form-group">
                        <label>Select Product</label>
                        <select v-model="supplier.product_id" class="form-control" name="product_id" id="product_id">
                            <option selected disabled>Choose</option>
                            <option v-for="product in laravelData.data" v-bind:value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                        <span>{{ supplier.product_id}}</span>
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-outline-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            this.populate()
        },

        data() {
            return {
                supplier: {
                    'name': '',
                    'product_id': ''
                },
                laravelData: {},
                id:'',
                succmsg:  true,
                selected: 'Choose',
            }
        },

        methods: {
            populate(){
                this.$http.get('./api/products')
                    .then((response)=>{
                        this.laravelData = response.data;
                    })
            },
            addSupplier() {
                this.$http.post('http://localhost:8000/api/suppliers',{
                    'name': this.supplier.name,
                    'product_id': this.supplier.product_id
                }).
                then((data) => {
                    this.succmsg = false;
                    console.log(data);
                    this.supplier.name = '';
                    this.supplier.product_id = '';
                    var self = this;
                    setTimeout(function(){
                            self.succmsg = true;
                        },
                        3000);
                });
            }

        },
        computed: {}
    }
</script>
<style scoped>
    .succmsg {
        display: none;
    }
</style>