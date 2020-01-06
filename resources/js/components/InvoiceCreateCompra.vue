<template>
    <div>
    <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col text-right">Precio</th>
                    <th scope="col text-right">Cantidad</th>
                    <th scope="col text-right">Total</th>
                </tr>
            </thead>
            <tr v-for="(invoice_product, k) in invoice_products" :key="k">
                <td scope="row" class="trashIconContainer">
                    <i class="far fa-trash-alt" @click="deleteRow(k, invoice_product)">Eliminar</i>
                </td>
                <td>
                    <input class="form-control" type="text" v-model="invoice_product.product_no" />
                </td>
                <td>
                    <input class="form-control" type="text" v-model="invoice_product.product_name" />
                </td>
                <td>
                    <input class="form-control text-right" type="number" min="0" step=".01" v-model="invoice_product.product_price" @change="calculateLineTotal(invoice_product)"
                    />
                </td>
                <td>
                    <input class="form-control text-right" type="number" min="0" step=".01" v-model="invoice_product.product_qty" @change="calculateLineTotal(invoice_product)"
                    />
                </td>
                <td>
                    <input readonly class="form-control text-right" type="number" min="0" step=".01" v-model="invoice_product.line_total" />
                </td>
            </tr>

            <!-- <tfoot>
                <tr>
                    <td colspan="5" class="text-right">Sub Total</td>
                    <td class="text-right">{{invoice_subtotal}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">igv</td>
                    <td class="text-right">{{invoice_tax}}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td class="text-right">{{invoice_total}}</td>
                </tr>
            </tfoot> -->

    </table>

    <!-- <div class="clearfix"></div> -->

            <button type='button' class="btn btn-info" @click="addNewRow">
                <i class="fas fa-plus-circle"></i>
                Add
            </button>

</div>
</template>

<script>
    export default {

        data() {
            return{
                invoice_subtotal: 0,
                invoice_total: 0,
                invoice_tax: 18,
                invoice_products:
                    [{
                        product_no: '',
                        product_name: '',
                        product_price: '',
                        product_qty: '',
                        line_total: 0
                    }]
        }
        },
        methods:{
                calculateTotal() {
                    var subtotal, total;
                    subtotal = this.invoice_products.reduce(function (sum, product) {
                        var lineTotal = parseFloat(product.line_total);
                        if (!isNaN(lineTotal)) {
                            return sum + lineTotal;
                        }
                    }, 0);

                    this.invoice_subtotal = subtotal.toFixed(2);

                    total = (subtotal * (this.invoice_tax / 100)) + subtotal;
                    total = parseFloat(total);
                    if (!isNaN(total)) {
                        this.invoice_total = total.toFixed(2);
                    } else {
                        this.invoice_total = '0.00'
                    }
                },


                addNewRow() {

                    this.invoice_products.push({
                        product_no: '',
                        product_name: '',
                        product_price: '',
                        product_qty: '',
                        line_total: 0
                    });
                },



                deleteRow(index, invoice_product) {
                    var idx = this.invoice_products.indexOf(invoice_product);
                    console.log(idx, index);
                    if (idx > -1) {
                        this.invoice_products.splice(idx, 1);
                    }
                    this.calculateTotal();
                },
                calculateLineTotal(invoice_product) {
                    var total = parseFloat(invoice_product.product_price) * parseFloat(invoice_product.product_qty);
                    if (!isNaN(total)) {
                        invoice_product.line_total = total.toFixed(2);
                    }
                    this.calculateTotal();
                },
            }

    }
</script>