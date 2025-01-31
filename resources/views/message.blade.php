@extends('layouts.app')

@section('content')

<v-card
            class="mx-auto my-8"
            elevation="16"
            max-width="1000"
    >
        <v-card-item>
            <v-card-title>
                Управление
            </v-card-title>
        </v-card-item>

        <v-card-actions class="pt-0">
            <v-btn
                    color="teal-accent-4"
                    text="Добавить комментарий"
                    @click="addNewCommentDialog = true"
            ></v-btn>
            <v-btn
                    color="teal-accent-4"
                    text="На главную"
                    :href="getUrl('/')"
            ></v-btn>
        </v-card-actions>
    </v-card>

<v-card
        class="mx-auto my-8"
        elevation="16"
        max-width="1000"
>
    <v-card-item>
        <v-card-title>
            @{{ message.title }}
        </v-card-title>

        <v-card-subtitle>
            @{{ message.summary }}
        </v-card-subtitle>
    </v-card-item>

    <v-card-text>
        @{{ message.content }}
    </v-card-text>
</v-card>

    <v-card
            class="mx-auto my-8"
            elevation="16"
            max-width="1000"
            class="align-start"
            style="width: 100%"
    >
        <v-card-item>
            <v-card-title>
                Комментарии
            </v-card-title>
        </v-card-item>

        <v-card-text>
            <template v-for="(comment, index) in comments"
                      :key="index"
            >
                <div>
                    <div style="font-size: 18px;">@{{ comment.author }}</div>
                    <div style="font-size: 14px; margin-bottom: 1rem">@{{ comment.comment }}</div>
                </div>
            </template>
        </v-card-text>

    </v-card>

<v-dialog
        v-model="addNewCommentDialog"
        max-width="400"
>
    <v-card
            title="Новый комментарий"
    >
        <v-card-text>
            <v-row dense>
                <v-col
                        cols="12"
                >
                    <v-text-field
                            label="Автор *"
                            required
                            :error-messages="newCommentAuthorError"
                            v-model="newCommentAuthor"
                            variant="solo"
                    ></v-text-field>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-textarea
                            label="Комментарий *"
                            required
                            :error-messages="newCommentError"
                            v-model="newComment"
                            variant="solo"
                    ></v-textarea>
                </v-col>
            </v-row>

            <small class="text-caption text-medium-emphasis">* обязательное поле</small>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                    text="Закрыть"
                    class="text-none"
                    @click="addNewCommentDialog = false"
            ></v-btn>

            <v-btn
                    color="primary"
                    class="text-none"
                    text="Сохранить"
                    @click="saveComment()"
            ></v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

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
                    message: {!! json_encode($message) !!},
                    comments: {!! json_encode($comments) !!},

                    addNewCommentDialog: false,

                    newCommentAuthor: null,
                    newCommentAuthorError: null,

                    newComment: null,
                    newCommentError: null
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
                },
                getUrl(url) {
                    return url
                },
                saveComment() {
                    let errorsCount = 0

                    if (!this.newCommentAuthor) {
                        this.newCommentAuthorError = "Пожалуйста, введите имя автора"
                        errorsCount++
                    }

                    if (!this.newComment) {
                        this.newCommentError = "Пожалуйста, введите комментарий"
                        errorsCount++
                    }

                    if (errorsCount > 0) {
                        return false
                    }

                    axios.post("/comment/add", {
                        message_id: this.message.id,
                        author: this.newCommentAuthor,
                        comment: this.newComment
                    })
                        .then((res) => {
                            if (res.data.status) {
                                this.addNewCommentDialog = false
                                this.newCommentAuthor = null
                                this.newComment = null
                                this.comments = res.data.comments
                            } else {
                                console.log(this.message)
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                },
            },
            watch: {
                newCommentAuthor(newVal, oldVal) {
                    this.newCommentAuthorError = null
                },
                newComment(newVal, oldVal) {
                    this.newCommentError = null
                }
            }
        })
        app.use(vuetify).mount('#app')
    </script>
@endsection