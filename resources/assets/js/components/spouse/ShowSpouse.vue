<script>
import { dateInputMaskAll, flashErrors } from "../../helper.js";
	export default{
		props:[
            'spouse',
            'cities',
            'affiliateId'
        ],
        data(){
            return{
                editing: false,
                show_spinner: false,
                form:this.spouse,
                city_birth: !!this.spouse.city_birth?this.spouse.city_birth:null,
                city_identity_card: !!this.spouse.city_identity_card?this.spouse.city_identity_card:null,
                values:{
                    identity_card:!! this.spouse.identity_card ? this.spouse.identity_card :null ,
                    resgistration:!! this.spouse.resgistration ? this.spouse.resgistration :null ,
                    first_name: !! this.spouse.first_name ? this.spouse.first_name :null ,
                    second_name: !! this.spouse.second_name ? this.spouse.second_name :null ,
                    last_name: !! this.spouse.last_name ? this.spouse.last_name :null ,
                    mothers_last_name: !! this.spouse.mothers_last_name ? this.spouse.mothers_last_name :null ,
                    surname_husband: !! this.spouse.surname_husband ? this.spouse.surname_husband :null ,
                    civil_status: !! this.spouse.civil_status ? this.spouse.civil_status :null ,
                    birth_date: !! this.spouse.birth_date ? this.spouse.birth_date :null ,
                }
            }
        },
        computed:{
            age: function(){
                if(this.form.birth_date!=null){
                    if (this.form.birth_date.includes('y') || this.form.birth_date.includes('m') || this.form.birth_date.includes('d') ) {
                        return ''
                    }

                    if(this.form.birth_date){
                        return moment(this.form.birth_date, "DD/MM/YYYY").fromNow(true)
                    }else
                    {
                        return '';
                    }
                }
            },
            city_birth_name: function(){
                return !!this.city_birth?this.city_birth.name:'';
            },
            city_identity_card_name: function(){
                return !!this.city_identity_card?this.city_identity_card.first_shortened:'';
            },
            civil_status_name:function(){
                var st = '';
                switch(this.form.civil_status)
                {
                    case "S":
                        st= 'Soltero(a)';
                        break;
                    case "D":
                        st= 'Divorciado(a)';
                        break;
                    case "V":
                        st= 'Viudo(a)';
                        break;

                    case "C":
                        st= 'Casado(a)';
                        break;  
                }
                return st;
            },
            validAll(){
                if (this.$validator.errors.collect() == {}) {
                    return false;
                }
                return Object.keys(this.$validator.errors.collect()).length > 0;
            }

        },
        methods:{
            async validateBeforeSubmit() {
                try {
                    await this.$validator.validateAll();
                } catch (error) {
                    console.log("some error");
                }
            },
            get_city_birth_name:function(city_birth){
                var name='';
                let city_birth_id =city_birth;
                this.cities.forEach(function(city) {
                    if(city.id==city_birth_id){
                        name = city.name;
                    }
                });
                return name;
            },
            get_city_first_shortened:function(){
                var name='';
                let city_identity_card =this.city_identity_card;
                this.cities.forEach(function(city) {
                    if(city.id==city_identity_card){
                        name = city.first_shortened;
                    }
                });
                return name;
            },
            toggle_editing:function () {
                this.editing = !this.editing;
                dateInputMaskAll();
                if(this.editing==false)
                {
                    this.form.identity_card = this.values.identity_card;
                    this.form.first_name =  this.values.first_name;
                    this.form.second_name =  this.values.second_name;
                    this.form.last_name =  this.values.last_name;
                    this.form.mothers_last_name =  this.values.mothers_last_name;
                    this.form.surname_husband = this.values.surname_husband;
                    this.form.civil_status = this.values.civil_status;
                    this.form.birth_date =  this.values.birth_date;
                    this.form.city_birth_id = !!this.city_birth ? this.city_birth.id : null;
                    this.form.city_identity_card_id = !!this.city_identity_card ? this.city_identity_card.id : null;
                    this.form.registration = this.values.registration;
                }else{
                    this.validateBeforeSubmit();
                }
            },
            update () {
                this.validateBeforeSubmit();
                if (this.validAll) {
                    flash("Debe completar el formulario", 'error')
                    return;
                }
                let uri = `/update_spouse/${this.affiliateId}`;
                this.show_spinner=true;
                axios.patch(uri,this.form)
                    .then(response=>{
                        this.editing = false;
                        this.show_spinner=false;
                        this.form = response.data.spouse;
                        this.city_birth = response.data.city_birth;
                        this.city_identity_card = response.data.city_identity_card; 
                        this.values.identity_card = response.data.spouse.identity_card;
                        this.values.resgistration = response.data.spouse.resgistration;
                        this.values.first_name =  response.data.spouse.first_name;
                        this.values.second_name =  response.data.spouse.second_name;
                        this.values.last_name =  response.data.spouse.last_name;
                        this.values.mothers_last_name =  response.data.spouse.mothers_last_name;
                        this.values.surname_husband = response.data.spouse.surname_husband;
                        this.values.birth_date =  response.data.spouse.birth_date;
                        this.values.civil_status = response.data.spouse.civil_status;

                        flash('Informacion de Esposa(o) Actualizada');
                    }).catch((error)=>{
                        this.show_spinner=false;
                        this.toggle_editing();
                        flashErrors('Error al actualizar el afiliado',error.response.data.errors)
                    })
            }
        }
	}
</script>