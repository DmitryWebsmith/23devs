@extends('layouts.app')

@section('content')
<div
        class="d-flex justify-center align-center"
        :style="{'height': height+'px'}">
    <h1 style="color: red">Page Not Found</h1>
</div>

@endsection

@section('js')
    <script>
        const { createApp } = Vue
        const { createVuetify } = Vuetify

        const vuetify = createVuetify()

        const app = createApp({
            data() {
                return {
                    height: null,
                }
            },
            mounted() {
                window.addEventListener('resize', this.getDimensions);

                this.height = document.documentElement.clientHeight - 90
            },
            unmounted() {
                window.removeEventListener('resize', this.getDimensions);
            },
            methods: {
                getDimensions() {
                    this.height = document.documentElement.clientHeight - 90;
                }
            }
        })
        app.use(vuetify).mount('#app')
    </script>
@endsection