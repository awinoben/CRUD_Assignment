<template>
    <div class="container">
        <div v-bind:class="{ succmsg: succmsg }">
            <div class="col-md-12 col-lg-12">
                <div class="alert alert-success">Product created successfully</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 com-lg-7  offset-md-3">
                <form method = "post" name="addproduct" id="addproduct" action="#" enctype="multipart/form-data" @submit.prevent="addProduct">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name.." v-model="product.name"/>
                        {{ product.name }}
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Product Description.." v-model="product.description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity.." v-model="product.quantity"/>
                    </div>
                    <div class="form-group text-right">
                    <button class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                product: {
                    'name': '',
                    'description': '',
                    'quantity': ''
                },
                succmsg:  true,
            }
        },
        methods: {
            addProduct() {
                this.$http.post('./api/products',{
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