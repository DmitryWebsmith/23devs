<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Тестовое задание ООО "23 программиста" </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="/css/vuetify.min.css" rel="stylesheet" />
    <script src="/js/vue.global.js"></script>
    <script src="/js/vuetify.min.js"></script>
    <script src="/js/axios.min.js"></script>
</head>
<body>
<div id="app">
    <v-responsive class="border rounded">
        <v-app>
            <v-app-bar
                    title="Тестовое задание ООО '23 программиста'"
                    color="#1A237E">

                <div>
                    <div class="d-flex justify-end">

                        <div class="d-md-none">
                            <!--                            hide on screens wider than md-->

                            <div class="ma-1" align="center">
                                <v-menu
                                        min-width="200px"
                                        rounded
                                >
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                                v-bind="props"
                                        >
                                            Меню
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-text>
                                            <div class="text-center">
                                                <v-btn href="https://i-am-web-artisan.ru/" class="text-none mt-2" target="_blank">Разработчик</v-btn>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-menu>
                            </div>

                        </div>
                        <!--                            hide on screens smaller than md-->
                        <div class="d-none d-md-block">
                            <v-sheet
                                    class="ma-2 pa-2"
                                    color="transparent"
                            >
                                <v-btn href="https://i-am-web-artisan.ru/" class="text-none" target="_blank">Разработчик</v-btn>
                            </v-sheet>
                        </div>
                    </div>
                </div>
            </v-app-bar>

            <div style="width: 100%;
        background-image: url('/images/landing-background-image.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;">
                <v-container>
                    <v-row
                            justify="center"
                            no-gutters
                    >
                        <v-col
                                :style="{'min-height': height+'px', 'margin-top': '3.5rem'}"
                        >
                            <v-sheet
                                    class="ma-0 pa-3"
                                    elevation="4"
                                    width="100%"
                                    height="100%"
                                    color="rgba(250, 250, 250, 0.8)"
                                    rounded
                            >
                                <div style="color: white">
                                    <div class="d-flex flex-row mb-6">
                                        <div class="ma-2 pa-2 mt-0 pt-0" style="font-size: 18px; width: 95%">
                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </v-sheet>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
        </v-app>

    </v-responsive>
</div>
@yield('js')
</body>
</html>
