<template>
    <div>
        <main-content colunmClass="col-12 col-md-11 col-lg-9">
            <template v-slot:card-header-title>
                Administrar Cliente
            </template>
            <template v-slot:card-header-actions>
                <button class="btn btn-sm btn-green waves-effect waves-light" @click="descargarExcel()">
                    <i class="fas fa-file-excel"></i>
                    <span class="d-none d-sm-inline-block">
                        Descargar
                    </span>
                </button>
                <i class="fas fa-grip-lines-vertical text-white px-3"></i>
                <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarCliente()">
                    <i class="fas fa-search"></i>
                    <span class="d-none d-sm-inline-block">
                        Buscar
                    </span>
                </button>
                <button class="btn btn-sm btn-danger waves-effect waves-light" @click="limpiarFiltros()">
                    <i class="fas fa-times"></i>
                    <span class="d-none d-sm-inline-block">
                        Limpiar
                    </span>
                </button>
            </template>

            <template v-slot:card-body-main>
                <div class="form-row mb-2">
                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Nombres</label>
                        <input type="text" class="form-control" v-model="cliente.nombres"
                            @keyup.enter="buscarCliente" />
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Apellidos</label>
                        <input type="text" class="form-control" v-model="cliente.apellidos"
                            @keyup.enter="buscarCliente" />
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Dni</label>
                        <input type="text" class="form-control" v-model="cliente.dni" @keyup.enter="buscarCliente" />
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3 ">
                        <label>Fecha</label>
                        <v-date-picker v-model="cliente.fecharegistro" range lang="es" format="DD-MM-YYYY" confirm
                            :editable="false" placeholder="Seleccione un rango de fecha" @input="buscarCliente()">
                            <template v-slot:footer="{ emit }">
                                <button class="mx-btn" @click="selectToday(emit)">
                                    Today
                                </button>
                            </template>
                        </v-date-picker>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Campaña</label>
                        <select2 :options="campania" @input="buscarCliente()" v-model="cliente.idcampania"
                            :selectValue="cliente.idcampania" placeholder="Seleccione una campaña"
                            keyProperty="idcampania" textProperty="nombrecampania">
                        </select2>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label class="mb-1">Distrito</label>
                        <select2 :options="distrito" @input="buscarCliente()" v-model="cliente.coddistrito"
                            :selectValue="cliente.coddistrito" placeholder="Seleccione una Distrito"
                            keyProperty="coddistrito" textProperty="distrito">
                        </select2>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="asistencia"
                                v-model="cliente.asistencia" @change="buscarCliente()">
                            <label class="custom-control-label" for="asistencia">Asistente</label>
                        </div>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="estado" v-model="cliente.estado"
                                @change="buscarCliente()">
                            <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="p-2">Accion</th>
                                <th class="p-2">id</th>
                                <th class="p-2">Nombres</th>
                                <th class="p-2">Apellidos</th>
                                <th class="p-2">Email</th>
                                <th class="p-2">Dni</th>
                                <th class="p-2">Telefono</th>
                                <th class="p-2">Asistencia</th>
                                <th class="p-2 text-nowrap">F. Registro</th>
                                <th class="p-2">Campaña</th>
                                <th class="p-2">Empresa</th>
                                <th class="p-2">Distrito</th>
                                <th class="p-2">utm</th>
                                <th class="p-2">Carrera</th>
                                <th class="p-2">Grado</th>
                                <th class="p-2">Origen</th>
                                <th class="p-2">colegio</th>
                                <th class="p-2">anioegreso</th>
                                <th class="p-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cli in clientes" :key="cli.idcliente">
                                <td>
                                    <row-actions :rowData="cli" @rowItemActions="rowItemActions" :activeEdit="true"
                                        :activeDelete="false" :activeShow="true">

                                        <button type="button" :title="cli.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(cli)"
                                             class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                             :class="cli.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                            <i class="fas fa-lg" :class="cli.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                        </button>

                                        <button type="button" title="Borrar" @click="physicallyRemove(cli)"
                                            class="btn btn-sm btn-outline-primary waves-effect waves-light border-0 mr-1">
                                            <i class="fas fa-eraser fa-lg"></i>
                                        </button>
                                    </row-actions>
                                </td>
                                <td v-text="cli.idcliente"></td>
                                <td v-text="cli.nombres" class="ui-max-w-300 text-truncate"></td>
                                <td v-text="cli.apellidos" class="ui-max-w-300 text-truncate"></td>
                                <td v-text="cli.email"></td>
                                <td v-text="cli.dni"></td>
                                <td v-text="cli.telefono"></td>
                                <td>
                                    <span class="badge badge-pill py-1 px-3"
                                        :class="cli.isassistance ? 'badge-info':'badge-secondary'"
                                        v-text="cli.asistencianame">
                                    </span>
                                </td>
                                <td v-text="cli.fecha" class="ui-max-w-100 text-truncate"></td>
                                <td v-text="cli.campania.nombrecampania" class="ui-max-w-200 text-truncate"></td>
                                <td v-text="cli.campania.cuenta.empresa" class="ui-max-w-300 text-truncate"></td>
                                <td v-text="cli.distrito.nombreubigeo" class="ui-max-w-100 text-truncate"></td>
                                <td v-text="cli.utm"></td>
                                <td v-text="cli.carrera" class="ui-max-w-200 text-truncate"></td>
                                <td v-text="cli.grado" class="ui-max-w-200 text-truncate"></td>
                                <td v-text="cli.origen" class="ui-max-w-200 text-truncate"></td>
                                <td v-text="cli.colegio"></td>
                                <td v-text="cli.anioegreso"></td>
                                <td>
                                    <span class="badge badge-pill py-1 px-3"
                                        :class="cli.isactive ? 'badge-success':'badge-danger'" v-text="cli.statename">
                                    </span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination-links :pagination="pagination" @changePerPage="changePerPage">
                </pagination-links>
            </template>
        </main-content>
        <modal-atencion ref="modalAtencion"></modal-atencion>
    </div>
</template>


<script>
    import MainContent from './../../utils/MainContent';
    import PaginationLinks from './../../utils/PaginationLinks';
    import Select2 from './../../utils/Select2';
    import RowActions from './../../utils/RowActions';
    import VDatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/locale/es';
    import moment, {
        now,
        relativeTimeThreshold
    } from 'moment';
    import qs from 'qs';
    import ModalAtencion from '../atencion/_ModalAtencion';

    export default {
        data() {
            return {

                cliente: {
                    nombres: '',
                    apellidos: '',
                    dni: '',
                    fecharegistro: '',
                    estado: false,
                    coddistrito: 0,
                    idcampania: 0,
                },
                clientes: [],
                filters: {},
                pagination: {},
                campania: [],
                distrito: []
            }

        },
        methods: {
            listarCliente() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/cliente`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.clientes = response.data.data;
                        vm.pagination = response.data;
                        delete vm.pagination.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        console.log(error);
                    });
            },
            changePerPage(event) {
                this.filters.page = event.page;
                this.filters.perpage = event.perpage;

                this.listarCliente();
            },
            buscarCliente() {
                this.addFiltersRole();
                this.listarCliente();
            },
            listarCampania() {
                let vm = this;
                axios.get(`${appApiUrl}/campania/select`)
                    .then(function (response) {
                        vm.campania = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            listarUbigeo() {
                let vm = this;
                axios.get(`${appApiUrl}/ubigeo/distritosleccionados`)
                    .then(function (response) {
                        vm.distrito = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            limpiarFiltros() {

                this.cliente.nombres = '';
                this.cliente.apellidos = '';
                this.cliente.dni = '',
                    this.cliente.idcampania = 0,
                    this.cliente.coddistrito = 0

            },
            formatDate(value, fmt = 'D MMM YYYY') {
                return (value == null) ?
                    '' :
                    moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
            selectToday(emit) {
                emit([new Date(), new Date()]);
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'show':
                        this.$nextTick(() => {
                            this.$refs.modalAtencion.showDetail(event.data);
                        });
                        break;
                    case 'edit':
                       this.$router.push({ name: 'spa.administrarcliente.editar', params: { id: event.data.idcliente } }) 
                    break;
                    // case 'delete':
                    //     this.cambiarEstado(event.data);
                    //     break;
                }

            },
            cambiarEstado(param) {
                let vm = this;
                 let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';

                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} El Cliente <b>${param.nombres}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/cliente/${param.idcliente}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCliente();
                                    }  else if (result.warning)
                                        warningMessage(result.message, appName);
                                    else
                                        errorMessage(result.message, appName);
                                })
                                .catch(function (error) {
                                    hidePreloader();
                                    errorMessage(appErrorMessage, appName);
                                    console.log(error);
                                });
                        }


                    });
            },
            physicallyRemove(param) {
                let vm = this;
                swalAlertConfirm(`¿Seguro que quiere eliminar Cliente <b>${param.nombres}</b>?. Ya no tendra opcion a recuperar el registro.`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();

                            let removeParam = {
                                id: param.idcliente
                            };

                            axios.post(`${appApiUrl}/cliente/physicallyremove`, removeParam)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCliente();
                                    } else if (result.warning)
                                        warningMessage(result.message, appName);
                                    else
                                        errorMessage(result.message, appName);
                                })
                                .catch(function (error) {
                                    hidePreloader();
                                    errorMessage(appErrorMessage, appName);
                                    console.log(error);
                                });
                        }


                    });
            },
            addFiltersRole() {
                this.filters = {};
                this.filters.page = 1;

                if (this.cliente.nombres.length)
                    this.filters.nombres = this.cliente.nombres;

                if (this.cliente.apellidos.length)
                    this.filters.apellidos = this.cliente.apellidos;

                if (this.cliente.dni.length)
                    this.filters.dni = this.cliente.dni;

                if (this.cliente.idcampania.length)
                    this.filters.idcampania = this.cliente.idcampania;

                if (this.cliente.coddistrito.length)
                    this.filters.coddistrito = `%${this.cliente.coddistrito}`;

                if (this.cliente.estado)
                    this.filters.estado = this.cliente.estado;

                if (this.cliente.asistencia)
                    this.filters.asistencia = 1;

                if (this.cliente.fecharegistro.length == 2) {
                    if (this.cliente.fecharegistro[0] != null)
                        this.filters.fechadesde = this.formatDate(this.cliente.fecharegistro[0], 'DD-MM-YYYY');

                    if (this.cliente.fecharegistro[1] != null)
                        this.filters.fechahasta = this.formatDate(this.cliente.fecharegistro[1], 'DD-MM-YYYY');
                }
            },
            descargarExcel() {
                this.addFiltersRole();

                let urlexcel = `${appApiUrl}/cliente/exportarexcel?${qs.stringify(this.filters)}`;
                window.location = urlexcel;
            }

        },
        mounted() {
            this.listarCliente();
            this.listarCampania();
            this.listarUbigeo();
        },
        components: {
            MainContent,
            PaginationLinks,
            Select2,
            RowActions,
            VDatePicker,
            ModalAtencion

        },
    }

</script>
