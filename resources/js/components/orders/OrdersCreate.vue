<template>
    <div class="container">
        <div v-bind:class="{ succmsg: succmsg }">
            <div class="col-md-12 col-lg-12">
                <div class="alert alert-success">Order made successfully</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 com-lg-7  offset-md-3">
                <form method = "post" name="addorder" id="addorder" action="#" enctype="multipart/form-data" @submit.prevent="addOrder">
                    <div class="form-group">
                        <label for="order_number">Order Number</label>
                        <input type="text" name="order_number" id="order_number" class="form-control" placeholder="Number.." v-model="order.order_number"/>
                    </div>
                    <div class="form-group">
                        <label>Select Product</label>
                        <select v-model="order.product_id" class="form-control" name="product_id" id="id">
                            <option disabled>Choose</option>
                            <option v-for="product in laravelData.data" v-bind:value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                        <span>{{ order.product_id}}</span>
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
                order: {
                    'order_number': '',
                    'product_id': ''
                },
                laravelData: [],
                id:'',
                succmsg:  true
            }
        },

        methods: {
            populate(){
                axios.get('./api/products')
                    .then((response)=>{
                        this.laravelData = response.data;
                    })
            },
            addOrder() {
                this.$http.post('http://localhost:8000/api/orders',{
                    'order_number': this.order.order_number,
                    'product_id': this.order.product_id
                }).
                then((data) => {
                    this.succmsg = false;
                    console.log(data);
                    this.order.order_number = '';
                    this.order.product_id = '';
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