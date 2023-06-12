<template>
    <form-cliente cardTitle="Editar Administrar Cliente" :cliente="cliente" @saveData="saveData">
    </form-cliente>
</template>


<script>
    import FormCliente from './_FormCliente';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                cliente: {}
            }
        },
        created() {
            this.cliente.idcliente = this.$route.params.id;

            if (isNaN(this.cliente.idcliente)) {
                this.$router.push({
                    name: 'spa.administrarcliente'
                });
            }

            this.obtenerCliente(this.cliente.idcliente);
        },
        methods: {
            obtenerCliente(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/cliente/${id}/edit`)
                    .then(function (response) {
                        hidePreloader();
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningúna cliente con el código ${id}`, appName);

                            vm.$router.push({
                                name: 'spa.administrarcliente'
                            });
                        }
                        vm.cliente = response.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);

                        vm.$router.push({
                            name: 'spa.administrarcliente'
                        });
                        console.log(error);
                    })
                     },
           saveData(event) {
                showPreloader();
               
                let vm = this;
                axios.put(`${appApiUrl}/cliente/${this.cliente.idcliente}`, event)
                    .then(function (response) {
                        hidePreloader();
         
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.administrarcliente'
                            });
                        } else
                            errorMessage(result.message, appName);
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        console.log(error);
                    })
            },

        },
        mounted() {

        },
        components: {
            FormCliente
        }
    }

</script>
