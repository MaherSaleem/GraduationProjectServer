@extends('general')

@section('content')

    <div id="root" class="container align-items-center justify-content-center" style="width: auto">
        <div class="spinner icon-spinner-10" aria-hidden="true"></div>

        <div class="row">
            <div class="col-md-4 col-lg-offset-4">
                <div class="form-group centered">
                    <div id="custom-search-input" v-show="fetchDataShow" >
                        <div class="input-group col-md-12" >
                            <input type="text" id="query" class="form-control input-lg" v-model="query" @keyup.enter="func" placeholder="ما هو السعال؟"/>
                            <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i @click="func" v-show="fetchDataShow" class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div v-if="isResponseReturned" class="align-items-center">
            <h1 class="text-center">الرجاء اختيار الجواب الاقرب</h1>
            <h1 class="text-center">@{{results.query}}</h1>

            <form id="submission" class="form-group pull-right" method="post" :action="action" style="direction:RTL">
                {{method_field('PUT')}}
                <ul>
                    <li v-for="(result,index) in results.answers">
                        <div class="form-group">
                            <div class="">
                                <input type="checkbox" class="icheckbox" name="rank[]" :value=index>
                                <span v-html="result"></span>
                            </div>
                        </div>

                        <div>
                        <span style="color: white; font-size: 20px;">
                        </span>
                        </div>
                    </li>
                </ul>
                <input type="submit" id="submit" class="btn btn-success ajax-submit" value="Submit response">
            </form>

        </div>

    </div>

@endsection



@section('scripts')
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


        new Vue({
            el: "#root",
            data: {
                query: "",
                results: "s",
                isResponseReturned: false,
                action: "{{url("api/submissions")}}"
            },

            methods: {
                addOne(x){
                    console.log(x+1);
                    return x+1;
                },
                func() {
                    $.blockUI({
                        message : '<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i><br><span class="">Please Wait around 2 Minutes</span>',
                        overlayCSS: {
                            backgroundColor: '#1B2024',
                            opacity: 0.85,
                            cursor: 'wait',
                            'z-index': 99998
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'none',
                            color: '#fff',
                            'z-index': 99999
                        }
                    });

                    axios.post("{{url('/api/submissions')}}", {
                        query: this.query
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(function (response) {
                            this.results = response.data;
                            this.isResponseReturned = true;
                            this.action += "/" + this.results.submissionId;

                            this.$nextTick(function(){
                                $('input.icheckbox').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    radioClass: 'iradio_square-blue',
                                    increaseArea: '20%' // optional
                                });
                            })

                            $.unblockUI();
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });

                }
            },
            computed: {
                fetchDataShow() {
                    return !this.isResponseReturned;
                }
            },
            mounted() {
            },


        });
        Vue.nextTick(function () {
            // DOM updated
        })

    </script>
@endsection