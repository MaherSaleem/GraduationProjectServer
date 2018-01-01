@extends('general')

@section('content')

    <div id="root" class="container">

        <label >
            <input name="question" type="text" v-model="message">
        </label>

        <button @click="func">Hit Me</button>
        <p>@{{message}}</p>

        <div id="result">
            <ul>
                <li v-for="result in results">
                    @{{result }}
                </li>
            </ul>
           @{{results}}
        </div>

    </div>

@endsection



@section('scripts')
    <script>

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
                message:"hello",
                results:"ss"
            },

            methods: {
                func(){
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

                    axios.post('/api/submissions/store',{
                        query:this.message
                    })
                        .then(function (response) {
                            this.results = response;
                            $.unblockUI();
                        }.bind(this))
                .catch(function (error) {
                            console.log(error);
                        });

                }
            },
            computed: {},
            mounted() {
            },
        });
    </script>
@endsection