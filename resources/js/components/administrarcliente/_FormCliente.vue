<template>
    <main-content columnClass="col-12 col-xl-10">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('nombres')}">
                    <label>Nombre <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.nombres" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombres')" v-text="showError('nombres').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('apellidos')}">
                    <label>Apellidos <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.apellidos" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('apellidos')" v-text="showError('apellidos').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('dni')}">
                    <label>Dni <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.dni" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('dni')" v-text="showError('dni').errorDetail"></small>
                </div>
                 <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('telefono')}">
                    <label>Telefono <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.telefono" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('telefono')" v-text="showError('telefono').errorDetail"></small>
                </div>
                 <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('carrera')}">
                    <label>carrera<small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.carrera" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('carrera')" v-text="showError('carrera').errorDetail"></small>
                </div>
                 <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('colegio')}">
                    <label>colegio<small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.colegio" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('colegio')" v-text="showError('colegio').errorDetail"></small>
                </div>
                 <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('anioegreso')}">
                    <label>anioegreso<small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.anioegreso" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('anioegreso')" v-text="showError('anioegreso').errorDetail"></small>
                </div>
                carrera
            </div>
            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.administrarcliente'}" class="btn waves-effect waves-light btn-info mr-2">
                <i class="fas fa-reply"></i> <span class="button-text">Atrás</span>
            </router-link>

            <div>
                <button type="button" class="btn btn-success waves-effect waves-light" @click="doSaveData">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
                <button type="reset" class="btn waves-effect waves-light btn-outline-secondary ml-2">
                    <i class="fa fa-window-close"></i> <span class="button-text">Cancelar</span>
                </button>
            </div>
        </template>

    </main-content>
</template>

<script>
    import MainContent from './../../utils/MainContent';
    import VueNumeric from 'vue-numeric';
    import VDatePicker from 'vue2-datepicker';
    // import accounting from 'accounting';
    import moment,{ now } from 'moment';
    import 'vue2-datepicker/locale/es';

    export default {
        props: {
            cardTitle: {
                default: 'cliente'
            },
            cliente: {
                type: Object,
                default() {
                    return {
                        nombres: '',
                        apellidos: '',
                        dni: '',
                        telefono: '',
                        carrera: '',
                        colegio:'',
                        anioegreso:'',
                    }
                }
            }
        },
        data(){
            return {
                errors:[]
            }
        },
        methods: {
            doSaveData() {

                if (this.validateFields().length > 0) {
                    return;
                }

                let clienteData = {
                    nombres: this.cliente.nombres,
                    apellidos: this.cliente.apellidos,
                    dni: this.cliente.dni,
                    telefono: this.cliente.telefono,
                    email: this.cliente.email,
                    carrera: this.cliente.carrera,
                    colegio: this.cliente.colegio,
                    anioegreso: this.cliente.anioegreso,
                    idcampania: this.cliente.idcampania,
                }

                this.$emit('saveData', clienteData);
            },

            validateFields() {
                this.errors = [];

                if (!this.cliente.nombres) {
                    this.setError('nombres', 'El campo nombres es obligatorio');
                }
                if (!this.cliente.apellidos) {
                    this.setError('apellidos', 'El campo apellidos es obligatorio');
                }
                if (!this.cliente.telefono) {
                    this.setError('telefono', 'El campo telefono es obligatorio');
                }

                return this.errors;
            },
            setError(keyModel, errorDetail) {
                this.errors.push({
                    keyModel: keyModel,
                    errorDetail: errorDetail
                });
            },
            errorExists(keyModel){
                return this.errors.filter(err => err.keyModel === keyModel).length;
            },
            showError(keyModel){
                return this.errors.find(err => err.keyModel === keyModel);
            },
           
        },
        components: {
            MainContent,
            VueNumeric,
            VDatePicker
        }
    }

</script>
