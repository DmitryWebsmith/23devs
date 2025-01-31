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
                    text="Добавить сообщение"
                    @click="addNewMessageDialog = true"
            ></v-btn>
        </v-card-actions>
    </v-card>

<template v-for="(message, index) in messages"
          :key="index"
          variant="text"
          class="align-start"
          style="width: 100%"
>
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

        <v-card-actions class="pt-0">
            <v-btn
                    color="teal-accent-4"
                    text="Открыть"
                    :href="getUrl('/message/show/'+message.id)"
            ></v-btn>
            <v-btn
                    color="teal-accent-4"
                    text="Редактировать"
                    @click="editMessage(message)"
            ></v-btn>
            <v-btn
                    color="#F44336"
                    text="Удалить"
                    @click="deleteMessage(message.id)"
            ></v-btn>
        </v-card-actions>
    </v-card>
</template>

<v-dialog
        v-model="addNewMessageDialog"
        max-width="400"
>
    <v-card
            title="Новое сообщение"
    >
        <v-card-text>
            <v-row dense>
                <v-col
                        cols="12"
                >
                    <v-text-field
                            label="Автор *"
                            required
                            :error-messages="newMessageAuthorError"
                            v-model="newMessageAuthor"
                            variant="solo"
                    ></v-text-field>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-text-field
                            label="Заголовок *"
                            required
                            :error-messages="newMessageTitleError"
                            v-model="newMessageTitle"
                            variant="solo"
                    ></v-text-field>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-textarea
                            label="Краткое содержание *"
                            required
                            :error-messages="newMessageSummaryError"
                            v-model="newMessageSummary"
                            variant="solo"
                    ></v-textarea>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-textarea
                            label="Полное содержание *"
                            required
                            :error-messages="newMessageContentError"
                            v-model="newMessageContent"
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
                    @click="addNewMessageDialog = false"
            ></v-btn>

            <v-btn
                    color="primary"
                    class="text-none"
                    text="Сохранить"
                    @click="saveNewMessage()"
            ></v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<v-dialog
        v-model="editMessageDialog"
        max-width="400"
>
    <v-card
            title="Редактирование сообщения"
    >
        <v-card-text>
            <v-row dense>
                <v-col
                        cols="12"
                >
                    <input type="hidden" id="message_id" value="">
                    <v-text-field
                            label="Автор *"
                            required
                            :error-messages="editMessageAuthorError"
                            v-model="editMessageAuthor"
                            variant="solo"
                    ></v-text-field>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-text-field
                            label="Заголовок *"
                            required
                            :error-messages="editMessageTitleError"
                            v-model="editMessageTitle"
                            variant="solo"
                    ></v-text-field>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-textarea
                            label="Краткое содержание *"
                            required
                            :error-messages="editMessageSummaryError"
                            v-model="editMessageSummary"
                            variant="solo"
                    ></v-textarea>
                </v-col>

                <v-col
                        cols="12"
                >
                    <v-textarea
                            label="Полное содержание *"
                            required
                            :error-messages="editMessageContentError"
                            v-model="editMessageContent"
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
                    @click="editMessageDialog = false"
            ></v-btn>

            <v-btn
                    color="primary"
                    class="text-none"
                    text="Сохранить"
                    @click="saveEditMessage()"
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
                    messages: {!! json_encode($messages) !!},

                    addNewMessageDialog: false,
                    editMessageDialog: false,

                    newMessageAuthor: null,
                    newMessageAuthorError: null,

                    newMessageTitle: null,
                    newMessageTitleError: null,

                    newMessageSummary: null,
                    newMessageSummaryError: null,

                    newMessageContent: null,
                    newMessageContentError: null,

                    editMessageAuthor: null,
                    editMessageAuthorError: null,

                    editMessageTitle: null,
                    editMessageTitleError: null,

                    editMessageSummary: null,
                    editMessageSummaryError: null,

                    editMessageContent: null,
                    editMessageContentError: null,
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
                deleteMessage(messageId) {
                    axios.post("/message/delete", {
                        message_id: messageId
                    })
                        .then((res) => {
                            if (res.data.status) {
                                this.messages = res.data.messages
                            } else {
                                console.log(this.message)
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                },
                saveNewMessage() {
                    let errorsCount = 0

                    if (!this.newMessageAuthor) {
                        this.newMessageAuthorError = "Пожалуйста, введите имя автора"
                        errorsCount++
                    }

                    if (!this.newMessageTitle) {
                        this.newMessageTitleError = "Пожалуйста, введите заголовок сообщения"
                        errorsCount++
                    }

                    if (!this.newMessageSummary) {
                        this.newMessageSummaryError = "Пожалуйста, введите краткое содержание"
                        errorsCount++
                    }

                    if (!this.newMessageContent) {
                        this.newMessageContentError = "Пожалуйста, введите полное содержание"
                        errorsCount++
                    }

                    if (errorsCount > 0) {
                        return false
                    }

                    axios.post("/message/add", {
                        author: this.newMessageAuthor,
                        title: this.newMessageTitle,
                        summary: this.newMessageSummary,
                        content: this.newMessageContent
                    })
                        .then((res) => {
                            if (res.data.status) {
                                this.addNewMessageDialog = false
                                this.newMessageAuthor = null
                                this.newMessageTitle = null
                                this.newMessageSummary = null
                                this.newMessageContent = null
                                this.messages = res.data.messages
                            } else {
                                console.log(this.message)
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                },
                editMessage(message) {
                    this.editMessageAuthor = message.author
                    this.editMessageTitle = message.title
                    this.editMessageSummary = message.summary
                    this.editMessageContent = message.content
                    this.editMessageDialog = true
                    this.$nextTick(() => {
                            document.querySelector("#message_id").value = message.id
                        }
                    );

                },
                saveEditMessage() {
                    let errorsCount = 0

                    if (!this.editMessageAuthor) {
                        this.newMessageAuthorError = "Пожалуйста, введите имя автора"
                        errorsCount++
                    }

                    if (!this.editMessageTitle) {
                        this.newMessageTitleError = "Пожалуйста, введите заголовок сообщения"
                        errorsCount++
                    }

                    if (!this.editMessageSummary) {
                        this.newMessageSummaryError = "Пожалуйста, введите краткое содержание"
                        errorsCount++
                    }

                    if (!this.editMessageContent) {
                        this.newMessageContentError = "Пожалуйста, введите полное содержание"
                        errorsCount++
                    }

                    if (errorsCount > 0) {
                        return false
                    }

                    axios.post("/message/edit", {
                        id: document.querySelector("#message_id").value,
                        author: this.editMessageAuthor,
                        title: this.editMessageTitle,
                        summary: this.editMessageSummary,
                        content: this.editMessageContent
                    })
                        .then((res) => {
                            if (res.data.status) {
                                this.editMessageDialog = false
                                this.editMessageAuthor = null
                                this.editMessageTitle = null
                                this.editMessageSummary = null
                                this.editMessageContent = null
                                this.messages = res.data.messages
                            } else {
                                console.log(this.message)
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                }
            },
            watch: {
                newMessageAuthor(newVal, oldVal) {
                    this.newMessageAuthorError = null
                },
                newMessageTitle(newVal, oldVal) {
                    this.newMessageTitleError = null
                },
                newMessageSummary(newVal, oldVal) {
                    this.newMessageSummaryError = null
                },
                newMessageContent(newVal, oldVal) {
                    this.newMessageContentError = null
                },
                editMessageAuthor(newVal, oldVal) {
                    this.editMessageAuthorError = null
                },
                editMessageTitle(newVal, oldVal) {
                    this.editMessageTitleError = null
                },
                editMessageSummary(newVal, oldVal) {
                    this.editMessageSummaryError = null
                },
                editMessageContent(newVal, oldVal) {
                    this.editMessageContentError = null
                }
            }
        })
        app.use(vuetify).mount('#app')
    </script>
@endsection