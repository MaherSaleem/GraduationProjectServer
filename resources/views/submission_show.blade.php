@extends('general')

@section('content')

    <div id="root" class="container">
        <div class="spinner icon-spinner-10" aria-hidden="true"></div>
        <label>
            <input name="question" type="text" v-model="message">
        </label>

        <button @click="func" v-show="fetchDataShow" id="fetchData">Hit Me</button>
        <p>@{{message}}</p>

        <div id="answers" >

        </div>

        <div v-if="isResponseReturned">
{{--            @include('answers', 'answers')--}}
            <h1>الرجاء اختيار الجواب الاقرب</h1>
            <h2>@{{results.questionText}}</h2>

            <form id="submission" method="post" :action="action">
                {{method_field('PUT')}}
                <ul>
                    <li v-for="(result,index) in results.answers">
                        <div class="form-group">
                            <input type="checkbox" class="" name="rank[]" :value=index+1>
                            <span>
                        @{{ result }}
                        </span>
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
                action:"{{url("api/submissions")}}"
            },

            methods: {
                func() {
                    $.blockUI({
                        message: '<i class="fa fa-spinner fa-spin fa-5x fa-fw"></i><br><span class="">Please Wait around 2 Minutes</span>',
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
                            this.action+="/"+this.results.submissionId;

                            $.unblockUI();
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });

                }
            },
            computed: {
                fetchDataShow(){
                    return !this.isResponseReturned;
                }
            },
            mounted() {
            },
        });
    </script>
@endsection