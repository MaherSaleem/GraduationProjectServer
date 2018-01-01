@extends('general')

@section('content')

    <div id="root" class="container align-items-center justify-content-center">
        <div class="spinner icon-spinner-10" aria-hidden="true"></div>


        {{--<div class="row align-items-center" id="custom-search-form">--}}
        {{--<input name="question" type="text" v-model="message" class="search-query mac-style input-lg">--}}
        {{--<a @click="func" v-show="fetchDataShow" href="#" class="btn btn-default btn-group-vertical">--}}
        {{--<span class="glyphicon glyphicon-search"></span>--}}
        {{--</a>--}}
        {{--</div>--}}

        {{--<div class="row col-centered">--}}
            {{--<div class="col-md-4 col-lg-offset-4">--}}

            {{--</div>--}}
        {{--</div>--}}

        <div class="form-group centered">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder=""/>
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i @click="func" v-show="fetchDataShow" class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div v-if="isResponseReturned" class="align-items-center pull-right">
            <h1>الرجاء اختيار الجواب الاقرب</h1>

            <form id="submission" method="post" :action="action" style="direction:RTL">
                {{method_field('PUT')}}
                <ul>
                    <li v-for="(result,index) in results.answers">
                        <div class="form-group">
                            <input type="checkbox" class="" name="rank[]" :value=index+1>
                            <span v-html="result"></span>
                        </div>

                        <div class="form-group">
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

        Vue.component('foobar', {
                props: ['title', 'text'],
                data() {
                    return {};
                },

                methods: {},
                template:
                    `
                <div>foobar</div>
              `
            },
        );


        new Vue({
            el: "#root",
            data: {
                message: "ما هو السعال؟",
                results: "s",
                isResponseReturned: false,
                action: "{{url("api/submissions")}}"
            },

            methods: {
                func() {
                    $.blockUI({
                        message: '<i class="icon-spinner10 icon-3x spinner"></i>',
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

                    axios.post('/api/submissions', {
                        query: this.message
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(function (response) {
                            this.results = response.data;
                            this.isResponseReturned = true;
                            this.action += "/" + this.results.submissionId;

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
    </script>
@endsection